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
      <label style="margin-top: 7px;">Proveedor: <strong style="font-size: 17px;"><?php echo $data['proveedor']['prvRazonSocial'].' -- '.$data['proveedor']['prvApellido'].', '.$data['proveedor']['prvNombre'];?></strong></label>
    </div>	
</div>
<div class="row">
  <div class="col-xs-12">
      <label style="margin-top: 7px;">Domicilio: <strong style="font-size: 17px;"><?php echo $data['proveedor']['prvDomicilio'];?></strong></label>
    </div>  
</div><br>
<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Tipo Factura:</label>
    </div>  
  <div class="col-xs-10">
      <select class="form-control" id="tipoFactura">
      	<option value="FA">Factura A</option>
      	<option value="FB">Factura B</option>
      	<option value="FC">Factura C</option>
      </select>
    </div>  
</div><br>
<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Número:</label>
    </div>  
  <div class="col-xs-10">
      <input type="text" class="form-control" style="width: 120px;" placeholder="0000-00000000" id="nroFactura">
    </div>  
</div>
<div class="row">
  <div class="col-xs-12"> 
    <hr>
  </div>
</div>

<div class="row">
  <div class="col-xs-2">
      <label style="margin-top: 7px;">Detalle:</label>
    </div>  
  <div class="col-xs-4">
      <input type="text" class="form-control" id="descripcionDetalle">
    </div>  
   <div class="col-xs-2">
      <select class="form-control" id="ivaDetalle">
      	<?php 
      		foreach ($data['ivas'] as $i) {
      			echo '<option value="'.$i['ivaPorcent'].'">'.$i['ivaDescription'].'</option>';
      		}
      	?>
      </select>
    </div>  
   <div class="col-xs-3">
      <input type="text" class="form-control" id="importeDetalle">
    </div>  
   <div class="col-xs-1">
   		<button type="button" class="btn btn-success" id="btnAddItem"><i class="fa fa-fw fa-plus-square"></i></button>
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
      <table class="table table-bordered table-hover" id="items">
        <thead>
          <th>Descripción</th>
          <th>Iva</th>
          <th>Total</th>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
          <tr>
            <th colspan="2" style="text-align: right">Total: </th>
            <th style="text-align: right; font-size: 18px;" id="totalFactura">--</th>
          </tr>
        </tfoot>
      </table>
    </div>
</div><br>

<script>
$('#btnAddItem').click(function(){
  if(
      $('#descripcionDetalle').val() == '' ||
      $('#importeDetalle').val() == '' 
    ){
    return;
  }

  //Agregar a la tabla de detalle
  var row = '<tr>';
  row +=    '<td>'+$('#descripcionDetalle').val()+'</td>';
  row +=    '<td>'+$('#ivaDetalle').val()+'</td>';
  row +=    '<td style="text-align: right">'+$('#importeDetalle').val()+'</td>';
  row +=    '</tr>';
  $('#items > tbody').prepend(row);

  CalcularTotalFactura();

  $('#descripcionDetalle').val('');
  $('#importeDetalle').val('');
});

function CalcularTotalFactura(){
  var total = 0;
  var importe = 0;
  
  $("#items tbody tr").each(function (index) 
        {
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 2: 
                      importe = parseFloat($(this).text());
                      total += importe;
                      break;
                }
            });
        });
  importe = parseFloat(total);
  ImporteFcactura = importe;
  $('#totalFactura').html(importe.toFixed(2));
}
</script>