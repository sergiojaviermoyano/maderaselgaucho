<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" placeholder="Dobladora XVS" id="descMaquina" value="<?php echo $data['machine']['descMaquina'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Estado <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
	    <select class="form-control select2" id="estado" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
	      <option value="AC" <?php echo ($data['machine']['estado'] == 'AC' ? 'selected' : '');?> >Activo</option>';
	      <option value="IN" <?php echo ($data['machine']['estado'] == 'IN' ? 'selected' : '');?> >Inactivo</option>';
    	</select>
    </div>
</div><br>
</div>