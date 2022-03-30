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
      <input type="text" class="form-control" placeholder="" id="fisDescripcion" value="<?php echo $data['fiscal']['fisDescripcion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Código<strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" placeholder="" id="fisCodigo" value="<?php echo $data['fiscal']['fisCodigo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
</div>