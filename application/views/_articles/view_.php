
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
    <li><a href="#tab_2" data-toggle="tab">Imagenes</a></li>
    <!--<li><a href="#tab_3" data-toggle="tab">Acerca de</a></li>-->
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1"> <!-- Datos generales del producto -->
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Código Identificador" id="prodCode" value="<?php echo $data['article']['prodCode'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="Descripción" id="prodDescription" value="<?php echo $data['article']['prodDescription'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Precio <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="0.00" id="prodPrice" value="<?php echo $data['article']['prodPrice'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Margen (ganancia) <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <input type="text" class="form-control" placeholder="0.00" id="prodMargin" value="<?php echo $data['article']['prodMargin'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  maxlength="8">
          </div>
      </div><br>
     
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Sub Familia <strong style="color: #dd4b39">*</strong>: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="sfamId"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                foreach ($data['subfamilys'] as $s) {
                  echo '<option value="'.$s['sfamId'].'" '.($data['article']['sfamId'] == $s['sfamId'] ? 'selected' : '').'>'.$s['sfamName'].'</option>';
                }
              ?>
            </select>
          </div>
      </div><br>
      <div class="row">
        <div class="col-xs-4">
            <label style="margin-top: 7px;">Estado: </label>
          </div>
        <div class="col-xs-5">
            <select class="form-control" id="prodStatus"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
              <?php 
                  echo '<option value="AC" '.($data['article']['prodStatus'] == 'AC' ? 'selected' : '').'>Activo</option>';
                  echo '<option value="IN" '.($data['article']['prodStatus'] == 'IN' ? 'selected' : '').'>InActivo</option>';
                  echo '<option value="SU" '.($data['article']['prodStatus'] == 'SU' ? 'selected' : '').'>Suspendido</option>';
              ?>
            </select>
          </div>
      </div>
    </div>


    <div class="tab-pane" id="tab_2"> <!-- Imagen del cliente -->
      <center>
      <div id='botonera'>
          <button id='botonIniciar' type="button" class="btn btn-success" onclick="ActiveCameraArt()"><i class="fa fa-play"></i></button>
          <button id='botonDetener' type="button" class="btn btn-danger" onclick="StopCameraArt()" disabled="disabled"><i class="fa fa-pause"></i></button>
      </div>
      <div class="contenedor">
          <h5>Cámara</h5>
          <video id="camara" autoplay controls></video>
      </div>
      <div class="contenedor">
          <h5>Fotos</h5>
          <canvas id="foto" style="display:none"></canvas>
          <input type="hidden" id="updatePicture1" value="0">
          <input type="hidden" id="updatePicture2" value="0">
          <input type="hidden" id="updatePicture3" value="0">
          <input type="hidden" id="updatePicture4" value="0">
      </div>
      <div class="row">
        <div class="col-xs-3">
          <button id='botonFoto1' type="button" class="btn btn-primary" disabled="disabled" style="margin-bottom: 5px;"><i class="fa fa-camera"></i></button>
          <img id="imgCamera1" class="imgCamera" src="<?php echo $data['article']['prodImg1'];?>">
        </div>
        <div class="col-xs-3">
          <button id='botonFoto2' type="button" class="btn btn-primary" disabled="disabled" style="margin-bottom: 5px;"><i class="fa fa-camera"></i></button>
          <img id="imgCamera2" class="imgCamera" src="<?php echo $data['article']['prodImg2'];?>">
        </div>
        <div class="col-xs-3">
          <button id='botonFoto3' type="button" class="btn btn-primary" disabled="disabled" style="margin-bottom: 5px;"><i class="fa fa-camera"></i></button>
          <img id="imgCamera3" class="imgCamera" src="<?php echo $data['article']['prodImg3'];?>">
        </div>
        <div class="col-xs-3">
          <button id='botonFoto4' type="button" class="btn btn-primary" disabled="disabled" style="margin-bottom: 5px;"><i class="fa fa-camera"></i></button>
          <img id="imgCamera4" class="imgCamera" src="<?php echo $data['article']['prodImg4'];?>">
        </div>
      </div>
      </center>
    </div>  


    <div class="tab-pane" id="tab_3"> <!-- Acerca del cliente -->
       
       
    </div>
  </div>
</div>