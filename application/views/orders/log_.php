  <div class="row">
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Orden N°: <strong style="font-size: 17px;"><?php echo str_pad($data['order']['ordId'], 8, "0", STR_PAD_LEFT);?></strong></span>
      </div>
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Fecha: <strong style="font-size: 17px;"><?php 
                                                                                    $date = date_create($data['order']['ordFecha']); 
                                                                                    echo date_format($date, 'd-m-Y H:i:s');?>
                                                                                </strong></span>
      </div>
    <div class="col-xs-4">
        <span style="margin-top: 7px;">Creada por: <strong style="font-size: 17px;"><?php echo $data['user'];?></strong></span>
      </div>
  </div>
  <hr>

<?php
  foreach ($data['log'] as $log) {
    ?>
    <div class="row">
      <div class="col-xs-3">
          <?php
          $date = date_create($log['logFecha']); 
          echo date_format($date, 'd-m-Y H:i:s');
          ?>
      </div>
      <div class="col-xs-3">
          <?php echo $log['usrNick'];?>
      </div>
      <div class="col-xs-3">
          <?php getEstado($log['ordEstadoActual']);?>
      </div>
      <div class="col-xs-3">
          <?php getEstado($log['ordEstadoAnterior']);?>
      </div>
    </div><br>
    <?php    
  }

  function getEstado($est){
    switch ($est)
    {
      case 'RC': 
                echo '<small class="label bg-green">Recibido</small>';
                break;

      case 'DS':
                echo '<small class="label bg-red">Descartado</small>';
                break;

      case 'PR':
                echo '<small class="label bg-blue">Producción</small>';
                break;

      case 'EP':
                echo '<small class="label bg-blue">Entrega Prod.</small>';
                break;

      case 'PA':
                echo '<small class="label bg-orange">Pausado</small>';
                break;

      case 'ED':
                echo '<small class="label bg-green">Editado</small>';
                break;

      case 'FN':
                echo '<small class="label bg-aqua">Finalizado</small>';
                break; 

      case 'CR':
                echo '<small class="label bg-gray">Cerrado</small>';
                break;      

      default: 
                echo '<small class="label bg-gray">'.$est.'</small>';
                break;
    }
  }
?>
<br>