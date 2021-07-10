<div class="page-header">
    <h1>Tambah Crips</h1>
</div>
<div class="row">
<div class="col-sm-6">
<?php if($_POST) include'aksi.php'?>
<form method="post" action="?m=crips_tambah&kode_kriteria=<?=$_GET[kode_kriteria]?>">
<div class="form-group">
    <label>Kriteria</label>
    <select class="form-control" name="kode_kriteria"><?=get_kriteria_option($_GET[kode_kriteria])?></select>
</div>
<div class="form-group">
    <label>Nama</label>
    <input class="form-control" type="text" name="keterangan" value="<?=$_POST[keterangan]?>" />
</div>
<div class="form-group">
    <label>Nilai</label>
    <input class="form-control" type="text" name="nilai" value="<?=$_POST[nilai]?>" />
</div>
<button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
<a class="btn btn-danger" href="?m=crips&kode_kriteria=<?=$_GET[kode_kriteria]?>">
<span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
</form>
</div>
</div>