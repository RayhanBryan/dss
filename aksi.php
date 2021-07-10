<?php
require_once 'functions.php';
/** LOGIN **/
if($act=='login'){
    $user = esc_field($_POST[user]);
    $pass = esc_field($_POST[pass]);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if($row){
        $_SESSION[login] = $row->user;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    } 
}else if ($mod=='password'){
    $pass1 = $_POST[pass1];
    $pass2 = $_POST[pass2];
    $pass3 = $_POST[pass3];
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
    
    if($pass1=='' || $pass2=='' || $pass3=='')
        print_msg('Field bertanda * harus diisi.');
    elseif(!$row)
        print_msg('Password lama salah.');
    elseif($pass2!=$pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else{        
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
        print_msg('Password berhasil diubah.', 'success');
    }
}elseif($act=='logout'){
    unset($_SESSION[login]);
    header("location:login.php");
} 
/** ALTERNATIF */
elseif($mod=='alternatif_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    if($kode=='' || $nama=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_alternatif (kode_alternatif, nama_alternatif, keterangan,lat,lng) 
        VALUES ('$kode', '$nama', '$keterangan', '$lat', '$lng')");
        $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria, kode_crips) 
        SELECT '$kode', kode_kriteria, 0 FROM tb_kriteria");       
        redirect_js("index.php?m=alternatif");
    }
} else if($mod=='alternatif_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    if($kode=='' || $nama=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_alternatif SET nama_alternatif='$nama', keterangan='$keterangan',lat='$lat',lng='$lng' 
        WHERE kode_alternatif='$_GET[ID]'");
        redirect_js("index.php?m=alternatif");
    }
} else if ($act=='alternatif_hapus'){
    $db->query("DELETE FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_alternatif WHERE kode_alternatif='$_GET[ID]'");
    header("location:index.php?m=alternatif");
} 

/** KRITERIA */    
if($mod=='kriteria_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $atribut = $_POST['atribut'];
    $maps = $_POST['maps'];
    
    if($kode=='' || $nama=='' || $atribut=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_kriteria (kode_kriteria, nama_kriteria, atribut,maps) VALUES ('$kode', '$nama', '$atribut','$maps')");              
        $db->query("INSERT INTO tb_rel_alternatif(kode_alternatif, kode_kriteria, kode_crips) SELECT kode_alternatif, '$kode', 0  FROM tb_alternatif");          
        $db->query("INSERT INTO tb_rel_kriteria(ID1, ID2, nilai) 
            SELECT '$kode', kode_kriteria, 1 FROM tb_kriteria");
        $db->query("INSERT INTO tb_rel_kriteria(ID1, ID2, nilai) 
            SELECT kode_kriteria, '$kode', 1 FROM tb_kriteria WHERE kode_kriteria<>'$kode'"); 
        redirect_js("index.php?m=kriteria");
    }                    
} else if($mod=='kriteria_ubah'){
    $nama = $_POST['nama'];
    $atribut = $_POST['atribut'];
    $maps = $_POST['maps'];
    
    if($nama=='' || $atribut=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kriteria WHERE kode_kriteria='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("UPDATE tb_kriteria SET nama_kriteria='$nama', atribut='$atribut',maps='$maps' WHERE kode_kriteria='$_GET[ID]'");
        redirect_js("index.php?m=kriteria");
    }    
} else if ($act=='kriteria_hapus'){
    $db->query("DELETE FROM tb_kriteria WHERE kode_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_alternatif WHERE kode_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_crips WHERE kode_kriteria='$_GET[ID]'");
    $db->query("DELETE FROM tb_rel_kriteria WHERE ID1='$_GET[ID]' OR ID2='$_GET[ID]'");
    header("location:index.php?m=kriteria");
} elseif($mod=='rel_kriteria'){
    $ID1 = $_POST['ID1'];
    $ID2 = $_POST['ID2'];
    $nilai = abs($_POST['nilai']);
    
    if($ID1==$ID2 && $nilai<>1){
        print_msg('Kriteria sama harus bernilai 1!');
    } else {        
        $db->query("UPDATE tb_rel_kriteria SET nilai=$nilai
            WHERE ID1='$ID1' AND ID2='$ID2'");               
        $db->query("UPDATE tb_rel_kriteria SET nilai=1/$nilai
            WHERE ID1='$ID2' AND ID2='$ID1'");
        print_msg('Data tersimpan!', 'success');
    }
}

/** CRIPS */    
if($mod=='crips_tambah'){
    $nilai = $_POST['nilai'];
    $keterangan = $_POST['keterangan'];
    
    if($nilai=='' || $keterangan=='')
        print_msg("Nilai dan nama tidak boleh kosong!");
    else{
        $db->query("INSERT INTO tb_crips (kode_kriteria, nilai, keterangan) 
        VALUES ('$_POST[kode_kriteria]', '$nilai', '$keterangan')");           
        redirect_js("index.php?m=crips&kode_kriteria=$_GET[kode_kriteria]");
    }                  
} else if($mod=='crips_ubah'){
    $nilai = $_POST['nilai'];
    $keterangan = $_POST['keterangan'];
    
    if($nilai=='' || $keterangan=='')
        print_msg("Nilai dan nama tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_crips SET nilai='$nilai', keterangan='$keterangan' WHERE kode_crips='$_GET[ID]'");
        redirect_js("index.php?m=crips&kode_kriteria=$_GET[kode_kriteria]");
    }   
} else if ($act=='crips_hapus'){
    $db->query("DELETE FROM tb_crips WHERE kode_crips='$_GET[ID]'");
    header("location:index.php?m=crips&kode_kriteria=$_GET[kode_kriteria]");
} 

/** RELASI ALTERNATIF */ 
else if ($act=='rel_alternatif_ubah'){
  
    foreach($_POST as $key => $value){
        $ID = str_replace('ID-', '', $key);
        $db->query("UPDATE tb_rel_alternatif SET kode_crips='$value' WHERE ID='$ID'"); 
    }
    header("location:index.php?m=rel_alternatif");
}

/** RELASI KRITERIA */
else if ($act=='rel_kriteria_ubah'){
    $ID1 = $_POST['ID1'];
    $ID2 = $_POST['ID2'];
    $nilai = abs($_POST['nilai']);
    
    if($ID1==$ID2 && $nilai<>1)
        print_error("Kriteria yang sama harus bernilai 1.");
        
    $db->query("UPDATE tb_rel_kriteria SET nilai=$nilai WHERE ID1='$ID1' AND ID2='$ID2'");
    $db->query("UPDATE tb_rel_kriteria SET nilai=1/$nilai WHERE ID2='$ID1' AND ID1='$ID2'");
    header("location:index.php?m=rel_kriteria");
}

?>
