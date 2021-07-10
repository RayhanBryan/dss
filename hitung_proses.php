<?php
    $rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif WHERE kode_alternatif IN ('".implode("','", $ID)."') ORDER BY kode_alternatif");
    foreach($rows as $row){
        $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
    }

    $c = $db->get_results("SELECT * FROM tb_rel_alternatif WHERE kode_crips NOT IN (SELECT kode_crips FROM tb_crips)");
    if (!$ALTERNATIF || !$KRITERIA):
        echo "Tampaknya anda belum mengatur alternatif dan kriteria. Silahkan tambahkan minimal 3 alternatif dan 3 kriteria.";
    elseif ($c):
        echo "Tampaknya anda belum mengatur nilai alternatif. Silahkan atur pada menu <strong>Nilai Alternatif</strong>.";
    else:
?>
<div class="panel panel-primary">
    <div class="panel-heading"><strong>Hasil Analisa</strong></div>
    <div class="panel-body oxa"> 
        <table class="table table-bordered table-striped table-hover">
        <?php                                            
            echo SAW_step1($ID);                    
        ?>
        </table>
        <table class="table table-bordered table-striped table-hover">      
        <?php    
            echo SAW_step2($ID);
        ?>
        </table>
    </div>
</div>

<div class="panel panel-primary">
    <div class="panel-heading"><strong>Normalisasi</strong></div>
    <div class="panel-body oxa">
        <table class="table table-bordered table-striped table-hover">
        <?php    
                    
        $normal = SAW_nomalize(SAW_get_rel($ID));
        
        $r.= "<tr><th></th>";   	
        $no=1;	
        foreach($normal[key($normal)] as $key => $value){
            $r.= "<th>$key</th>";
            $no++;      
        }    
        
        $no=1;	
        foreach($normal as $key => $value){
            $r.= "<tr>";
            $r.= "<th>$key</th>";
            foreach($value as $k => $v){
                $r.= "<td>".round($v,2)."</td>";
            }        
            $r.= "</tr>";
            $no++;    
        }    
        $r.= "</tr>"; 
        echo  $r;
        ?>
        </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading"><strong>Perangkingan</strong></div>
    <div class="panel-body oxa">
        <table class="table table-bordered table-striped table-hover">
        <?php        
        reset($normal);                
        
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
        <div class="form-group">
            <a class="btn btn-default" target="_blank" href="cetak.php?m=hitung"><span class="glyphicon glyphicon-print"></span> Cetak</a>
        </div> 
    </div>
</div>
<style>
    .text-primary{font-weight: bold;}
</style>
<?php endif?>
