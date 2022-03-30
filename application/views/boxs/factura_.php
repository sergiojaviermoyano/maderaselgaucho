<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
      <label style="margin-top: 7px;">Cliente: <strong style="font-size: 17px;"><?php echo $data['cliente']['cliApellido'].', '.$data['cliente']['cliNombre'];?></strong></label>
    </div>	
</div>
<div class="row">
  <div class="col-xs-12">
      <label style="margin-top: 7px;">Domicilio: <strong style="font-size: 17px;"><?php echo $data['cliente']['cliDomicilio'];?></strong></label>
    </div>  
</div>
<div class="row">
  <div class="col-xs-12"> 
    <hr>
  </div>
</div>
<!-- Detalle de Productos -->
<div class="row">
	<div class="col-xs-12">
      <table class="table table-bordered table-hover">
        <thead>
          <th>N° Remito</th>
          <th>Cód. Prod.</th>
          <th>Descripción</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>IVA</th>
          <th>Total</th>
        </thead>
        <tbody>
          <?php
            $total = 0;
            foreach ($data['articles'] as $a) {
              if($a['remdCantidad'] > 0){
                echo '<tr>';
                echo '<td style="text-align: center">'.$a['remNumero'].'</td>';
                echo '<td style="text-align: right">'.$a['artId'].'</td>';
                echo '<td>'.$a['artDescripcion'].'</td>';
                echo '<td style="text-align: right">'.$a['remdCantidad'].'</td>';
                echo '<td style="text-align: right">'.$a['artPrecio'].'</td>';
                echo '<td style="text-align: right">'.$a['artIva'].'</td>';
                echo '<td style="text-align: right">'.number_format(($a['remdCantidad'] * ($a['artPrecio'] + $a['artIva'])), 2, '.', ',').'</td>';
                echo '</tr>';

                $total += $a['remdCantidad'] * ($a['artPrecio'] + $a['artIva']) ;
              }
            }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="6" style="text-align: right">Total: </th>
            <th style="text-align: right; font-size: 18px;"><?php echo $total; ?></th>
          </tr>
        </tfoot>
      </table>
    </div>
</div><br>
<!--
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Número<strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="number" class="form-control" placeholder="" id="numTalonario" value="<?php echo $data['book']['numTalonario'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
</div>
-->