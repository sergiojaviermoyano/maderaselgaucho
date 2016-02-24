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
    <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
    <li><a href="#tab_2" data-toggle="tab">Ventas</a></li>
    <li><a href="#tab_3" data-toggle="tab">Preprensa</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1"> <!-- Datos generales del producto -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Razón Social <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="La Plastica SRL" id="razon_social" value="<?php echo $data['provider']['razon_social'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Dirección <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Av. Libertador 123s" id="direccion" value="<?php echo $data['provider']['direccion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Envíos <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Aut. Morales" id="envios" value="<?php echo $data['provider']['envios'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono 1 <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="telefono" value="<?php echo $data['provider']['telefono'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  maxlength="20">
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono 2 : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="telefono2" value="<?php echo $data['provider']['telefono2'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  maxlength="20">
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono 3 : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="telefono3" value="<?php echo $data['provider']['telefono3'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  maxlength="20">
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Correo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="mail" value="<?php echo $data['provider']['mail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Web : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="web" value="<?php echo $data['provider']['web'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Observación : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="observacion" value="<?php echo $data['provider']['observacion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>

    </div>


    <div class="tab-pane" id="tab_2"> <!-- Imagen del cliente -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nombre : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rv_Nombre" value="<?php echo $data['provider']['rv_Nombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rv_telefono" value="<?php echo $data['provider']['rv_telefono'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Correo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rv_mail" value="<?php echo $data['provider']['rv_mail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
    </div>  


    <div class="tab-pane" id="tab_3"> <!-- Acerca del cliente -->
       
       <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nombre : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp1_nombre" value="<?php echo $data['provider']['rp1_nombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp1_telefono" value="<?php echo $data['provider']['rp1_telefono'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Correo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp1_mail" value="<?php echo $data['provider']['rp1_mail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nombre : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp2_nombre" value="<?php echo $data['provider']['rp2_nombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp2_telefono" value="<?php echo $data['provider']['rp2_telefono'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Correo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp2_mail" value="<?php echo $data['provider']['rp2_mail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-12">
          <hr>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nombre : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp3_nombre" value="<?php echo $data['provider']['rp3_nombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp3_telefono" value="<?php echo $data['provider']['rp3_telefono'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Correo : </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="rp3_mail" value="<?php echo $data['provider']['rp3_mail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
       
    </div>
  </div>
</div>