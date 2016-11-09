<div class="row">
  <div class="col-xs-12">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="10%">Código</th>
          <th>Descripción</th>
          <th width="10%">Cantidad</th>
          <th width="20%">Fecha</th>
          <th width="10%">Usuario</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        foreach ($data['log'] as $a) {
          echo '<tr>';
          echo '<td style="text-align: right">'.$a['artId'].'</td>';
          echo '<td>'.$a['artDescripcion'].'</td>';
          echo '<td style="text-align: right">'.$a['ordEntCantidad'].'</td>';
          $date = date_create($a['ordEntFecha']); 
          echo '<td style="text-align: center">'.date_format($date, 'd-m-Y H:i:s').'</td>';
          echo '<td>'.$a['usrNick'].'</td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>