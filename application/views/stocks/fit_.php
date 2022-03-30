<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error_" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<br>
<div class="row">
  <div class="col-xs-2">
    <label style="margin-top: 7px;">Depósito <strong style="color: #dd4b39">*</strong>: </label></td>
  </div>
  <div class="col-xs-6">
    <select class="form-control select2" id="depId_" style="width: 100%;">
      <?php 
        echo '<option value="-1" selected></option>';
        foreach ($deposits as $d) {
          echo '<option value="'.$d['depId'].'">'.$d['depNombre'].'</option>';
        }
      ?>
    </select>
  </div>
</div><br>
<div class="row">
  <div class="col-xs-2">
    <label style="margin-top: 7px;">Artículo <strong style="color: #dd4b39">*</strong>: </label></td>
  </div>
  <div class="col-xs-6">
    <select class="form-control select2" id="artId_" style="width: 100%;">
      <?php 
          echo '<option value="-1" selected></option>';
        foreach ($articles as $a) {
          echo '<option value="'.$a['artId'].'">'.$a['artDescripcion'].' / Cód:'.$a['artId'].'</option>';
        }
      ?>
    </select>
  </div>
  <div class="col-xs-1">
    <label style="margin-top: 7px;">Cantidad: </label></td>
  </div>
  <div class="col-xs-2">
    <input type="number" class="form-control" id="fitCant" value="1" min="1" style="width: 110px;">
  </div>
</div>
<br>