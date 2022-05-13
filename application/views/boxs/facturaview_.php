<section class="content">
    <div class="row">
        <div class="col-xs-4">
            <b>
                <?php
                    echo $data['comprobante']['descTalonario'].' '.
                    $data['comprobante']['cvNumero'];
                ?>
            </b>
        </div>
        <div class="col-xs-4">
            <b>
                <?php
                    echo $data['comprobante']['cvRazonSocial'];
                ?>
            </b>
        </div>
        <div class="col-xs-4">
            <b>
                <?php
                    echo date_format(date_create($data['comprobante']['cvFecha']), 'd-m-Y  H:i');
                ?>
            </b>
        </div>
    </div>
    <hr>
    <h3>Detalle</h3>
    <table class="table table-bordered table-hover">
        <thead>
              <tr >
                <th style="text-align: center" width="10%">Cantidad</th>
                <th style="text-align: center" width="40%">Descripcion</th>
                <th style="text-align: center" width="20%">Precio</th>
                <th style="text-align: center" width="10%">Iva %</th>
                <th style="text-align: center" width="20%">Total</th>
              </tr>
        </thead>
        <tbody>
            <?php
                $subtotal = 0;
                foreach ($data['detalle'] as $d) {
                    echo '<tr>';
                    echo '<td style="text-align: right">'.number_format($d['cvdCantidad'],2,',','.').'</td>';
                    echo '<td>'.$d['artDescripcion'].'</td>';
                    echo '<td style="text-align: right">'.number_format($d['cvdPrecio'],2,',','.').'</td>';
                    echo '<td style="text-align: right">'.number_format($d['cvdIvaPorcentaje'],2,',','.').'</td>';
                    echo '<td style="text-align: right">'.number_format(($d['cvdCantidad'] * $d['cvdPrecio']),2,',','.').'</td>';
                    echo '</tr>';
                    $subtotal+= $d['cvdCantidad'] * $d['cvdPrecio'];
                  }
                  echo '<tr>';
                  echo '<td colspan="4" style="text-align: right">Subtotal:</td>';
                  echo '<td style="text-align: right"><b>'.number_format($subtotal,2,',','.').'</b></td>';
                  echo '</tr>';
                  echo '<tr>';
                  echo '<td colspan="4" style="text-align: right">Iva:</td>';
                  echo '<td style="text-align: right"><b>'.number_format(($subtotal * 0.21),2,',','.').'</b></td>';
                  echo '</tr>';
                  echo '<tr>';
                  echo '<td colspan="4" style="text-align: right">Total:</td>';
                  echo '<td style="text-align: right"><b><h4>'.number_format($subtotal + ($subtotal * 0.21),2,',','.').'</h4></b></td>';
                  echo '</tr>';
            ?>
        </tbody>
    </table>
</section>