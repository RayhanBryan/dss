<h1>Perhitungan</h1>
<?php         
$normal = SAW_nomalize(SAW_get_rel(false));
?>

<table class="table table-bordered table-striped table-hover">
<?php        
echo"<tr><th></th>";   	
$no=1;	
foreach($normal[key($normal)] as $key => $value){
    echo"<th>".$KRITERIA[$key][nama_kriteria]."</th>";
    $no++;      
}            
echo"<th>Total</th><th>Rank</th>";
echo"</tr>";

echo"<tr><th>Bobot</th>";  
foreach($KRITERIA as $key => $value){
    echo "<td class='text-primary'>".$value['bobot']."</td>";
} 
echo "<th></th><th></th></tr>";
$total = hitung($normal);        
$rank = get_rank($total);

foreach($normal as $key => $value){
    echo"<tr>";
    echo"<th>$ALTERNATIF[$key]</th>";
    $tot=0;
    foreach($value as $k => $v){                           
        $tot+=$v * $KRITERIA[$k]['bobot'];                                 
        echo "<td>".round($v * $KRITERIA[$k]['bobot'], 3 )."</td>";
    }        
    echo "<td class='text-primary'>".round($total[$key], 3)."</td>";
    echo "<td class='text-primary'>".$rank[$key]."</td>";
    echo "</tr>";
    $no++;    
}                            
?>
</table>      