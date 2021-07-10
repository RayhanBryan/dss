<?php
$row = $db->get_row("SELECT * FROM tb_alternatif WHERE kode_alternatif='$_GET[ID]'");
?>
<div class="page-header">
    <h1 class="entry-title"><?=$row->nama_alternatif?> <small><a href="?">Lihat semua &raquo;</a></small></h1>
</div>
<div class="entry-body">
<?=$row->keterangan?>
</div>