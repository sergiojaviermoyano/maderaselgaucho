<input type="hidden" id="permission" value="<?php echo $permission;?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Máquinas</h3>
          <?php
          if (strpos($permission,'Add') !== false) {
            echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadMachine(0,\'Add\')" id="btnAdd" title="Nueva">Agregar</button>';
          }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="machines" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Descripción</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              	foreach($list as $m)
    		        {
                  //var_dump($u);
                  echo '<tr>';
                  echo '<td>';
                  if (strpos($permission,'Edit') !== false) {
	                 echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" title="Editar" onclick="LoadMachine('.$m['idMaquina'].',\'Edit\')"></i>';
                  }
                  if (strpos($permission,'Del') !== false) {
	                 echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" title="Eliminar" onclick="LoadMachine('.$m['idMaquina'].',\'Del\')"></i>';
                  }
                  if (strpos($permission,'View') !== false) {
	                	echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" title="Consultar" onclick="LoadMachine('.$m['idMaquina'].',\'View\')"></i>';
                  }
	                echo '</td>';
	                echo '<td style="text-align: left">'.$m['descMaquina'].'</td>';
                  echo '<td style="text-align: center">'.($m['estado'] === 'AC' ? '<small class="label bg-green">AC</small>': '<small class="label bg-yellow">IN</small>') .'</td>';
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
    $('#machines').DataTable({
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

  
  var idMachine = 0;
  var acMachine = '';
  
  function LoadMachine(id_, action){
  	idMachine = id_;
  	acMachine = action;
  	LoadIconAction('modalAction',action);
  	WaitingOpen('Cargando Máquina');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action },
    		url: 'index.php/machine/getMachine', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyMachine").html(result.html);
			                setTimeout("$('#modalMachine').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					alert("error");
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(acMachine == 'View')
  	{
  		$('#modalMachine').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#descMaquina').val() == '')
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
                    id : idMachine, 
                    act: acMachine, 
                    name: $('#descMaquina').val(),
                    esta: $('#estado').val()
                  },
    		url: 'index.php/machine/setMachine', 
    		success: function(result){
                			WaitingClose();
                			$('#modalMachine').modal('hide');
                			setTimeout("cargarView('machine', 'index', '"+$('#permission').val()+"');",1000);
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
<div class="modal fade" id="modalMachine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Máquina</h4> 
      </div>
      <div class="modal-body" id="modalBodyMachine">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>