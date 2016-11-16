<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="nav-tabs-custom"> 
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">Remitos</a></li>
    <li><a href="#tab_2" data-toggle="tab" <?php echo ($data['type'] == 'NG' ? 'style="display: none"' : '');?> >Facturas</a></li><!-- <?php echo ($data['article']['artEsSimple'] == true ? 'style="display: none"' : '');?> --> 
    <li><a href="#tab_3" data-toggle="tab">Pagos</a></li>
    <li><a href="#tab_4" data-toggle="tab">Estado</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1">
    	<table id="credit" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="10%">Acciones</th>
                <th width="10%">Número</th>
                <th width="15%">Fecha</th>
                <th>Estado</th>
                <th>Orden Trabajo</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	foreach ($data['remitos'] as $remito) {
            		echo '<tr>';
            		echo '<td>';
            		echo '<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="PrintRemito('.$remito['remId'].')"></i>';
            		if ($data['type'] == 'BL')
                        if($remito['remEstado'] == 'AC')
            			echo '<i class="fa fa-fw fa-circle-o text-red" style="cursor: pointer; margin-left: 15px;" onclick="selectRem('.$remito['remId'].', this)"></i>';
            		echo '</td>';
            		echo '<td>'.$remito['remNumero'].'</td>';
            		$date = date_create($remito['remFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
            		echo '<td style="text-align: center">';
                    switch ($remito['remEstado'])
                    {
                      case 'AC': 
                                echo '<small class="label bg-green">Activo</small>';
                                break;

                      case 'FA':
                                echo '<small class="label bg-blue">Facturado</small>';
                                break;

                      case 'CN':
                                echo '<small class="label bg-blue">Cancelado</small>';
                                break;

                      case 'PA':
                                echo '<small class="label bg-orange">Parcial</small>';
                                break;

                      default:
                                echo '<small class="label bg-gray">'.$remito['remEstado'].'</small>';
                                break;

                    }
            		echo '<td>'.str_pad($remito['ordId'], 8, "0", STR_PAD_LEFT).'</td>';
            		echo '</tr>';	
            	}
            	?>
            </tbody>
            <tfoot>
            	<tr>
            		<td colspan="7"><button class="btn btn-success disabled" id="btnFacturar" <?php echo ($data['type'] == 'NG' ? 'style="display: none"' : '');?> >Facturar</button></td>
            	</tr>
            </tfoot>
        </table>
    </div>

    <div class="tab-pane" id="tab_2">
        <table id="credit" class="table table-bordered table-hover">
            <thead>
              <tr>
                <!--<th width="10%">Acciones</th>-->
                <th width="15%" colspan="2" style="text-align: center">Factura</th>
                <th width="15%">Fecha</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($data['facturas'] as $f) {
                    echo '<tr>';
                    echo '<td>'.$f['descTalonario'].'</td>';
                    echo '<td>'.$f['cvNumero'].'</td>';
                    $date = date_create($f['cvFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
                    echo '<td style="text-align: center">';
                    switch ($f['cvEstado'])
                    {
                      case 'AC': 
                                echo '<small class="label bg-green">Activa</small>';
                                break;

                      case 'CN':
                                echo '<small class="label bg-blue">Cancelada</small>';
                                break;

                      case 'PA':
                                echo '<small class="label bg-orange">Parcial</small>';
                                break;

                      default:
                                echo '<small class="label bg-gray">'.$f['cvEstado'].'</small>';
                                break;

                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>                
            </tbody>
        </table>
    </div>

    <div class="tab-pane" id="tab_3">
        <button class="btn btn-success" id="btnPagar" >Registrar Pago</button><br><br>
        <table id="pagos" class="table table-bordered table-hover">
            <thead>
              <tr>
                <!--<th width="10%">Acciones</th>-->
                <th width="15%" style="text-align: center">Orden</th>
                <th width="15%">Fecha</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($data['ordenes'] as $o) {
                    echo '<tr>';                    
                    echo '<td>'.$o['opId'].'</td>';
                    $date = date_create($o['opFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
                    echo '<td style="text-align: center">';
                    switch ($o['opEstado'])
                    {
                      case 'AC': 
                                echo '<small class="label bg-green">Activa</small>';
                                break;

                      case 'CN':
                                echo '<small class="label bg-blue">Cancelada</small>';
                                break;

                      case 'PA':
                                echo '<small class="label bg-orange">Parcial</small>';
                                break;

                      default:
                                echo '<small class="label bg-gray">'.$o['opEstado'].'</small>';
                                break;

                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>                
            </tbody>
        </table>
    </div>

    <div class="tab-pane" id="tab_4">
        <h2>Estado cuenta</h2>
        <h4>
            Total Deuda Acumulada: <?php echo $data['estado']['deuda']; ?> <br>
            Total Pagos Acumulados: <?php echo $data['estado']['pagos']; ?> <br>
        </h4>
        <h3>Saldo Actualizado: <?php echo $data['estado']['deuda']-$data['estado']['pagos']; ?></h3>
        <?php //var_dump($data['estado']); ?>
    </div>
  </div>
</div>

<script>
$('#btnFacturar').click(function(){
    if(remitosParaFacturar.length <= 0){
        return ; 
    }
    WaitingOpen('Confeccionando Factura...');
      $.ajax({
            type: 'POST',
            data: { list : remitosParaFacturar, cliId : cliId_ },
            url: 'index.php/box/getFactura', 
            success: function(result){
                            WaitingClose();
                            $("#modalBodyFactura").html(result.html);
                            setTimeout("$('#modalFactura').modal('show')",800);
                        },
            error: function(result){
                        WaitingClose();
                        ProcesarError(result.responseText, 'modalFactura');
                    },
            dataType: 'json'
            });

  $('#modalFactura').modal('show');
});

$('#btnPagar').click(function(){
  $('#chequeNro').val('');
  $('#chequeVto').val('');
  $('#chequeImporte').val('');
  $("#cheques tbody").html('');
  $('#efectivo').val('');
  $('#observacion').val('');
  Total_ = 0;
  $('#lblTotal').html('0.00');

    $('#modalPagos').modal('show');

});

function PrintRemito(id__){
  WaitingOpen('Generando reporte...');
  LoadIconAction('modalAction__','Print');
  $.ajax({
          type: 'POST',
          data: { 
                  id : id__
                },
      url: 'index.php/order/printRemite', 
      success: function(result){
                    WaitingClose();
                    var url = "./assets/reports/remits/" + result;
                    $('#printDoc').attr('src', url);
                    setTimeout("$('#modalPrint').modal('show')",800);
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalPrint');
          },
          dataType: 'json'
      });
}
</script>