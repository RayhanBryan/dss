<div class="page-header">
    <h1>Nilai Bobot Kriteria</h1>
</div>
<?php
if($_POST) include'aksi.php';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" method="post">
            <div class="form-group">
                <select class="form-control" name="ID1">
                <?=get_kriteria_option( $_POST['ID1'])?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="nilai">
                <?=AHP_get_nilai_option($_POST['nilai'])?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="ID2">
                <?=get_kriteria_option( $_POST['ID2'])?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">            
        <table class="table table-bordered table-hover table-striped">
            <thead><tr>
                <th>Kode</th>
                <th>Nama</th>
                <?php foreach($KRITERIA as $key => $val):?>
                <th><?=$key?></th>
                <?php endforeach?>
            </tr></thead>
            <tbody>
            <?php
            $data = get_rel_kriteria();  
            $kolom_total = get_kolom_total($data); 
            $a=1;
            foreach($data as $key => $val):?>
            <tr>
                <td><?=$key?></td>
                <td><?=$KRITERIA[$key]['nama_kriteria']?></td>
                <?php  
                    $b=1;
                    foreach($val as $k => $v){ 
                        if( $key == $k ) 
                            $class = 'success';
                        elseif($b > $a)
                            $class = 'danger';
                        else
                            $class = '';
                            
                        echo "<td class='$class'>".round($v, 3)."</td>";   
                        $b++;            
                    } 
                    $no++;       
                ?>
            </tr>
            <?php $a++; endforeach;?>
            </tbody>        
        </table>
    </div>
    
  
</div>