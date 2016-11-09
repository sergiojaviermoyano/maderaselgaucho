<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Producción</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadRec(0,\'Add\')" id="btnAdd" title="Nueva">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
       
        <div class="box-header">
          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" id="table_search" class="form-control pull-right" placeholder="Buscar">

              <div class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div><br>
        <div class="box-body">
          <table id="credit" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="10%">Acciones</th>
                <th>Orden</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>O.Compra</th>
                <th>Depósito</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(count($list['data']) > 0) {                  
                  foreach($list['data'] as $o)
                  {
                    echo '<tr>';
                    echo '<td>';

                    //if($r['ordEstado'] == 'AC')
                    //  if (strpos($permission,'Conf') !== false) {
                    //    echo '<i class="fa fa-fw fa-check" style="color: #00a65a; cursor: pointer; margin-left: 15px;" onclick="LoadRec('.$o['ordId'].',\'Conf\')"></i>';
                    //  }
                    
                    if($o['ordEstado'] == 'RC' || $o['ordEstado'] == 'PA'){
                      if (strpos($permission,'Play') !== false) {
                        echo '<i class="fa fa-fw fa-play" style="color: #00a65a  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('.$o['ordId'].',\'Play\')"></i>';
                      }
                    }

                    if($o['ordEstado'] == 'PR' || $o['ordEstado'] == 'EP'){
                      if (strpos($permission,'Pause') !== false) {
                        echo '<i class="fa fa-fw fa-pause" style="color: #dd4b39 ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('.$o['ordId'].',\'Pause\')"></i>';
                      }

                      if (strpos($permission,'Entr') !== false) {
                        echo '<i class="fa fa-fw fa-truck" style="color: #3c8dbc  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('.$o['ordId'].',\'Entr\')"></i>';
                      }

                      if (strpos($permission,'Finaly') !== false) {
                        echo '<i class="fa fa-fw fa-calendar-check-o" style="color: #f39c12  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('.$o['ordId'].',\'Finaly\')"></i>';
                      }
                    }

                    if (strpos($permission,'Imprimir') !== false) {
                      echo '<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('.$o['ordId'].')"></i>';
                    }

                    echo '</td>';
                    echo '<td>'.str_pad($o['ordId'], 8, "0", STR_PAD_LEFT).'</td>';
                    $date = date_create($o['ordFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
                    echo '<td style="text-align: left">'.($o['cliApellido'] == null && $o['cliNombre'] == null ? '<strong style="color: brown">Op. Interna</string>' : $o['cliApellido'].', '.$o['cliNombre']).'</td>';
                    echo '<td style="text-align: left">'.$o['ordNumeroOC'].'</td>';
                    echo '<td style="text-align: center">'.$o['depNombre'].'</td>';
                    echo '<td style="text-align: center" onClick="Log('.$o['ordId'].')">';
                    switch ($o['ordEstado'])
                    {
                      case 'RC': 
                                echo '<small class="label bg-green">Recibido</small>';
                                break;

                      case 'DS':
                                echo '<small class="label bg-red">Descartado</small>';
                                break;

                      case 'PR':
                      case 'EP':
                                echo '<small class="label bg-blue">Producción</small>';
                                break;

                      case 'PA':
                                echo '<small class="label bg-orange">Pausado</small>';
                                break;

                    }
                    echo '</td>';
                    echo '</tr>';
                  }
                  
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="8" style="text-align: center" id="footerRow">
                <?php 
                if($list['page'] == 1){
                  echo '<button type="button" class="btn btn-default disabled"><i class="fa fa-fw fa-backward"></i></button>';
                } else {
                  echo '<button type="button" class="btn btn-default" onclick="page('.($list['page'] - 1).')"><i class="fa fa-fw fa-backward"></i></button>';
                }

                echo '<span style="padding: 0px 15px">'.$list['page'].'   de   '.$list['totalPage'].'</span>';

                if($list['page'] == $list['totalPage']){
                  echo '<button type="button" class="btn btn-default disabled"><i class="fa fa-fw fa-forward"></i></button>';
                } else {
                  echo '<button type="button" class="btn btn-default" onclick="page('.($list['page'] + 1).')"><i class="fa fa-fw fa-forward"></i></button>';
                }
                ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div><!-- /.box-body -->

      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
$('#table_search').keyup(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code==13) {
        e.preventDefault();
    }

    if (code == 32 || code == 13 || code == 188 || code == 186) {
        page(1);
    }
  });


  function page(p){
  WaitingOpen('Cargando...');
      $.ajax({
            type: 'POST',
            data: {
              page: p,
              txt: $('#table_search').val()
            },
            url: 'index.php/order/production_pagination', 
            success: function(result){
                      WaitingClose();
                      $('#credit > tbody').html('');
                      $.each( result.data, function( key, value ) {
                        var row = '';
                        row += '<tr>';
                        row += '<td>';
                        //-----------
                        
                        //-----------

                        if(value.ordEstado == 'RC' || value.ordEstado == 'PA'){
                          if($('#permission').val().indexOf("Play") != -1) {
                            row += '<i class="fa fa-fw fa-play" style="color: #00a65a  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('+value.ordId+',\'Play\')"></i>';
                          }
                        }

                        if(value.ordEstado == 'PR' || value.ordEstado == 'EP'){
                          if ($('#permission').val().indexOf("Pause") != -1) {
                            row += '<i class="fa fa-fw fa-pause" style="color: #dd4b39 ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('+value.ordId+',\'Pause\')"></i>';
                          }

                          if ($('#permission').val().indexOf("Entr") != -1) {
                            row += '<i class="fa fa-fw fa-truck" style="color: #3c8dbc  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('+value.ordId+',\'Entr\')"></i>';
                          }

                          if ($('#permission').val().indexOf("Finaly") != -1) {
                            row += '<i class="fa fa-fw fa-calendar-check-o" style="color: #f39c12  ; cursor: pointer; margin-left: 15px;" onclick="LoadRec('+value.ordId+',\'Finaly\')"></i>';
                          }
                        }

                        if ($('#permission').val().indexOf("Imprimir") != -1) {
                          row += '<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('+value.ordId+')"></i>';
                        }
                                                  
                        //row += '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadRec('+value.recId+',\'View\')"></i>';
                        row += '</td>';
                        row += '<td>'+("0000000"+value.ordId).slice(-10)+'</td>';
                        var date = new Date(value.ordFecha);
                        row += '<td style="text-align: center">'+("0"+date.getDate()).slice(-2)+'-'+("0"+date.getMonth()).slice(-2)+'-'+date.getFullYear()+' '+("0"+date.getHours()).slice(-2)+':'+("0"+date.getMinutes()).slice(-2)+'</td>';
                        row += '<td style="text-align: left">'+ (value.cliApellido == null && value.cliNombre == null ? '<strong style="color: brown">Op. Interna</string>' : value.cliApellido+', '+value.cliNombre ) +'</td>';
                        row += '<td style="text-align: left">'+value.ordNumeroOC+'</td>';
                        row += '<td style="text-align: center">'+value.depNombre+'</td>';
                        row += '<td style="text-align: center" onClick="Log('+value.ordId+')">';
                        switch (value.ordEstado)
                        {
                          case 'RC': 
                                    row += '<small class="label bg-green">Recibido</small>';
                                    break;

                          case 'DS':
                                    row += '<small class="label bg-red">Descartado</small>';
                                    break;

                          case 'PR':
                          case 'EP':
                                    row += '<small class="label bg-blue">Producción</small>';
                                    break;

                          case 'PA':
                                    row += '<small class="label bg-orange">Pausado</small>';
                                    break;

                        }
                        row += '</td>';
                        //+(value.ordEstado == 'RC' ? '<small class="label bg-green">Activo</small>' : (value.ordEstado == 'DS' ? '<small class="label bg-red">Descartado</small>' : '<small class="label bg-blue">Confirmado</small>'))+'</td>';
                        row += '</tr>';
                        $('#credit > tbody').append(row);
                      });
                      
                      var foot = '';
                      if(result.page == 1){
                        foot += '<button type="button" class="btn btn-default disabled"><i class="fa fa-fw fa-backward"></i></button>';
                      } else {
                        foot += '<button type="button" class="btn btn-default" onclick="page('+(parseInt(result.page) - 1)+')"><i class="fa fa-fw fa-backward"></i></button>';
                      }

                      foot += '<span style="padding: 0px 15px">'+result.page+'   de   '+result.totalPage+'</span>';

                      if(result.page == result.totalPage){
                        foot += '<button type="button" class="btn btn-default disabled"><i class="fa fa-fw fa-forward"></i></button>';
                      } else {
                        foot += '<button type="button" class="btn btn-default" onclick="page('+(parseInt(result.page) + 1)+')"><i class="fa fa-fw fa-forward"></i></button>';
                      }
                      $('#footerRow').html(foot);
            },
            error: function(result){
              WaitingClose();
              alert("error");
            },
            dataType: 'json'
        });

  }

  
  var id = 0;
  var action = '';
  
  function LoadRec(id_, action_){
    id = id_;
    action = action_;
    LoadIconAction('modalAction',action);
    WaitingOpen('Cargando ...');
      $.ajax({
            type: 'POST',
            data: { id : id_, act: action },
        url: 'index.php/order/getOrder', 
        success: function(result){
                      WaitingClose();
                      $("#modalBodyReception").html(result.html);
                      $(".select2").select2();
                      setTimeout("$('#modalReception').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              alert("error");
            },
            dataType: 'json'
        });
  }

  $('#btnSave').click(function(){
    
    if(action == 'View')
    {
      $('#modalReception').modal('hide');
      return;
    }

    var hayError = false;
    if($('#depId').val() == '-1')
    {
      hayError = true;
    }

    if($('#cliId').val() == '-1')
    {
      hayError = true;
    }

    var rece = [];

    if(hayError == true){
      $('#error').fadeIn('slow');
      return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando ...');
      $.ajax({
            type: 'POST',
            data: { 
                    id_ : id, 
                    act: action, 
                    depId: $('#depId').val(),
                    cliId: $('#cliId').val(),
                    OC:    $('#ordNumeroOC').val(),
                    obsv:  $('#ordObservacion').val(),
                    est:   $('#ordEstado').val(),
                    det:   rece
                  },
        url: 'index.php/order/setorder', 
        success: function(result){
                      WaitingClose();
                      $('#modalReception').modal('hide');
                      setTimeout("cargarView('order', 'production', '"+$('#permission').val()+"');",1000);
              },
        error: function(result){
              WaitingClose();
              ProcesarError(result.responseText, 'modalReception');
            },
            dataType: 'json'
        });
  });

function Log(ordId){
  WaitingOpen('Cargando ...');
  $.ajax({
        type: 'POST',
        data: { id : ordId },
    url: 'index.php/order/getLog', 
    success: function(result){
                  WaitingClose();
                  $("#modalBodyLog").html(result.html);
                  setTimeout("$('#modalLog').modal('show')",800);
          },
    error: function(result){
          WaitingClose();
          alert("error");
        },
        dataType: 'json'
    });
}

var ot;
  var otdId;
  function Entregue(ordId, orddid){
    ot = ordId;
    otdId = orddid;
    $('#modalReserve').modal('show');
  }

  $('#btnEntregue').click(function(){
    if($('#reserveCant').val() == '' || $('#reserveCant').val() == '0')
      return;
    WaitingOpen('Entregando...');
    $.ajax({
          type: 'POST',
          data: { ordId: ot, orddid: otdId, cant: $('#reserveCant').val() },
          url: 'index.php/order/setEntregue', 
          success: function(resultList){
                        $('#modalReserve').modal('hide');
                          WaitingClose();
                          LoadRec(id, 'Entr');
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalReserve');
              },
              dataType: 'json'
      });
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalReception" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Orden de Pedido</h4> 
      </div>
      <div class="modal-body" id="modalBodyReception">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSearch" tabindex="3000" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction__"> </span> Artículo</h4> 
      </div>
      <div class="modal-body" id="modalBodySearch">
        
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1"><center>Producto</center></div>
        </div>
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <input type="text" class="form-control" id="artIdSearch" value="" min="0">
          </div>
        </div><br>

        <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="1%"></th>
                  <th width="10%">Código</th>
                  <th>Descripción</th>
                </tr>
              </thead>
            </table>
            <table id="saleDetailSearch" style="height:20em; display:block; overflow: auto;" class="table table-bordered">
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="cancelarBusqueda()">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 50%"><!--  -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLog"><span id="modalActionLog"> <i class="fa fa-fw fa-send" style="color: #00c0ef;"></i> Seguimiento </span> de Pedido</h4> 
      </div>
      <div class="modal-body" id="modalBodyLog">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalReserve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document"><!--  -->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalReserve"><span id="modalActionReserve"> <i class="fa fa-fw fa-truck" style="color: #3c8dbc"></i> Entregar </span> Artículo</h4> 
      </div>
      <div class="modal-body" id="modalBodyReserve">
        <div class="row">
          <div class="col-xs-4">
            <label style="margin-top: 7px;">Cantidad a Entregar: </label>
          </div>
          <div class="col-xs-8">
            <input type="number" id="reserveCant" class="form-control" value="0" min="0">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnEntregue">Entregar</button>
      </div>
    </div>
  </div>
</div>