<h1>Kriteria</h1>
<table>
<thead>
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama Kriteria</th>
        <th>Atribut</th>
        <th>Bobot</th>
    </tr>
</thead>
<?php
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
</tr>
<?php endforeach;
?>
</table>