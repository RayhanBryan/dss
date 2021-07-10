<div class="page-header">
    <h1>Kriteria</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">        
        <form class="form-inline">
            <input type="hidden" name="m" value="kriteria" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=kriteria_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
            <div class="form-group">
                <a class="btn btn-default" target="_blank" href="cetak.php?m=kriteria&q=<?=$_GET['q']?>"><span class="glyphicon glyphicon-print"></span> Cetak</a>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Kriteria</th>
            <th>Atribut</th>
            <th>Bobot</th>
            <th>Maps</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <?php
     $nilai = array(
        'jarak' => 'Jarak',
        'jumlah' => 'Jumlah',
        'tidak' => 'Tidak'
    );
    $q = esc_field($_GET['q']);
    $rows = $db->get_results("SELECT * FROM tb_kriteria WHERE nama_kriteria LIKE '%$q%' ORDER BY kode_kriteria");
    $no=0;
    foreach($rows as $row):?>
    <tr>
        <td><?=++$no ?></td>
        <td><?=$row->kode_kriteria?></td>
        <td><?=$row->nama_kriteria?></td>
        <td><?=$row->atribut?></td>
        <td><?=$row->bobot?></td>
        <td><?=$nilai[$row->maps]?></td>
        <td>
            <a class="btn btn-xs btn-warning" href="?m=kriteria_ubah&ID=<?=$row->kode_kriteria?>"><span class="glyphicon glyphicon-edit"></span></a>
            <a class="btn btn-xs btn-danger" href="aksi.php?act=kriteria_hapus&ID=<?=$row->kode_kriteria?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
        </td>
    </tr>
    <?php endforeach;
    ?>
    </table>
</div>