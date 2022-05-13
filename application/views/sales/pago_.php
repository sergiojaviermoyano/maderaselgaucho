<section class="content">
    <div class="row">
        <div class="col-xs-2">
            N° Orden:
        </div>
        <div class="col-xs-2">
            <b><?php echo $data['orden']['opId'];?></b>
        </div>
        <div class="col-xs-2">
            Fecha: 
        </div>
        <div class="col-xs-6">
            <b><?php echo date_format(date_create($data['orden']['opFecha']), 'd-m-Y  H:i');?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            Observación:
        </div>
        <div class="col-xs-10">
            <b><?php echo $data['orden']['opObservacion'];?></b>
        </div>
    </div>
    <hr>
    <h3>Detalle</h3>
    <table class="table table-bordered table-hover">
        <thead>
              <tr >
                <th style="text-align: center" width="15%">Medio de Pago</th>
                <th style="text-align: center" width="20%">Importe</th>
                <th style="text-align: center" width="20%">Número</th>
                <th style="text-align: center" width="20%">Banco</th>
                <th style="text-align: center" width="25%">Vencimiento</th>
              </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data['ordenDetalle'] as $d) {
                    echo '<tr>';
                    echo '<td>'.($d['opMedPago'] == 'EF' ? 'Efectivo':'Cheque').'</td>';
                    echo '<td style="text-align: right">'.number_format($d['opImportePago'],2,',','.').'</td>';
                    echo '<td style="text-align: right">'.($d['cheNumero'] == null ? '-': $d['cheNumero']).'</td>';
                    echo '<td>'.($d['bancoDescripcion'] == null ? '-': $d['bancoDescripcion']).'</td>';
                    echo '<td style="text-align: center">'.($d['cheVencimiento'] == null ? '-': date_format(date_create($d['cheVencimiento']), 'd-m-Y')).'</td>';
                    echo '</tr>';
                  }
            ?>
        </tbody>
    </table>
</section>
<?php //var_dump($data);?>