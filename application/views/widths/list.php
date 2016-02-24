<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Espesores</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadWidth(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="widths" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Descripción</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	foreach($list as $w)
    		        {
	                echo '<tr>';                  
                  echo '<td>';
                  if (strpos($permission,'Edit') !== false) {
                      echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadWidth('.$w['idEspesor'].',\'Edit\')"></i>';
                  }
	                if (strpos($permission,'Del') !== false) {
                      echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadWidth('.$w['idEspesor'].',\'Del\')"></i>';
                  }
                  if (strpos($permission,'View') !== false) {
                      echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadWidth('.$w['idEspesor'].',\'View\')"></i> ';
                  }
	                		
	                echo '</td>';
	                echo '<td style="text-align: left">'.$w['descEspesor'].'</td>';
                  echo '<td style="text-align: center">'.($w['estado'] === 'AC' ? '<small class="label bg-green">AC</small>': '<small class="label bg-yellow">IN</small>') .'</td>';
	                echo '</tr>';
                  
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
    $('#widths').DataTable({
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

  
  var idWidth = 0;
  var acWidth = '';
  
  function LoadWidth(id_, action){
  	idWidth = id_;
  	acWidth = action;
  	LoadIconAction('modalAction',action);
    WaitingOpen('Cargando Espesor');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/width/getWidth', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyWidth").html(result.html);
			                setTimeout("$('#modalWidth').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					alert("error");
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(acWidth == 'View')
  	{
  		$('#modalWidth').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#descEspesor').val() == '')
    {
    	hayError = true;
    }

    if(hayError == true){
    	$('#errorWidth').fadeIn('slow');
    	return;
    }

    $('#errorUsr').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: { 
                    id : idWidth, 
                    act: acWidth, 
                    name: $('#descEspesor').val(),
                    esta: $('#estado').val()
                  },
    		url: 'index.php/Width/setWidth', 
    		success: function(result){
                			WaitingClose();
                			$('#modalWidth').modal('hide');
                			setTimeout("cargarView('width', 'index', '"+$('#permission').val()+"');",1000);
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
<div class="modal fade" id="modalWidth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Espesor</h4> 
      </div>
      <div class="modal-body" id="modalBodyWidth">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>