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
    <li class="active"><a href="#tab_1" data-toggle="tab">Remitos</a></li>
    <li><a href="#tab_2" data-toggle="tab" <?php echo ($data['type'] == 'NG' ? 'style="display: none"' : '');?> >Facturas</a></li><!-- <?php echo ($data['article']['artEsSimple'] == true ? 'style="display: none"' : '');?> --> 
    <li><a href="#tab_3" data-toggle="tab">Pagos</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1">
    	<table id="credit" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th width="10%">Acciones</th>
                <th width="10%">Número</th>
                <th width="15%">Fecha</th>
                <th>Estado</th>
                <th>Orden Trabajo</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
            	foreach ($data['remitos'] as $remito) {
            		echo '<tr>';
            		echo '<td>';
            		echo '<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="PrintRemito('.$remito['remId'].')"></i>';
            		if ($data['type'] == 'BL')
            			echo '<i class="fa fa-fw fa-circle-o text-red" style="cursor: pointer; margin-left: 15px;" onclick="selectRem('.$remito['remId'].', this)"></i>';
            		echo '</td>';
            		echo '<td>'.$remito['remNumero'].'</td>';
            		$date = date_create($remito['remFecha']);                    
                    echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i').'</td>';
            		echo '<td style="text-align: center">';
                    switch ($remito['remEstado'])
                    {
                      case 'AC': 
                                echo '<small class="label bg-green">Activo</small>';
                                break;

                      case 'FA':
                                echo '<small class="label bg-blue">Facturada</small>';
                                break;

                      case 'CN':
                                echo '<small class="label bg-blue">Cancelada</small>';
                                break;

                      case 'PA':
                                echo '<small class="label bg-orange">Parcial</small>';
                                break;

                      default:
                                echo '<small class="label bg-gray">'.$remito['remEstado'].'</small>';
                                break;

                    }
            		echo '<td>'.str_pad($remito['ordId'], 8, "0", STR_PAD_LEFT).'</td>';
            		echo '</tr>';	
            	}
            	?>
            </tbody>
            <tfoot>
            	<tr>
            		<td colspan="7"><button class="btn btn-success disabled" id="btnFacturar" <?php echo ($data['type'] == 'NG' ? 'style="display: none"' : '');?> >Facturar</button></td>
            	</tr>
            </tfoot>
        </table>
    </div>

    <div class="tab-pane active" id="tab_2">
    <?php //var_dump($data['facturas']);?>
    </div>

    <div class="tab-pane active" id="tab_3">
    </div>
  </div>
</div>

<script>
$('#btnFacturar').click(function(){
  alert('facturando');
});
</script>