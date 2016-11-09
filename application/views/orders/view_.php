<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>

<?php 

if($data['action'] != 'Add' && $data['action'] != 'Int' )
{
  $date = date_create($data['order']['ordFecha']); 
?>
  <div class="row">
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Orden N°: <strong style="font-size: 17px;"><?php echo str_pad($data['order']['ordId'], 8, "0", STR_PAD_LEFT);?></strong></span>
      </div>
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Fecha: <strong style="font-size: 17px;"><?php echo date_format($date, 'd-m-Y H:i:s');?></strong></span>
      </div>
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Creada por: <strong style="font-size: 17px;"><?php echo $data['user'];?></strong></span>
      </div>
  </div>
  <hr>
<?php
}
?>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Deposito <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
    <select class="form-control select2" id="depId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      <?php 
        echo '<option value="-1" selected></option>';
        foreach ($data['deposit'] as $d) {
          echo '<option value="'.$d['depId'].'" '.($data['order']['depId'] == $d['depId'] ? 'selected' : '').'>'.$d['depNombre'].'</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
        }
      ?>
    </select>
    </div>
</div><br>

<?php if($data['isInterne'] != true)
  {
?>
  <div class="row">
  	<div class="col-xs-4">
        <label style="margin-top: 7px;">Cliente <strong style="color: #dd4b39">*</strong>: </label>
      </div>
  	<div class="col-xs-5">
      <select class="form-control select2" id="cliId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
        <?php 
          echo '<option value="-1" selected></option>';
          foreach ($data['customers'] as $c) {
            echo '<option value="'.$c['cliId'].'" '.($data['order']['cliId'] == $c['cliId'] ? 'selected' : '').'>'.$c['cliApellido'].', '.$c['cliNombre'].' ('.$c['cliDocumento'].')</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
          }
        ?>
      </select>
      </div>
  </div><br>

  <div class="row">
    <div class="col-xs-4">
        <label style="margin-top: 7px;">Orden de Compra N° <!--<strong style="color: #dd4b39">*</strong>-->: </label>
      </div>
    <div class="col-xs-5">
        <input type="text" class="form-control" id="ordNumeroOC" value="<?php echo $data['order']['ordNumeroOC'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
      </div>
  </div><br>
  <?php
  }
  else{
  ?>
    <input type="hidden" id="cliId" value="0">
    <input type="hidden" id="ordNumeroOC" value="">
  <?php
  }
?>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Observación <!--<strong style="color: #dd4b39">*</strong>-->: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="ordObservacion" value="<?php echo $data['order']['ordObservacion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
    </div>
</div><br>

<input type="hidden" id="ordEstado" value="<?php echo $data['order']['ordEstado'];?>">

<div class="row">
  <div class="col-xs-12"><hr></div>
</div>

<?php
  if($data['action'] == 'Add' || $data['action'] == 'Edit' || $data['action'] == 'Int')
  {
?>
    <div class="row">
      <div class="col-xs-4">
          <label style="margin-top: 7px;">Producto: </label>
        </div>
      <div class="col-xs-5">
          <input type="number" class="form-control" id="artId" value="" min="0" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
        </div>
      <div class="col-xs-2">
          <input type="number" class="form-control" id="artCant" value="1" min="1" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
        </div>
      <div class="col-xs-1">
          <button type="button" class="btn btn-success" id="btnAddProd"><i class="fa fa-check"></i></button>
        </div>
    </div><br>
<?php
  }
?>

<?php 
  if($data['action'] != 'Entr' && $data['action'] != 'Finaly')
  {

    if($data['action'] == 'EntrM'){
        echo ' <div class="row">
                <div class="col-xs-12">
                  <label onclick="production()" style="color: blue; cursor: pointer;">Ver Producción </label>
                </div>
              </div>';
    }
?>

    <div class="row">
      <div class="col-xs-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="1%"></th>
              <th width="10%">Código</th>
              <th>Descripción</th>
              <th width="10%">Cantidad</th>
              <th width="10%">P.Unit</th>
              <?php 
              if($data['action'] != 'EntrM')
              {
              ?>
                <th width="10%">Total</th>
              <?php
              } else {
                ?>
                <th width="10%">Entregado</th>
                <th width="10%">Entrega</th>
                <th width="10%">Total</th>
                <?php
              }
              if($data['action'] == 'Reserve') echo '<th width="10%">Reserva</th>';
              ?>
            </tr>
          </thead>
        </table>
        <table id="orderDetail" style="height:10em; display:block; overflow: auto;" class="table table-bordered">
          <tbody>
          <?php
          $total = 0;
            foreach ($data['articles'] as $a) {
              $cant = $a['orddCantidad'];
              if(
                  $data['action'] == 'Play'   ||
                  $data['action'] == 'Pause'  ||
                  $data['action'] == 'Entr'   ||
                  $data['action'] == 'Finaly' 
                ){
                $cant = $a['orddCantidad'] -$a['orddReserva'];
              }
              echo '<tr id="'.$a['orddid'].'">';
              echo '<td width="1%"><i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer;" onclick="delete_('.$a['orddid'].')"></td>';
              echo '<td width="10%">'.$a['artId'].'</td>';
              echo '<td>'.$a['artDescripcion'].'</td>';
              echo '<td width="10%" style="text-align: right">'.$cant.'</td>';
              echo '<td style="display:none">'.$a['artId'].'</td>';
              echo '<td width="10%" style="text-align: right">'.$a['artPrecio'].'</td>';
              if($data['action'] != 'EntrM')
              {
                echo '<td width="10%" style="text-align: right">'.number_format(($a['orddCantidad'] * $a['artPrecio']), 3, '.', '').'</td>';
              }else{
                echo '<th width="10%" style="text-align: right">'.($a['entregado'] == null ? '0': $a['entregado']).'</th>';
                echo '<th width="10%" style="text-align: right"><strong style="color: #00a65a" id="entr_'.$a['orddid'].'">0</strong> <i class="fa fa-fw fa-pencil" style="color: #ddd ; cursor: pointer; margin-left: 15px;" onclick="EntregueM('.$a['orddid'].','.$a['artId'].')"></i></th>';
                echo '<td width="10%" style="text-align: right">0.00</td>';
                echo '<td style="display:none">'.$a['orddid'].'</td>';
              }
              if($data['action'] == 'Reserve') echo '<th width="10%" style="text-align: right">'.$a['orddReserva'].'  <i class="fa fa-fw fa-pencil" style="color: #ddd ; cursor: pointer; margin-left: 15px;" onclick="Reserve('.$a['orddid'].')"></i> </th>';
              echo '</tr>';
              $total += ($a['orddCantidad'] * $a['artPrecio']);
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-2 col-xs-offset-7">
        <h3 style="margin-top: 6px">Total</h3>
      </div>
      <div class="col-xs-3" style="text-align: right">
        <h2 style="margin-top: 5px" id="total_"><?php echo ($data['action'] != 'EntrM' ? number_format($total, 3, '.', '') : '0.000');?></h1>
      </div>
    </div>
<?php
    if($data['action'] == 'EntrM' )
    {
      ?>
      <div id="permission">
      <a role="button" data-toggle="collapse" href="#collapseRemitos" aria-expanded="false" aria-controls="collapsecollapseRemitos" class="modal-title">Remitos</a>
      <div class="collapse" id="collapseRemitos">
        <div>
          <table style="width: 100%; display:block; overflow: auto;" class="table table-bordered">
          <?php
            foreach ($data['remitos'] as $r) {
              echo '<tr>';
              echo '<td><i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="PrintRemito('.$r['remId'].')"></i></td>';
              echo '<td><label><b>'.str_pad($r['remId'], 8, "0", STR_PAD_LEFT).'<b></label></td>';
              $date = date_create($r['remFecha']); 
              echo '<td>'.date_format($date, 'd-m-Y H:i:s').'</td>';
              echo '<td>'.$r['remEstado'].'</td>';
              echo '</tr>';
            }
          ?>
          </table>
        </div>
      </div>  
      </div>
      <?php
    }
  }else{
    ?>
    <div class="row">
      <div class="col-xs-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th width="10%">Código</th>
              <th>Descripción</th>
              <th width="10%">Pedido</th>
              <th width="10%">Entregado</th>
              <?php 
                if($data['action'] == 'Entr')
                  echo '<th width="10%">Entrega</th>';
              ?>
            </tr>
          </thead>
        </table>
        <table class="table table-bordered">
          <tbody>
          <?php
          $total = 0;
            foreach ($data['articles_ent'] as $a) {
              echo '<tr>';
              echo '<td width="10%">'.$a['artId'].'</td>';
              echo '<td>'.$a['artDescripcion'].'</td>';
              echo '<td width="10%" style="text-align: right"><label>'.($a['orddCantidad'] - $a['orddReserva']).'</label></td>';
              echo '<td width="10%" style="text-align: right"><strong style="color: #00a65a">'.($a['entregado'] == null ? '0': $a['entregado']).'</strong></td>';
              if($data['action'] == 'Entr')
                echo '<td width="10%" style="text-align: center"><i class="fa fa-fw fa-pencil" style="color: #ddd ; cursor: pointer; margin-left: 15px;" onclick="Entregue('.$a['ordId'].','.$a['orddid'].')"></i> </th></td>';
              echo '</tr>';
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
  }
?>

<script>
  var isOpenWindow = false;
  $('#artId').keyup(function(e){ 
    var code = e.which; 
    if(code==13)e.preventDefault();
    if(code==32||code==13||code==188||code==186){
        //Buscar articulo
        Buscar();
      }
  });

  $('#btnAddProd').click(function(){
    Buscar();
  });

  var idSale = 0 ;
  function Buscar(){
    WaitingOpen('Buscando');
    $.ajax({
          type: 'POST',
          data: { code: $('#artId').val() },
          url: 'index.php/article/searchByCodeAllWidthPrice', 
          success: function(result){
                        if(result != false){
                          WaitingClose();
                          var cantidad = parseInt($('#artCant').val() == '' ? 1 : $('#artCant').val());
                          var row = '<tr id="'+idSale+'">';
                          row += '<td width="1%"><i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer;" onclick="delete_('+idSale+')"></i></td>';
                          row += '<td width="10%">'+result.artId+'</td>';
                          row += '<td>'+result.artDescripcion+'</td>';
                          row += '<td width="10%" style="text-align: right">'+cantidad+'</td>';
                          row += '<td style="display: none">'+result.artId+'</td>';
                          row += '<td width="10%" style="text-align: right">'+result.artPrecio+'</td>';
                          row += '<td width="10%" style="text-align: right">'+(cantidad * result.artPrecio).toFixed(3)+'</td>'; 
                          row += '</tr>';
                          $('#orderDetail > tbody').prepend(row);
                          idSale++;

                          $('#artCant').val('1');
                          $('#artId').val('');
                          Calcular();
                          $('#artId').focus();
                        } else {
                          AbrirBuscador();
                        }
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalReception');
              },
              dataType: 'json'
      });
    //---------------
  }

  function delete_(id){
    $('#'+id).remove();
    Calcular();
    $('#artId').focus();
  }

  function AbrirBuscador(){
    LoadIconAction('modalAction__','Search');
    WaitingClose();
    $('#modalReception').modal('hide');
    cerro();
    $('#modalSearch').modal({ backdrop: 'static', keyboard: false });
    $('#modalSearch').modal('show');
    setTimeout(function () { $('#artIdSearch').focus(); }, 1000);
  }

  function cancelarBusqueda(){
    $('#modalSearch').modal('hide');
    $('#modalReception').modal('show');
    isOpenWindow = true;
    $('#artCant').val('1');
    $('#artId').val('');
    setTimeout(function () { $('#artId').focus(); }, 1000);
  }

  function cerro(){
    isOpenWindow = false;
  }

    function BuscarCompleto(){
    $('#saleDetailSearch > tbody').html('');
    $.ajax({
          type: 'POST',
          data: { code: $('#artIdSearch').val(), depId: $('#depId').val() },
          url: 'index.php/article/searchByAllConStock', 
          success: function(resultList){
                        $('#saleDetailSearch > tbody').html('');
                        if(resultList != false){
                          WaitingClose();
                          $.each(resultList, function(index, result){
                            //if(result.artEstado == 'AC'){
                              var row = '<tr>';
                              row += '<td width="1%"><i style="color: #00a65a; cursor: pointer;" class="fa fa-fw fa-check-square"';
                              row += 'onClick="agregar('+result.artId+')"></i></td>';
                              row += '<td width="10%">'+result.artId+'</td>';
                              row += '<td>'+result.artDescripcion+'</td>';
                              row += '<td width="10%" style="text-align: right">'+result.stock.stock+'</td>';
                              row += '<td width="10%" style="text-align: right">'+result.stock.potencial+'</td>';
                              row += '<td width="10%" style="text-align: right">'+result.stock.pedido+'</td>';
                              row += '<td width="10%" style="text-align: right">'+result.artPrecio+'</td>';
                              row += '</tr>';
                              $('#saleDetailSearch > tbody').prepend(row);
                            //}
                          });
                          $('#artIdSearch').focus();
                        }
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalSale');
              },
              dataType: 'json'
      });
  }

  $('#artIdSearch').keyup(function(){
    BuscarCompleto();
  });

  function agregar(barCode){
    $('#artId').val(barCode);
    $('#modalSearch').modal('hide');
    $('#modalReception').modal('show');
    isOpenWindow = true;
    setTimeout(function () { $('#artId').focus(); }, 1000);
  }

  function Calcular(){
    var total = 0;
    $('#orderDetail > tbody > tr').each(function() {
      var id = $(this).attr('id');
      total += parseFloat($('#' + id +' td:nth-child(7)').html());
    });

    $('#total_').html(total.toFixed(3));    
  }

  var idReserve = 0;
  function Reserve(id){
    idReserve = id;
    $('#modalReserve').modal('show');
  }

  $('#btnReserve').click(function(){
    WaitingOpen('Reservando...');
    $.ajax({
          type: 'POST',
          data: { id: idReserve, cant: $('#reserveCant').val() },
          url: 'index.php/order/setReserve', 
          success: function(resultList){
                        $('#modalReserve').modal('hide');
                          WaitingClose();
                          LoadRec(id, 'Reserve');
                },
          error: function(result){
                WaitingClose();
                ProcesarError(result.responseText, 'modalReserve');
              },
              dataType: 'json'
      });
  });

  

  var idRow = 0;
  function EntregueM(orddid, artId_){
    idRow = orddid;
    WaitingOpen('Calculando Stock...');
    $.ajax({
      type: 'POST',
      data: {depId: $('#depId').val(), artId: artId_},
      url: 'index.php/stock/getStock',
      success: function(result){
            $('#stkLbl').html(result[0]['cant']);
            WaitingClose();
            $('#entregueCant').val('0');
            $('#modalRemitos').modal('show');
            setTimeout("$('#entregueCant').select();", 1000);
      } ,
      error: function(result){
            WaitingClose();
            ProcesarError(result.responseText, 'modalRemitos');
      },
      dataType: 'json' 
    });
  }

  $('#btnEntregueM').click(function(){
    if(idRow > 0){
      var idR = '#entr_' + idRow;
      $(idR).html($('#entregueCant').val());

      var price__ = parseFloat($('#'+idRow+' td:nth-child(6)').html());
      var total__ = parseFloat($('#entregueCant').val() * price__);
      $('#'+idRow+' td:nth-child(9)').html(total__.toFixed(2));

      total__ = 0;
      $('#orderDetail > tbody > tr').each(function() {
        var id = $(this).attr('id');
        total__ += parseFloat($('#' + id +' td:nth-child(9)').html());
      });

      $('#total_').html(total__.toFixed(3));    

      idRow = 0;
      $('#modalRemitos').modal('hide');
    }
  });
</script>