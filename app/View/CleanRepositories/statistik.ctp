<h2>Statistik Data Training</h2>
<?php 
    $hasil= array(); 
    $total = 0;
    $hasil['belum'] = 0;
    foreach($data as $d){
        if($d['CleanRepository']['sentiment'] != null){
            $hasil[$d['CleanRepository']['sentiment']] = $d[0]['jum'];
        }else{
            $hasil['belum'] = $d[0]['jum'];
            
        }
        $total += $d[0]['jum'];
    }
    
?>
<div class="table">
<table class="table table-condensed">
    <thead>
        <tr>
            <th>Sentiment</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <tr class="success">
            <td>Belum Diindentifikasi</td>
            <td><?php echo $hasil['belum'];?></td>
        </tr>
        <tr class="info">
            <td >Positif</td>
            <td><?php echo $hasil['positif'];?></td>
        </tr>
        <tr class="warning">
            <td>Netral</td>
            <td><?php echo $hasil['netral'];?></td>
        </tr>
        <tr class="error">
            <td>Negatif</td>
            <td><?php echo $hasil['negatif'];?></td>
        </tr>
        <tr >
            <td>Total</td>
            <td><?php echo $total;?></td>
        </tr>
    </tbody>
</table>
</div>