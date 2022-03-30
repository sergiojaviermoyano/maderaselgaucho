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
      <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="ivaCode" value="<?php echo $data['iva']['ivaCode'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="ivaDescription" value="<?php echo $data['iva']['ivaDescription'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Porcentaje<strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="number" class="form-control" placeholder="" id="ivaPorcent" value="<?php echo $data['iva']['ivaPorcent'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
</div>