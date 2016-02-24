
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="errorCust" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
    <li><a href="#tab_2" data-toggle="tab">Imagen</a></li>
    <li><a href="#tab_3" data-toggle="tab">Acerca de</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1"> <!-- Datos generales del cliente -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nro. Cliente <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="" id="cliNroCustomer" value="<?php echo $data['customer']['cliNroCustomer'];?>" disabled="disabled" >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Nombre <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Nombre" id="cliName" value="<?php echo $data['customer']['cliName'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Apellido <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Apellido" id="cliLastName" value="<?php echo $data['customer']['cliLastName'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Dni <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="12345678" id="cliDni" value="<?php echo $data['customer']['cliDni'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  maxlength="8">
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Fec. Nacimiento <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" id="cliDateOfBirth" placeholder="dd-mm-aaaa" value="<?php echo $data['customer']['cliDateOfBirth'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Domicilio: </label>
          </div>
        <div class="col-xs-5">
            <input type="input" class="form-control" placeholder="ej: Barrio Los Olivos M/E Casa/23" id="cliAddress" value="<?php echo $data['customer']['cliAddress'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Teléfono: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="0264 - 4961020" id="cliPhone" value="<?php echo $data['customer']['cliPhone'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Celular: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="0264 - 155095888" id="cliMovil" value="<?php echo $data['customer']['cliMovil'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Mail: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="claudia.perez@hotmail.com" id="cliEmail" value="<?php echo $data['customer']['cliEmail'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Zona: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="zonaId"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                foreach ($data['zone'] as $z) {
                  echo '<option value="'.$z['zonaId'].'" '.($data['customer']['zonaId'] == $z['zonaId'] ? 'selected' : '').'>'.$z['zonaName'].'</option>';
                }
              ?>
            </select>
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Días proxímo cobro: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="cliDay"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                for ($i = 1; $i < 31; $i++) {
                  echo '<option value="'.$i.'" '.($data['customer']['cliDay'] == $i ? 'selected' : '').'>'.$i.'</option>';
                }
              ?>
            </select>
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
          <label style="margin-top: 7px;">Tipo de Cliente: </label>
        </div>
        <div class="col-xs-5">
          <!--
          <div class="input-group my-colorpicker">
            <input type="text" class="form-control">
            <div class="input-group-addon">
              <i style="background-color: rgb(0, 0, 0);"></i>
            </div>
          </div>-->
          <select class="form-control" id="cliColor"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                  echo '<option value="#00a65a" '.($data['customer']['cliColor'] == '#00a65a' ? 'selected' : '').'>Bueno</option>';
                  echo '<option value="#f39c12 " '.($data['customer']['cliColor'] == '#f39c12' ? 'selected' : '').'>Regular</option>';
                  echo '<option value="#dd4b39" '.($data['customer']['cliColor'] == '#dd4b39' ? 'selected' : '').'>Malo</option>';
              ?>
          </select>
        </div>
      </div>
    </div>


    <div class="tab-pane" id="tab_2"> <!-- Imagen del cliente -->
      <center>
      <div id='botonera'>
          <button id='botonIniciar' type="button" class="btn btn-success" onclick="ActiveCamera()"><i class="fa fa-play"></i></button>
          <button id='botonDetener' type="button" class="btn btn-danger" onclick="StopCamera()" disabled="disabled"><i class="fa fa-pause"></i></button>
          <button id='botonFoto' type="button" class="btn btn-primary" disabled="disabled"><i class="fa fa-camera"></i></button>
      </div>
      <div class="contenedor">
          <h5>Cámara</h5>
          <video id="camara" autoplay controls></video>
      </div>
      <div class="contenedor">
          <h5>Foto</h5>
          <canvas id="foto" style="display:none"></canvas>
          <img id="imgCamera" src="<?php echo $data['customer']['cliImagePath'];?>">
          <input type="hidden" id="updatePicture" value="0">
      </div>
      </center>
    </div>  


    <div class="tab-pane" id="tab_3"> <!-- Acerca del cliente -->
       <?php //var_dump($data['preferences']);?>
       <?php
          foreach ($data['preferences'] as $pre) {
            ?>
            <div id="preferences">
            <a role="button" data-toggle="collapse" href="#collapse<?php echo $pre->famName;?>" aria-expanded="false" aria-controls="collapse<?php echo $pre->famName;?>" class="modal-title"><?php echo str_replace("_", " ", $pre->famName);?></a>
            <div class="collapse" id="collapse<?php echo $pre->famName;?>">
              <div>
                <?php
                  if(count($pre->subf) >0)
                  {
                    foreach ($pre->subf as $sf) {
                      if($sf['acepted'] == null)
                        echo '<input type="checkbox" id="'.$sf['sfamId'].'" style="margin-left: 5%;" '.($data['read'] == true ? 'disabled="disabled"' : '').'>'.$sf['sfamName'].'<br>';
                      else
                        echo '<input type="checkbox" id="'.$sf['sfamId'].'" style="margin-left: 5%;" '.($data['read'] == true ? 'disabled="disabled"' : '').' checked>'.$sf['sfamName'].'<br>';
                    }
                  }
                ?>
              </div>
            </div>  
            </div>
            <?php
          }
        ?>
    </div>
  </div>
</div>