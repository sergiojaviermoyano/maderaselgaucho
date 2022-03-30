<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Depósitos</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadDeposit(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="deposits" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="20%">Acciones</th>
                <th>Descripción</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)){
                  if($list != false)
                  	foreach($list as $d)
        		        {
    	                echo '<tr>';                  
                      echo '<td>';
                      if (strpos($permission,'Edit') !== false) {
                          echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadDeposit('.$d['depId'].',\'Edit\')"></i>';
                      }
    	                if (strpos($permission,'Del') !== false) {
                          echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadDeposit('.$d['depId'].',\'Del\')"></i>';
                      }
                      if (strpos($permission,'View') !== false) {
                          echo '<i class="fa fa-fw fa-search" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadDeposit('.$d['depId'].',\'View\')"></i> ';
                      }
    	                		
    	                echo '</td>';
    	                echo '<td style="text-align: left">'.$d['depNombre'].'</td>';
                      echo '<td style="text-align: center">'.($d['depEstado'] === 'AC' ? '<small class="label bg-green">AC</small>': '<small class="label bg-yellow">IN</small>') .'</td>';
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
    $('#deposits').DataTable({
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
  
  function LoadDeposit(id__, action_){
  	id_ = id__;
  	action = action_;
  	LoadIconAction('modalAction',action);
    WaitingOpen('Cargando Depóstio');
      $.ajax({
          	type: 'POST',
          	data: { id : id_, act: action_ },
    		url: 'index.php/deposit/getDeposit', 
    		success: function(result){
			                WaitingClose();
			                $("#modalBodyDeposit").html(result.html);
			                setTimeout("$('#modalDeposit').modal('show')",800);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalDeposit');
    				},
          	dataType: 'json'
    		});
  }

  
  $('#btnSave').click(function(){
  	
  	if(action == 'View')
  	{
  		$('#modalDeposit').modal('hide');
  		return;
  	}

  	var hayError = false;
    if($('#depNombre').val() == '')
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
                    name: $('#depNombre').val(),
                    esta: $('#depEstado').val()
                  },
    		url: 'index.php/Deposit/setDeposit', 
    		success: function(result){
                			WaitingClose();
                			$('#modalDeposit').modal('hide');
                			setTimeout("cargarView('deposit', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalDeposit');
    				},
          	dataType: 'json'
    		});
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalDeposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Depósito</h4> 
      </div>
      <div class="modal-body" id="modalBodyDeposit">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>