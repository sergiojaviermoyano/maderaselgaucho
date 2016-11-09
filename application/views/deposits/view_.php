<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<?php //var_dum($data['wood']);?>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" placeholder="Casa central" id="depNombre" value="<?php echo $data['deposit']['depNombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Estado <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
	    <select class="form-control select2" id="depEstado" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
	      <option value="AC" <?php echo ($data['deposit']['depEstado'] == 'AC' ? 'selected' : '');?> >Activo</option>';
	      <option value="IN" <?php echo ($data['deposit']['depEstado'] == 'IN' ? 'selected' : '');?> >Inactivo</option>';
    	</select>
    </div>
</div><br>
</div>