<?php 
//var_dump($data);

$saldo = $data['saldoDebe'] - $data['saldoHaber'];
//echo $data['saldoHaber'];
?>
<table  class="table table-bordered table-hover">
    <tr>
        <td></td>
        <td><b>Saldo Debe - Haber</b></td>
        <td style="text-align: right"><b><?php echo number_format($data['saldoDebe'], 4, ',', '.');?></b></td>
        <td style="text-align: right"><b><?php echo number_format($data['saldoHaber'], 4, ',', '.');?></b></td>
        <td style="text-align: right"><b><?php echo number_format($saldo, 4, ',', '.');?></b></td>
    </tr>
    <?php
        foreach($data['debe'] as $item){
            $fecha = explode(' ',$item['fecha']);
            $fecha[0] = explode('-', $fecha[0]);
            $fecha[0] = $fecha[0][2].'-'.$fecha[0][1].'-'.$fecha[0][1];
            echo '<tr>
                    <td>'.$fecha[0].' '.$fecha[1].'</td>';
            if($item['tipo'] == '1'){
                echo '
                <td>Remito '.$item['id'].'</td>
                <td style="text-align: right">'.number_format($item['total'], 4, ',', '.').'</td>
                <td style="text-align: right"></td>';
                $saldo += $item['total'];
            }else {
                echo '
                <td>Pago  '.$item['id'].'</td>
                <td style="text-align: right"></td>
                <td style="text-align: right">'.number_format($item['total'], 4, ',', '.').'</td>';
                $saldo -= $item['total'];
            }
            echo ' <td style="text-align: right">'.number_format($saldo, 4, ',', '.').'</td>
                </tr>';
        }
    ?>
</table>