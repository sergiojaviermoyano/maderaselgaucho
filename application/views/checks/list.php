<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Cheques</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadCheck(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="checks" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="10%">Acciones</th>
                <th width="20%">Número</th>
                <th width="10%">Banco</th>
                <th width="10%">Importe</th>
                <th width="10%">Vencimiento</th>
                <th width="10%">Estado</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                if(isset($list)){
                  if($list != false)
                	foreach($list as $c)
      		        {
  	                echo '<tr>';                  
                    echo '<td>';
                    if (strpos($permission,'Edit') !== false) {
                        echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" onclick="LoadCheck('.$c['cheId'].',\'Edit\')"></i>';
                    }
  	                if (strpos($permission,'Del') !== false) {
                        echo '<i class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;" onclick="LoadCheck('.$c['cheId'].',\'Del\')"></i>';
                    }
                    if (strpos($permission,'Deposit') !== false && $c['cheEstado'] === 'AC') {
                        echo '<i class="fa fa-fw fa-thumb-tack" style="color: #3c8dbc; cursor: pointer; margin-left: 15px;" onclick="LoadCheck('.$c['cheId'].',\'Deposit\')"></i> ';
                    }
  	                		
  	                echo '</td>';
  	                echo '<td style="text-align: right">'.$c['cheNumero'].'</td>';
                    echo '<td>'.$c['bancoDescripcion'].'</td>';
                    echo '<td style="text-align: right">'.$c['cheImporte'].'</td>';
                    $date = date_create($c['cheVencimiento']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y').'</td>';
                    //echo '<td style="text-align: center">'.$c['cheEstado'].'</td>';
                    echo '<td style="text-align: center">';
                    switch($c['cheEstado']){
                      case 'AC':
                        echo '<small class="label bg-green">Activo</small>';
                        break;
                      case 'UT':
                        echo '<small class="label bg-blue">Utilizado</small>';
                        break;
                      case 'DP':
                        echo '<small class="label bg-yellow">Depositado</small>';
                        break;
                    } 
                    echo '</td>';
                    echo '<td style="text-align: center">';
                    if ($c['cheType'] == 'BL'){
                      echo '<i class="fa fa-fw fa-circle-o"></i>';
                    } else {
                      echo '<i class="fa fa-fw fa-circle"></i>';
                    }
                    echo '</td>';


                    //echo '<td style="text-align: center">'.str_pad($t['pvTalonario'], 4, "0", STR_PAD_LEFT).'-'.str_pad($t['numTalonario'], 8, "0", STR_PAD_LEFT).'</td>';
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
    $('#checks').DataTable({
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
  
  function LoadCheck(id__, action_){
  	id_ = id__;
  	action = action_;
  	LoadIconAction('modalAction',action);
    $('#modalCheck').modal('show');
  }

  
  $('#btnSave').click(function(){
  	
  	if(action == 'View')
  	{
  		$('#modalCheck').modal('hide');
  		return;
  	}


    //$('#error').fadeOut('slow');
    WaitingOpen('Guardando cambios');
    	$.ajax({
          	type: 'POST',
          	data: { 
                    id : id_, 
                    act: action
                  },
    		url: 'index.php/check/changeStatus', 
    		success: function(result){
                			WaitingClose();
                			$('#modalCheck').modal('hide');
                			setTimeout("cargarView('check', 'index', '"+$('#permission').val()+"');",1000);
    					},
    		error: function(result){
    					WaitingClose();
    					ProcesarError(result.responseText, 'modalCheck');
    				},
          	dataType: 'json'
    		});
  });

</script>


<!-- Modal -->
<div class="modal fade" id="modalCheck" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalAction"> </span> Cheque</h4> 
      </div>
      <div class="modal-body" id="modalBodyBook">
        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-warning alert-dismissable" id="error" style="display: block">
                  <h4><i class="icon fa fa-warning"></i> Importante!!!</h4>
                  ¿ Esta seguro de depositar el cheque seleccionado ?
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnSave">Guardar</button>
      </div>
    </div>
  </div>
</div>