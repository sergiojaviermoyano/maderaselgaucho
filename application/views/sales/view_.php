<input type="hidden" value="<?php echo $data['prvId'];?>" id="prvId">
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
    <li class="active"><a href="#tab_2" data-toggle="tab" >Facturas</a></li><!-- <?php echo ($data['article']['artEsSimple'] == true ? 'style="display: none"' : '');?> --> 
    <li><a href="#tab_3" data-toggle="tab">Pagos</a></li>
    <li><a href="#tab_4" data-toggle="tab">Estado</a></li>
    <li><a href="#tab_5" data-toggle="tab">Consulta</a></li>
  </ul>
  <div class="tab-content">

    <div class="tab-pane active" id="tab_2">
        <table id="credit" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="10%" style="text-align: center">Acciones</th>
                <th width="25%" colspan="2" style="text-align: center">Factura</th>
                <th width="15%" style="text-align: center">Fecha</th>
                <th style="text-align: center">Importe</th>
                <th width="15%" style="text-align: center">Estado</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($data['facturas'] as $f) {
                    echo '<tr>';
                    echo '<td style="text-align: center">
                      <i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer;" onclick="LoadFactura('.$f['ccId'].')"></i>';
                    '</td>';
                    echo '<td>';
                    switch($f['ccTipo']){
                      case 'FA':
                        echo 'Factura A';
                        break;
                      case 'FB':
                        echo 'Factura B';
                        break;
                      case 'FC':
                        echo 'Factura C';
                        break;
                    }
                    echo '</td>';
                    echo '<td>'.$f['ccNumero'].'</td>';
                    $date = date_create($f['ccFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
                    echo '<td style="text-align: right">$'.number_format($f['total'],2,',','.').'</td>';
                    echo '<td style="text-align: center">';
                    switch ($f['ccEstado'])
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
                                echo '<small class="label bg-gray">'.$f['ccEstado'].'</small>';
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
                <th width="10%" style="text-align: center">Acciones</th>
                <th width="15%" style="text-align: center">Orden</th>
                <th width="15%" style="text-align: center">Fecha</th>
                <th style="text-align: center">Total</th>
                <th width="15%" style="text-align: center">Estado</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($data['ordenes'] as $o) {
                    echo '<tr>';
                    echo '<td style="text-align: center">
                      <i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer;" onclick="LoadPago('.$o['opId'].')"></i>';
                    '</td>';                  
                    echo '<td style="text-align: center">'.$o['opId'].'</td>';
                    $date = date_create($o['opFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
                    echo '<td style="text-align: right">$'.number_format($o['total'],2,',','.').'</td>';
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

    <div class="tab-pane" id="tab_5">
      <input type="text" class="btn btn-default" id="fromDate" value="" placeholder="dd-mm-aaaa" readonly="readonly" style="width: 110px">  
      <input type="text" class="btn btn-default" id="toDate" value="" placeholder="dd-mm-aaaa" readonly="readonly" style="width: 110px">
      <button type="button" class="btn btn-primary" id="btnConsultar">Consultar</button>
      <hr>
              <div id="estadoCuenta">

              </div>
    </div>
  </div>
</div>

<script>
  $('#fromDate').datepicker({maxDate: 0});
  $('#toDate').datepicker({maxDate: 0});
  $('#btnConsultar').click(function(){
    //estadoCuenta
    if($('#fromDate').val() == '' || $('#toDate').val() == ''){
      return;
    }  
    $("#estadoCuenta").html('');

    WaitingOpen('Consultando...');
    $.ajax({
          type: 'POST',
          data: { 
                  prvId : $('#prvId').val(),
                  from  : $('#fromDate').val(),
                  to    : $('#toDate').val()
                },
          url: 'index.php/sale/getExtracto', 
          success: function(result){
                          WaitingClose();
                          $("#estadoCuenta").html(result.html);
                      },
          error: function(result){
                      WaitingClose();
                      ProcesarError(result.responseText, 'modal');
                  },
          dataType: 'json'
          });
  });

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

  WaitingOpen('Cargando Cheques...');
  $.ajax({
          type: 'POST',
          data: null,
      url: 'index.php/sale/getChequesActivos', 
      success: function(result){
                    WaitingClose();
                    //chequesTerceros
                      if(result.length > 0){
                       $.each( result, function( key, value ) {
                          var option = '<option value="'+value.cheId+'" ';
                          option += 'data-banco="'+value.bancoDescripcion+'" data-banid="'+value.bancoId+'" ';
                          option += 'data-importe="'+value.cheImporte+'" data-numero="'+value.cheNumero+'" ';
                          option += 'data-tipo="'+value.cheType+'" data-vence="'+value.cheVencimiento+'">'
                          option += value.cheNumero + ' -- $' + value.cheImporte + ' -- ' + value.bancoDescripcion +' -- ' + value.cheType;
                          option += '</option>';
                          $('#chequesTerceros').append(option);
                       });
                     }
                    $('#modalPagos').modal('show');
            },
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalPagos');
          },
          dataType: 'json'
      });

});

function LoadFactura(id){
  WaitingOpen('Consultando Factura...');
   $.ajax({
           type: 'POST',
           data: { 
                   ccId: id
                 },
       url: 'index.php/sale/getFactura_', 
       success: function(result){
                     if(result){
                       $('#modalBodyFacturaView').html(result.html);
                       $('#modalFacturaView').modal('show');
                       WaitingClose();
                     } else {
                       WaitingClose();
                       ProcesarError(result.responseText, 'modalFacturaView');      
                     }
             },
       error: function(result){
             WaitingClose();
              ProcesarError(result.responseText, 'modalFacturaView');   
           },
           dataType: 'json'
       });
}

function LoadPago(id){
  WaitingOpen('Consultando Pago...');
   $.ajax({
           type: 'POST',
           data: { 
                   opId: id
                 },
       url: 'index.php/sale/getPago', 
       success: function(result){
                     if(result){
                       $('#modalBodyView').html(result.html);
                       $('#modalPagosView').modal('show');
                       WaitingClose();
                     } else {
                       WaitingClose();
                       ProcesarError(result.responseText, 'modalPagosView');      
                     }
             },
       error: function(result){
             WaitingClose();
              ProcesarError(result.responseText, 'modalPagosView');   
           },
           dataType: 'json'
       });
}
</script>