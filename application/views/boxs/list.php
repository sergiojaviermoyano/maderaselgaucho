<input type="hidden" id="permission" value="<?php echo $permission; ?>">
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Facturación</h3>
          <?php
            if (strpos($permission,'Add') !== false) {
              echo '<button class="btn btn-block btn-success" style="width: 100px; margin-top: 10px;" data-toggle="modal" onclick="LoadWood(0,\'Add\')" id="btnAdd">Agregar</button>';
            }
          ?>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-xs-4">
                <label style="margin-top: 7px;">Cliente <strong style="color: #dd4b39">*</strong>: </label>
              </div>
            <div class="col-xs-5">
              <select class="form-control select2" id="cliId" style="width: 100%;" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
                <?php 
                  echo '<option value="-1" selected></option>';
                  foreach ($list as $c) {
                    echo '<option value="'.$c['cliId'].'" data-balance="'.$c['cliTipo'].'">'.$c['cliTipo'].'-'.$c['cliApellido'].', '.$c['cliNombre'].' ('.$c['cliDocumento'].')</option>'; //data-balance="'.$c['balance'].'" data-address="'.$c['cliAddress'].'" data-dni="'.$c['cliDni'].'"
                  }
                ?>
              </select>
              </div>
          </div>
          <br>
          <div class="row">
            <div class="col-xs-12">
              <div class="box-header">
              <h4 class="box-title">Estado de Cuenta Corriente</h4>
              </div>
              <div id="ctacteBody">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
$(".select2").select2();

$("#cliId").change(function(){
  WaitingOpen('Cargando Cuenta Corriente...');
      $.ajax({
            type: 'POST',
            data: { 
                    cliId : $("#cliId").val(), 
                    type: $(this).find(':selected').data('balance')
                  },
        url: 'index.php/box/getCtaCte', 
        success: function(result){
                      WaitingClose();
                      $("#ctacteBody").html(result.html);
                      //$(".select2").select2();
                      //setTimeout("$('#modalReception').modal('show')",800);
              },
        error: function(result){
              WaitingClose();
              alert("error");
            },
            dataType: 'json'
        });
});

var remitosParaFacturar = [];
function selectRem(remId, puntero){
  
  if($(puntero).hasClass( 'fa-circle-o text-red' )){
    $(puntero).removeClass('fa-circle-o text-red');
    $(puntero).addClass('fa-check-circle text-green');
    remitosParaFacturar.push(remId);
  } else {
    $(puntero).removeClass('fa-check-circle text-green');
    $(puntero).addClass('fa-circle-o text-red');
    var index = remitosParaFacturar.indexOf(remId);
    remitosParaFacturar.splice(index,1);
  }

  if(remitosParaFacturar.length > 0){
    $('#btnFacturar').removeClass('disabled');
  } else {
    $('#btnFacturar').addClass('disabled');
  }
}

$('#btnFacturar').click(function(){
  alert('facturando');
});
</script>