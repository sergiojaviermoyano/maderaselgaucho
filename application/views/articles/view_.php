
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
    <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
    <li id="tabComposicion" <?php echo ($data['article']['artEsSimple'] == true ? 'style="display: none"' : '');?>><a href="#tab_21" data-toggle="tab">Composición</a></li>
    <li><a href="#tab_2" data-toggle="tab">Precio</a></li><!---  > ---->
    <li><a href="#tab_3" data-toggle="tab">Stock</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1"> <!-- Datos generales del Articulo -->
      
      <!-- Tipo de Articulo -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Tipo <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="artTipo" <?php echo ($data['read'] == true || $data['article']['action'] != 'Add' ? 'disabled="disabled"' : '');?> >
              <option value="S" <?php echo ($data['article']['artEsSimple'] == true ? 'selected="selected"' : '');?>>Simple</option>
              <option value="C" <?php echo ($data['article']['artEsSimple'] == false ? 'selected="selected"' : '');?>>Compuesto</option>
            </select>
          </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <!-- Código del Artículo -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artId" value="<?php echo $data['article']['artId'];?>" disabled="disabled">
          </div>
      </div><br>
      
      <!-- Descripción del Artículo -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artDescripcion" value="<?php echo $data['article']['artDescripcion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <!-- Tipo de Material -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Tipo Material <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="artTipoMaterial" <?php echo ($data['read'] == true || $data['article']['artEsSimple'] == false ? 'disabled="disabled"' : '');?>  >
              <option value="M" <?php echo ($data['article']['artTipoMaterial'] == 'M' ? 'selected="selected"' : '');?>>Madera</option>
              <option value="C" <?php echo ($data['article']['artTipoMaterial'] == 'C' ? 'selected="selected"' : '');?>>Clavo</option>
              <option value="E" <?php echo ($data['article']['artTipoMaterial'] == 'E' ? 'selected="selected"' : '');?>>Esquinero</option>
            </select>
          </div>
      </div><br>

      <!-- Tipo de Madera -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Madera : </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="madId"  <?php echo ($data['read'] == true || $data['article']['artTipoMaterial'] != 'M' || $data['article']['artEsSimple'] == false ? 'disabled="disabled"' : '');?> >
              <?php 
                foreach ($data['woods'] as $m) {
                  echo '<option value="'.$m['madId'].'" data-precio="'.$m['madPrecio'].'" data-preciopulgada="'.$m['madPrecioPulgada'].'" '.($data['article']['madId'] == $m['madId'] ? 'selected' : '').'>'.$m['madDescripcion'].'</option>';
                }
              ?>
            </select>
          </div>
      </div><br>

      <!-- -->

      <!-- Se vende por pie -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Se Vende Por Pie : </label>
          </div>
        <div class="col-xs-5">
            <input type="checkbox" id="artSeVendePorPie" <?php echo($data['article']['artSeVendePorPie'] == true ? 'checked': ''); ?> <?php echo ($data['read'] == true || $data['article']['artTipoMaterial'] != 'M' || $data['article']['artEsSimple'] == false ? 'disabled="disabled"' : '');?> >
          </div>
      </div><br>

      <!-- Iva -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">IVA: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="ivaId"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                foreach ($data['ivas'] as $i) {
                  echo '<option value="'.$i['ivaId'].'" '.($data['article']['ivaId'] == $i['ivaId'] ? 'selected' : '').'>'.$i['ivaDescription'].'</option>';
                }
              ?>
            </select>
          </div>
      </div><br>

      <!-- -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Estado: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="artEstado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                  echo '<option value="AC" '.($data['article']['artEstado'] == 'AC' ? 'selected' : '').'>Activo</option>';
                  echo '<option value="IN" '.($data['article']['artEstado'] == 'IN' ? 'selected' : '').'>Inactivo</option>';
                  echo '<option value="SU" '.($data['article']['artEstado'] == 'SU' ? 'selected' : '').'>Suspendido</option>';
              ?>
            </select>
          </div>
      </div>
    </div>


    <div class="tab-pane" id="tab_2"> <!-- Imagen del cliente -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Espesor (mm): </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control clacularPrecio" id="artAlto" value="<?php echo $data['article']['artEspesor'];?>" <?php echo ($data['article']['artTipoMaterial'] == 'M' && $data['article']['artEsSimple'] == true ? '': 'disabled="disabled"');?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Ancho (mm): </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control clacularPrecio" id="artAncho" value="<?php echo $data['article']['artAlto'];?>" <?php echo ($data['article']['artTipoMaterial'] == 'M' && $data['article']['artEsSimple'] == true ? '': 'disabled="disabled"');?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Largo (mm): </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control clacularPrecio" id="artLargo" value="<?php echo $data['article']['artlargo'];?>" <?php echo ($data['article']['artTipoMaterial'] == 'M' && $data['article']['artEsSimple'] == true ? '': 'disabled="disabled"');?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-3">
            <label style="margin-top: 7px;">P.x Pie</label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;" id="p_x_pie"><?php echo $data['article']['p_x_pie']; ?></label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">P.x Pulgada</label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;" id="p_x_pul"><?php echo $data['article']['p_x_pul']; ?></label>
          </div>
      </div>

      <div class="row">
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Cant. Pie</label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;" id="c_pie">0.00</label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Cant. Pulgadas</label>
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;" id="c_pul">0.00</label>
          </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>
              

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Precio Costo: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control clacularPrecio" id="artPrecio" value="<?php echo $data['article']['artPrecio'];?>" <?php echo ($data['article']['artTipoMaterial'] != 'M' ? '': 'disabled="disabled"');?> <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Operativo : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artOperativo" value="<?php echo $data['article']['artOperativo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artOperativoEsPorcentaje" <?php echo $data['article']['artOperativoEsPorcentaje'] == true ? 'checked' : '';?> >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Estructura : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artEstructura" value="<?php echo $data['article']['artEstructura'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artEstructuraEsPorcentaje" <?php echo $data['article']['artEstructuraEsPorcentaje'] == true ? 'checked' : '';?> >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Fletes : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artFlete" value="<?php echo $data['article']['artFlete'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artFleteEsPorcentaje" <?php echo $data['article']['artFleteEsPorcentaje'] == true ? 'checked' : '';?> >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Servicio : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artServicio" value="<?php echo $data['article']['artServicio'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artServicioEsPorcentaje" <?php echo $data['article']['artServicioEsPorcentaje'] == true ? 'checked' : '';?> >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Otros Gastos : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artOtrosCostos" value="<?php echo $data['article']['artOtrosCostos'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artOtrosCostosEsPorcentaje" <?php echo $data['article']['artOtrosCostosEsPorcentaje'] == true ? 'checked' : '';?> >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Margen : </label>
          </div>
        <div class="col-xs-4">
            <input type="text" class="form-control clacularPrecio" id="artMargen" value="<?php echo $data['article']['artMargen'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
        <div class="col-xs-3">
            <label style="margin-top: 7px;">Es Porcentaje : </label>
          </div>
        <div class="col-xs-1">
            <input style="margin-top: 12px;" class="clacularPrecio" type="checkbox" id="artMargenEsPorcentaje" <?php echo $data['article']['artMargenEsPorcentaje'] == 1 ? 'checked' : '';?>>
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Precio Venta: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artPrecioVenta" value="" disabled="disabled" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

    </div>  


    <div class="tab-pane" id="tab_3"> <!-- Acerca del cliente -->
       
       <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Máximo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artMaximo" value="<?php echo $data['article']['artMaximo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Mínimo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artMinimo" value="<?php echo $data['article']['artMinimo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
       
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Punto de Pedido : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artPuntoPedido" value="<?php echo $data['article']['artPuntoPedido'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

    </div>

    <div class="tab-pane" id="tab_21"> <!-- Acerca del cliente -->
      
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Artículo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="artBuscador" value="" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <table id="articles_" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="5%"></th>
                <th width="15%">Código</th>
                <th>Descripción</th>
                <th colspan="3">Cantidad</th>
                <th>P.Unitario</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <!-- Acá el cuerpo -->
              <?php 
              $row = 1000;
              foreach ($data['article']['detail'] as $item) {
                echo '<tr id="'.$row.'">';
                echo '<td style="text-align: center" onclick="DeleteRow('.$row.')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
                echo '<td>'.$item['artId_'].'</td>';
                echo '<td>'.$item['artDescripcion'].'</td>';
                echo '<td width="1%" onClick="sumar('.$row.')"><i class="fa fa-fw fa-plus-square" style="color: #00a65a"></i></td>';
                echo '<td style="text-align: center">'.$item['artDetCantidad'].'</td>';
                echo '<td width="1%" onClick="restar('.$row.')"><i class="fa fa-fw fa-minus-square" style="color: #dd4b39"></i></td>';
                echo '<td>'.number_format($item['artPrecio'], 3).'</td>';
                echo '<td>'.number_format(($item['artPrecio'] * $item['artDetCantidad']), 3).'</td>';
                echo '</tr>';
                $row++;

              }
              ?>
            </tbody>
          </table>
        </div>
      </div><br>

      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-9">
            <label style="margin-top: 7px;">Total : </label>
          </div>
        <div class="col-xs-3">
            <label id="costeTotal">0.000</label>
          </div>
      </div>

    </div>

  </div>
</div>

<script>

$('#artTipo').change(function() {
  $('#artAlto').val('');
  $('#artAncho').val('');
  $('#artLargo').val('');
  if( $(this).val() == 'S' ){
    //Simple 
    $('#tabComposicion').hide('slow');
    $('#artTipoMaterial').prop('disabled', false);
    $('#madId').prop('disabled', false);
    $('#artSeVendePorPie').prop('disabled', false);
    $('#artAlto').prop('disabled', false);
    $('#artAncho').prop('disabled', false);
    $('#artLargo').prop('disabled', false);
  } else {
    //Compuesto
    $('#tabComposicion').show('slow');
    $('#artTipoMaterial').prop('disabled', true);
    $('#madId').prop('disabled', true);
    $('#artSeVendePorPie').prop('disabled', true);
    $('#artAlto').prop('disabled', true);
    $('#artAncho').prop('disabled', true);
    $('#artLargo').prop('disabled', true);
  }
});

$('#artTipoMaterial').change(function() {
  
  $('#artAlto').val('');
  $('#artAncho').val('');
  $('#artLargo').val('');
  $('#artPrecio').val('');
  $('#artPrecioVenta').val('');

  if( $(this).val() == 'M') {
    //Maderas
    $('#artAlto').prop('disabled', false);
    $('#artAncho').prop('disabled', false);
    $('#artLargo').prop('disabled', false);
    $('#artPrecio').prop('disabled', true);
    $('#madId').prop('disabled', false);
    $('#artSeVendePorPie').prop('disabled', false);

    var selected = $('#madId').find('option:selected');
    var precioPieMadera = selected.data('precio'); 
    var precioPulgadaMadera = selected.data('preciopulgada'); 

    $('#p_x_pie').html(precioPieMadera);
    $('#p_x_pul').html(precioPulgadaMadera);

  } else {
    //Clavos y Esquinero
    $('#artAlto').prop('disabled', true);
    $('#artAncho').prop('disabled', true);
    $('#artLargo').prop('disabled', true);
    $('#artPrecio').prop('disabled', false);
    $('#madId').prop('disabled', true);
    $('#artSeVendePorPie').prop('disabled', true);

    $('#p_x_pie').html('0.00');
    $('#p_x_pul').html('0.00');

    $('#c_pie').html('0.00');
    $('#c_pul').html('0.00');

  }

});

$('#madId').change(function() {
  //Calcular precio de venta
  var selected = $('#madId').find('option:selected');
  var precioPieMadera = selected.data('precio'); 
  var precioPulgadaMadera = selected.data('preciopulgada'); 

  $('#p_x_pie').html(precioPieMadera);
  $('#p_x_pul').html(precioPulgadaMadera);

  CalcularPrecio();

});


function CalcularPrecio(){
  var precioCosto = 0;
  var cantidadPie = 0;
  var cantidadPul = 0;

  if($('#artTipo').val() == 'S'){
    if($('#artTipoMaterial').val() == 'M'){

      var selected = $('#madId').find('option:selected');
      var precioPieMadera = selected.data('precio'); 
      var precioPulgadaMadera = selected.data('preciopulgada');     

      var alto = $('#artAlto').val() == '' ? 0 : parseInt($('#artAlto').val());
      var largo = $('#artLargo').val() == '' ? 0 : parseInt($('#artLargo').val());
      var ancho = $('#artAncho').val() == '' ? 0 : parseInt($('#artAncho').val());

      //Calcular el precio de costo
      cantidadPie = parseFloat((alto * largo * ancho * 4.24) / 10000000).toFixed(3);
      precioCosto = precioPieMadera * cantidadPie;

      $('#artPrecio').val(parseFloat(precioCosto).toFixed(3));
    } else {
      precioCosto = parseFloat($('#artPrecio').val());
    }
  } else {
    precioCosto = parseFloat($('#artPrecio').val());
  }


  if(cantidadPie == 0){
    $('#c_pie').html('0.00');
    $('#c_pul').html('0.00');
  } else {
    $('#c_pie').html(parseFloat(cantidadPie).toFixed(3));
    $('#c_pul').html(parseFloat(cantidadPie * 3.77).toFixed(3));
  }

    //Calcular el precio de venta
    var operativo = $('#artOperativo').val() == '' ? 0 : parseFloat($('#artOperativo').val());
    var operativoEsPorcentaje = $("#artOperativoEsPorcentaje").is(':checked') == true ? true : false;
    var estructura = $('#artEstructura').val() == '' ? 0 : parseFloat($('#artEstructura').val());
    var estructuraEsPorcentaje = $("#artEstructuraEsPorcentaje").is(':checked') == true ? true : false;
    var flete = $('#artFlete').val() == '' ? 0 : parseFloat($('#artFlete').val());
    var fleteEsPorcentaje = $("#artFleteEsPorcentaje").is(':checked') == true ? true : false;
    var servicio = $('#artServicio').val() == '' ? 0 : parseFloat($('#artServicio').val());
    var servicioEsPorcentaje = $("#artServicioEsPorcentaje").is(':checked') == true ? true : false;
    var otrosCostos = $('#artOtrosCostos').val() == '' ? 0 : parseFloat($('#artOtrosCostos').val());
    var otrosCostosEsPorcentaje = $("#artOtrosCostosEsPorcentaje").is(':checked') == true ? true : false;
    var margen = $('#artMargen').val() == '' ? 0 : parseFloat($('#artMargen').val());
    var margenEsPorcentaje = $("#artMargenEsPorcentaje").is(':checked') == true ? true : false;

    var precioVenta = precioCosto;
    var acumulado = 0;
    
    //Sumar Operativo
    if(operativoEsPorcentaje == true){
      acumulado = precioCosto * (operativo / 100);
    } else {
      acumulado = operativo;
    }
    precioVenta += acumulado;

    //Sumar Estructura
    if(estructuraEsPorcentaje == true){
      acumulado = precioVenta * (estructura / 100);
    } else {
      acumulado = estructura;
    }
    precioVenta += acumulado;

    //Sumar Flete
    if(fleteEsPorcentaje == true){
      acumulado = precioVenta * (flete / 100);
    } else {
      acumulado = flete;
    }
    precioVenta += acumulado;

    //Sumar Servicios
    if(servicioEsPorcentaje == true){
      acumulado = precioVenta * (servicio / 100);
    } else {
      acumulado = servicio;
    }
    precioVenta += acumulado;

    //Sumar Otros Costos
    if(otrosCostosEsPorcentaje == true){
      acumulado = precioVenta * (otrosCostos / 100);
    } else {
      acumulado = otrosCostos;
    }
    precioVenta += acumulado;

    //Sumar margen
    if(margenEsPorcentaje == true){
      acumulado = precioVenta * (margen / 100);
    } else {
      acumulado = margen;
    }
    precioVenta += acumulado;

    //var precioVenta = precioCosto + gasto1 + gasto2;
    $('#artPrecioVenta').val(parseFloat(precioVenta).toFixed(3));
}

$('.clacularPrecio').keyup(function() {
  CalcularPrecio();
});

$('.clacularPrecio').change(function() {
  CalcularPrecio();
});

$('#artBuscador').keyup(function(e) {
    var code = e.which; 
    if(code==13){
      //Abrir buscador
      LoadIconAction('modalActionSearch','View');
      WaitingOpen('Buscando...');
      //Buscar
      $.ajax({
            type: 'POST',
            data: { str : $(this).val() },
        url: 'index.php/article/getArticleSingles', 
        success: function(result){
                      $('#articlesSerched > tbody').html('');
                      var rows = '';
                      $.each(result, function(key, obj){
                        rows += '<tr style="cursor: pointer" onClick="Add('+obj['artId']+',\''+obj['artDescripcion']+'\', '+obj['artPrecio']+')">';
                        rows += '<td style="text-align: center"><i class="fa fa-fw fa-dot-circle-o" style="color: #00a65a"></i></td>';
                        rows += '<td>' + obj['artId'] + '</td>';
                        rows += '<td>' + obj['artDescripcion'] + '</td>';
                        rows += '<td>' + obj['artPrecio'] + '</td>';
                        rows += '<tr>';
                      });
                      $('#articlesSerched > tbody').html(rows);
                      WaitingClose();
                      setTimeout("$('#modalArticleSearch').modal('show');",800);
              },
        error: function(result){
              WaitingClose();
              alert("error");
            },
            dataType: 'json'
        });
    }
});

</script>