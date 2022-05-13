<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Ventas</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadWood(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-xs-4">
                <label style="margin-top: 7px;">Cliente <strong style="color: #dd4b39">*</strong>: </label>
              </div>
            <div class="col-xs-5">
              <select class="form-control select2" id="cliId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
                <?php 
                  echo '<option value="-1" selected></option>';
                  foreach ($list as $c) {
                    echo '<option value="'.$c['cliId'].'" data-balance="'.$c['cliTipo'].'">'.$c['cliTipo'].'-'.$c['cliApellido'].', '.$c['cliNombre'].' ('.$c['cliDocumento'].')</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
                  }
                ?>
              </select>
              </div>
          </div>
          <br>
          <div class="row">
            <div class="col-xs-12">
              <div class="box-header">
              <h4 class="box-title">Estado de Cuenta Corriente</h4>
              </div>
              <div id="ctacteBody">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span><i class="fa fa-fw  fa-dollar text-green"></i> </span> Agregar Facturación</h4> 
      </div>
      <div class="modal-body" id="modalBodyFactura">
        
      </div>
      <div class="modal-footer">
        <input type="text" class="btn btn-default" id="remDate" value="" placeholder="dd-mm-aaaa" readonly="readonly" style="width: 110px">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabelPago"><span><i class="fa fa-fw  fa-dollar text-green"></i> </span> Agregar Pago</h4> 
      </div>
      <div class="modal-body" id="modalBodyPagos">
        <div class="row">
          <div class="col-xs-3">Observación: </div>
          <div class="col-xs-9"><input type="text" class="form-control" id="observacion"></div>
        </div><br>
        <div class="row">
          <div class="col-xs-3">Efectivo: </div>
          <div class="col-xs-4"><input type="text" class="form-control" id="efectivo"></div>
        </div><br>
        <div class="row">
          <div class="col-xs-3" style="margin-top: 10px;">Cheques: </div>
          <div class="col-xs-7"><input type="text" class="form-control" id="chequeNro" value="" placeholder="Número de cheque"></div>
          <div class="col-xs-2"><input type="text" class="form-control" id="chequeImporte" value="" placeholder="0.00"></div>
        </div><br>
        <div class="row">
          <div class="col-xs-2 col-xs-offset-3"><input type="text" class="form-control" id="chequeVto" value="" placeholder="dd-mm-aaaa" readonly="readonly"></div>
          <div class="col-xs-3">
            <select class="form-control" id="chequeBanco" style="width: 100%;" >
              <?php 
                foreach ($bancos as $b) {
                  echo '<option value="'.$b['bancoId'].'" data-name="'.$b['bancoDescripcion'].'">'.$b['bancoDescripcion'].'</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
                }
              ?>
            </select>
          </div>
          <div class="col-xs-1"><button type="button" class="btn btn-success" id="btnAddCheque"><i class="fa fa-fw fa-plus-square"></i></button></div>
        </div><br>
        <div class="row">
          <div class="col-xs-12">
            <table id="cheques" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="1%"></th>
                <th width="10%">Número</th>
                <th width="10%">Vencimiento</th>
                <th width="10%">Importe</th>
                <th>Banco</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            </table>
          </div>
        </div><br>
        <div class="row">
          <div class="col-xs-9" style="margin-top: 25px; text-align: right;">
              <h4>Total: </h4>
          </div>
          <div class="col-xs-3">
            <h1 id="lblTotal">0.00</h1>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="text" class="btn btn-default" id="pagoDate" value="" placeholder="dd-mm-aaaa" readonly="readonly" style="width: 110px">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnPago">Guardar</button>
      </div>
    </div>
  </div>
</div>


<script>
$(".select2").select2();
$("#efectivo").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$("#chequeImporte").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
$('#chequeVto').datepicker({});
$('#remDate').datepicker({maxDate: 0});
$('#pagoDate').datepicker({maxDate: 0});


$("#cliId").change(function(){
  LoadMove();
});

function LoadMove(){
  cliId_ = $("#cliId").val();
  remitosParaFacturar = [];
  WaitingOpen('Cargando Cuenta Corriente...');
      $.ajax({
            type: 'POST',
            data: { 
                    cliId : $("#cliId").val(), 
                    type: $("#cliId").find(':selected').data('balance')
                  },
        url: 'index.php/box/getCtaCte', 
        success: function(result){
                      WaitingClose();
                      $("#ctacteBody").html(result.html);
              },
        error: function(result){
              WaitingClose();
              alert("error");
            },
            dataType: 'json'
        });
}

var cliId_ = 0;
var remitosParaFacturar = [];
function selectRem(remId, puntero){
  
  if($(puntero).hasClass( 'fa-circle-o text-red' )){
    $(puntero).removeClass('fa-circle-o text-red');
    $(puntero).addClass('fa-check-circle text-green');
    remitosParaFacturar.push(remId);
  } else {
    $(puntero).removeClass('fa-check-circle text-green');
    $(puntero).addClass('fa-circle-o text-red');
    var index = remitosParaFacturar.indexOf(remId);
    remitosParaFacturar.splice(index,1);
  }

  if(remitosParaFacturar.length > 0){
    $('#btnFacturar').removeClass('disabled');
  } else {
    $('#btnFacturar').addClass('disabled');
  }
}

$('#btnSave').click(function(){
  WaitingOpen('Confeccionando Factura...');
  $.ajax({
        type: 'POST',
        data: { list : remitosParaFacturar, cliId : cliId_ , fecha: $('#remDate').val()},
        url: 'index.php/box/setFactura', 
        success: function(result){
                        if(result){
                          $('#modalFactura').modal('hide');
                          LoadMove();
                        } else {
                          WaitingClose();
                          ProcesarError(result.responseText, 'modalFactura');      
                        }
                    },
        error: function(result){
                    WaitingClose();
                    ProcesarError(result.responseText, 'modalFactura');
                },
        dataType: 'json'
        });
});

$('#btnAddCheque').click(function(){
  if(
      $('#chequeNro').val() == '' ||
      $('#chequeBanco').val() == '' ||
      $('#chequeVto').val() == '' ||
      $('#chequeImporte').val() == '' 
    ){
    return;
  }

  //Agregar a la tabla de cheques
  var row = '<tr><td></td>';
  row +=    '<td>'+$('#chequeNro').val()+'</td>';
  row +=    '<td>'+$('#chequeVto').val()+'</td>';
  row +=    '<td>'+$('#chequeImporte').val()+'</td>';
  row +=    '<td>'+$('#chequeBanco').val()+'#'+$("#chequeBanco").find(':selected').data('name')+'</td>';
  row +=    '</tr>';
  $('#cheques > tbody').prepend(row);

  CalcularTotal();

  $('#chequeNro').val('');
  $('#chequeVto').val('');
  $('#chequeImporte').val('');
});

$('#efectivo').keyup(function(){
  CalcularTotal();
});

var Total_ = 0;
function CalcularTotal(){
  Total_ = 0;
  var total = 0;
  var importe = $('#efectivo').val() == '' ? 0 : parseFloat($('#efectivo').val());
  total += importe;
  $("#cheques tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 3: 
                      importe = parseFloat($(this).text());
                      total += importe;
                      break;
                }
            });
        });
  importe = parseFloat(total);
  Total_ = importe;
  $('#lblTotal').html(importe.toFixed(2));
}

$('#btnPago').click(function(){
  if(Total_ <= 0){
    $('#modalPagos').modal('hide');
  } else {
    WaitingOpen('Registrando Pago...');

    var cheques = [];
    $("#cheques tbody tr").each(function (index) 
        {
            var nro, importe, vto, banco;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 1: 
                      nro = $(this).text();
                      break;
                    case 2: 
                      vto = $(this).text();
                      break;
                    case 3: 
                      importe = $(this).text();
                      break;
                    case 4: 
                      banco = $(this).text();
                      break;
                }
            });

            var obj = [nro , vto, importe, banco];
            cheques.push(obj);
        });
    $.ajax({
          type: 'POST',
          data: { 
                  cliId : $("#cliId").val(), 
                  type: $("#cliId").find(':selected').data('balance'),
                  obsv: $('#observacion').val(),
                  efect: $('#efectivo').val(),
                  cheq: cheques,
                  fecha: $('#pagoDate').val()
                },
      url: 'index.php/box/setPay', 
      success: function(result){
                    if(result){
                      $('#modalPagos').modal('hide');
                      LoadMove();
                    } else {
                      WaitingClose();
                      ProcesarError(result.responseText, 'modalPagos');      
                    }
            },
      error: function(result){
            WaitingClose();
             ProcesarError(result.responseText, 'modalPagos');   
          },
          dataType: 'json'
      });
  }
});

 
</script>
<div class="modal fade" id="modalPagosView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span><i class="fa fa-fw fa-search" style="color: #3c8dbc"></i> </span> Consultar Pago</h4> 
      </div>
      <div class="modal-body" id="modalBodyView">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFacturaView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span><i class="fa fa-fw fa-search" style="color: #3c8dbc"></i> </span> Consultar Factura</h4> 
      </div>
      <div class="modal-body" id="modalBodyFacturaView">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>