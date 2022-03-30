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
      <input type="text" class="form-control" placeholder="" id="descTalonario" value="<?php echo $data['book']['descTalonario'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Punto de Venta<strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="number" class="form-control" placeholder="" id="pvTalonario" value="<?php echo $data['book']['pvTalonario'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Número<strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="number" class="form-control" placeholder="" id="numTalonario" value="<?php echo $data['book']['numTalonario'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
</div>