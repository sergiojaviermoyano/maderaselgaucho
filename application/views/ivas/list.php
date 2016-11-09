<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">IVAs</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadIVA(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="fiscals" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Porcentaje</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)){
                  if($list != false)
                	foreach($list as $i)
      		        {
  	                echo '<tr>';                  
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                        echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadIVA('.$i['ivaId'].',\'Edit\')"></i>';
                    }
  	                if (strpos($permission,'Del') !== false) {
                        echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadIVA('.$i['ivaId'].',\'Del\')"></i>';
                    }
                    if (strpos($permission,'View') !== false) {
                        echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadIVA('.$i['ivaId'].',\'View\')"></i> ';
                    }
  	                		
  	                echo '</td>';
  	                echo '<td style="text-align: left">'.$i['ivaCode'].'</td>';
                    echo '<td style="text-align: left">'.$i['ivaDescription'].'</td>';
                    echo '<td style="text-align: right">'.$i['ivaPorcent'].'</td>';
                    //echo '<td style="text-align: center">'.($w['madEstado'] === 'AC' ? '<small class="label bg-green">AC</small>': '<small class="label bg-yellow">IN</small>') .'</td>';
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
    $('#fiscals').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
              "lengthMenu": "Ver _MENU_ filas por página",
              "zeroRecords": "No hay registros",
              "info": "Mostrando página _PAGE_ de _PAGES_",
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

  
  var id_ = 0;
  var action = '';
  
  function LoadIVA(id__, action_){
  	id_ = id__;
  	action = action_;
  	LoadIconAction('modalAction',action);
    WaitingOpen('Cargando IVA');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action_ },
    		url: 'index.php/iva/getIVA', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyFiscal").html(result.html);
                      $('#madPrecio').maskMoney({
                          precision: 0
                      });
                      $('#madPrecioPulgada').maskMoney({
                          precision: 0
                      });
			                setTimeout("$('#modalFiscal').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalFiscal');
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(action == 'View')
  	{
  		$('#modalFiscal').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#ivaDescription').val() == '')
    {
    	hayError = true;
    }

    if($('#ivaCode').val() == '')
    {
      hayError = true;
    }

    if($('#ivaPorcent').val() == '')
    {
      hayError = true;
    }

    if(hayError == true){
    	$('#error').fadeIn('slow');
    	return;
    }

    $('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: { 
                    id : id_, 
                    act: action, 
                    name: $('#ivaDescription').val(),
                    code: $('#ivaCode').val(),
                    por:  $('#ivaPorcent').val()
                  },
    		url: 'index.php/iva/setIVA', 
    		success: function(result){
                			WaitingClose();
                			$('#modalFiscal').modal('hide');
                			setTimeout("cargarView('iva', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalFiscal');
    				},
          	dataType: 'json'
    		});
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalFiscal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> IVA</h4> 
      </div>
      <div class="modal-body" id="modalBodyFiscal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>