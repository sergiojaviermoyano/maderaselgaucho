<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Artículos</h3>
          <?php
          if (strpos($permission,'Add') !== false) { 
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadArt(0,\'Add\')" id="btnAdd">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="articles" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th width="5%">Código</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th width="5%">Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)) {                  
                	foreach($list as $a)
      		        {
  	                echo '<tr>';
  	                echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
  	                	echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'Edit\')"></i>';
                    }
                    if (strpos($permission,'Del') !== false) {
  	                	echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'Del\')"></i>';
                    }
                    if (strpos($permission,'View') !== false) {
  	                	echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadArt('.$a['artId'].',\'View\')"></i>';
                    }
  	                echo '</td>';
                    echo '<td style="text-align: right">'.$a['artId'].'</td>';
  	                echo '<td style="text-align: left">'.$a['artDescripcion'].'</td>';
                    echo '<td style="text-align: left">'.($a['artTipoMaterial'] == 'M' ? 'Maderas' : ($a['artTipoMaterial'] == 'C' ? 'Clavos': 'Esquineros')).'</td>';
                    echo '<td style="text-align: center">'.($a['artEstado'] == 'AC' ? 'Activo' : ($a['artEstado'] == 'IN' ? 'Inactivo' : 'Suspendido')).'</td>';
  	                echo '</tr>';
                    
      		        }
                  
                }
              ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
  $(function () {
    //$("#groups").DataTable();
    $('#articles').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "language": {
            "lengthMenu": "Ver _MENU_ filas por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrando de un total de _MAX_ registros)",
            "sSearch": "Buscar:  ",
            "oPaginate": {
                "sNext": "Sig.",
                "sPrevious": "Ant."
              }
        }
    });
  });

  var idArt = 0;
  var acArt = '';
  
  function LoadArt(id_, action){
  	idArt = id_;
  	acArt = action;
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando Artículo');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/article/getArticle', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyArticle").html(result.html);
			                setTimeout("$('#modalArticle').modal('show')",800);
                      setTimeout("CalcularPrecio()",1000);
                      setTimeout("CalcularTotal()", 1000);
                      $("#artPrecio").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artOperativo").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artEstructura").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artFlete").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artServicio").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artOtrosCostos").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("#artMargen").maskMoney({allowNegative: false, thousands:'', decimal:'.'});
                      $("[data-mask]").inputmask();
    					},
    		error: function(result){
    					WaitingClose();
    					alert("error");
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){

  	if(acArt == 'View')
  	{
  		$('#modalArticle').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#artDescripcion').val() == '')
    {
      hayError = true;
    }

    if($('#artPrecioVenta').val() == '')
    {
      hayError = true;
    }

    var detail = [];

    if($('#artTipo').val() == 'C'){
      $('#articles_ > tbody > tr').each(function() {
        var id = $(this).attr('id');
        var artId = parseInt($('#' + id +' td:nth-child(2)').html());
        var cantId = parseInt($('#' + id +' td:nth-child(5)').html());

        var obj = [artId , cantId];
        detail.push(obj);
      });
    }

    if(hayError == true){
    	$('#errorArt').fadeIn('slow');
    	return;
    }
    debugger;

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: { 
                    id :      idArt, 
                    act:      acArt, 
                    name:     $('#artDescripcion').val(),
                    marg:     $('#artMargen').val(),
                    margP:    $('#artMargenEsPorcentaje').prop('checked'),
                    price:    $('#artPrecio').val(),
                    status:   $('#artEstado').val(),
                    mat:      $('#artTipoMaterial').val(),
                    esPie:    $('#artSeVendePorPie').prop('checked'),
                    esSimple: $('#artTipo').val(),
                    oper:     $('#artOperativo').val(),
                    operP:    $('#artOperativoEsPorcentaje').prop('checked'),
                    estr:     $('#artEstructura').val(),
                    estrP:    $('#artEstructuraEsPorcentaje').prop('checked'),
                    flete:    $('#artFlete').val(),
                    fleteP:   $('#artFleteEsPorcentaje').prop('checked'),
                    serv:     $('#artServicio').val(),
                    servP:    $('#artServicioEsPorcentaje').prop('checked'),
                    otrG:     $('#artOtrosCostos').val(),
                    otrGP:    $('#artOtrosCostosEsPorcentaje').prop('checked'),
                    min:      $('#artMinimo').val(),
                    max:      $('#artMaximo').val(),
                    pdp:      $('#artPuntoPedido').val(),
                    espesor:  $('#artAlto').val(),
                    ancho:    $('#artAncho').val(),
                    largo:    $('#artLargo').val(),
                    madId:    $('#madId').val(),
                    det:      detail,
                    ivaId:    $('#ivaId').val()
                  },
    		url: 'index.php/article/setArticle', 
    		success: function(result){
                			WaitingClose();
                			$('#modalArticle').modal('hide');
                			setTimeout("cargarView('Article', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					alert("error");
    				},
          	dataType: 'json'
    		});
  });

</script>

<!-- Modal -->
<div class="modal fade" id="modalArticle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 70%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Artículo</h4> 
      </div>
      <div class="modal-body" id="modalBodyArticle">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalArticleSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalActionSearch"> </span> Buscador de Artículo</h4> 
      </div>
      <div class="modal-body" id="modalBodyArticleSearch">
        <div class="row">
          <div class="col-xs-4">
              <label style="margin-top: 7px;">Buscar : </label>
            </div>
          <div class="col-xs-5">
              <input type="text" class="form-control" id="artBuscadorSearch" >
            </div>
        </div>
        <div class="row">
          <div class="col-xs-12"><hr></div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <table width="100%" id="articlesSerched" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="5%"></th>
                  <th width="15%">Código</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table> 
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>

$('#artBuscadorSearch').keyup(function(e){ 
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    if(code==13)
      e.preventDefault();
    if(code==32||code==13||code==188||code==186){
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
                        //setTimeout("CalcularPrecio()",1000);
                },
          error: function(result){
                WaitingClose();
                alert("error");
              },
              dataType: 'json'
          });
    } // missing closing if brace
});

var rowId = 0;
function Add(id, desc, price){
  price = parseFloat(price).toFixed(3);
  var row = '<tr id="'+rowId+'">';
  row +=    '<td style="text-align: center" onclick="DeleteRow(' + rowId + ')"><i class="fa fa-fw fa-close" style="color: #dd4b39"></i></td>';
  row +=    '<td>' + id + '</td>';
  row +=    '<td>' + desc + '</td>';
  row +=    '<td width="1%" onClick="sumar(' + rowId + ')"><i class="fa fa-fw fa-plus-square" style="color: #00a65a"></i></td>';
  row +=    '<td style="text-align: center">1</td>';
  row +=    '<td width="1%" onClick="restar(' + rowId + ')"><i class="fa fa-fw fa-minus-square" style="color: #dd4b39"></i></td>';
  row +=    '<td>'+price+'</td>';
  row +=    '<td>'+price+'</td>';
  row +=    '</tr>';
  $('#articles_ > tbody').append(row);
  rowId++;

  CalcularTotal();
}

function DeleteRow(id)
{
  $('#'+id).remove();

  CalcularTotal();
}

function sumar(id){
  var cantId = $('#' + id +' td:nth-child(5)');
  var cant = parseInt(cantId.html());
  cant++;
  cantId.html(cant);

  var priceId = $('#' + id +' td:nth-child(7)');
  var totalId = $('#' + id +' td:nth-child(8)');

  var price = parseFloat(priceId.html()).toFixed(3);
  totalId.html((cant * price).toFixed(3))

  CalcularTotal();
}

function restar(id){
  var cantId = $('#' + id +' td:nth-child(5)');
  var cant = parseInt(cantId.html());

  if(cant <= 1){
      cantId.html('1');    
  } else {
    cant--;
    cantId.html(cant);
  }

  var priceId = $('#' + id +' td:nth-child(7)');
  var totalId = $('#' + id +' td:nth-child(8)');

  var price = parseFloat(priceId.html()).toFixed(3);
  totalId.html((cant * price).toFixed(3))

  CalcularTotal();
}

function CalcularTotal(){
  var total = 0;
  $('#articles_ > tbody > tr').each(function() {
    var id = $(this).attr('id');
    total += parseFloat($('#' + id +' td:nth-child(8)').html());
  });

  $('#costeTotal').html(total.toFixed(3));
  if($('#artTipo').val() == 'C'){
   $('#artPrecio').val(total.toFixed(3));
  } 
  CalcularPrecio();
}
</script>