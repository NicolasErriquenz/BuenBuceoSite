
<?php 
foreach ($costosHospedajes['hospedajes'] as $hospedaje): ?>
<div class="container-fluid">
  <div class="card mb-2">
    <div class="card-header bg-gradient-secondary text-white d-flex justify-content-between align-items-center py-2 shadow-sm">
      <h5 class="mb-0"><?php echo $hospedaje['nombre']; ?></h5>
      <div class="hotel-details">
        <small>
          <i class="fas fa-star text-warning"></i> <?php echo $hospedaje['estrellas']; ?> 
          | <i class="fas fa-map-marker-alt text-white-50"></i> <?php echo $hospedaje['direccion']; ?>
        </small>
      </div>
    </div>

    <div class="card-body">
      <div class="row g-4">
        <?php 
          if(!isset($hospedaje['tarifas']))
            echo "<p>No hay tarifas cargadas aún.</p>";
          else
            foreach ($hospedaje['tarifas'] as $tarifa): 
              $totalDoubledBeds = array_sum(array_column($tarifa['habitaciones'], 'camas_dobles'));
              $totalSingleBeds = array_sum(array_column($tarifa['habitaciones'], 'camas_simples'));
              
              $usuarios = [];
              foreach ($tarifa['habitaciones'] as $habitacion) {
                foreach ($habitacion['usuarios'] as $usuario) {
                  $usuarios[] = $usuario;
                }
              }
              $totalUsers = count($usuarios);
              
              $totalCost = number_format(rand(5000, 15000), 2);
          ?>
          <div class="col-4">
            <div class="card h-100 border-light shadow-sm rounded-3">
              <div class="card-header border-bottom-1 d-flex justify-content-between align-items-center py-2 px-3">
                <div>
                  <h6 class="mb-0 text-muted"><?php echo $tarifa['alias']; ?></h6>
                  <small class="text-muted d-block" style="font-size: 0.6rem; line-height: 1;">
                    <?php 
                    $checkin = !empty($tarifa["fecha_checkin"]) ? date('d/m/Y', strtotime($tarifa["fecha_checkin"])) : 'N/A';
                    $checkout = !empty($tarifa["fecha_checkout"]) ? date('d/m/Y', strtotime($tarifa["fecha_checkout"])) : 'N/A';
                    echo " $checkin | $checkout";
                    ?>
                  </small>
                </div>
                <span class="badge bg-light text-secondary border"><?php echo count($tarifa['habitaciones']); ?> Habit.</span>
              </div>
              <div class="card-body pt-3 pb-2 px-3">
                <div class="mb-3">
                  <div class="d-flex justify-content-between mb-1">
                    <small class="text-muted">Noches:</small>
                    <small class="text-bold"><?php echo $tarifa["noches"]; ?></small>
                  </div>
                  <div class="d-flex justify-content-between mb-1">
                    <small class="text-muted">Camas Dobles:</small>
                    <small class="text-secondary"><?php echo $totalDoubledBeds; ?></small>
                  </div>
                  <div class="d-flex justify-content-between">
                    <small class="text-muted">Camas Simples:</small>
                    <small class="text-secondary"><?php echo $totalSingleBeds; ?></small>
                  </div>
                </div>
                
                <div class="d-flex justify-content-between">
                  <?php if ($tarifa['precio'] > 0): ?>
                    <button class="btn btn-outline-secondary btn-sm" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#costos-<?php echo $tarifa['hospedajeTarifaId']; ?>"
                            onclick="closeOtherCollapses(this)">
                      Costo: $<?php echo $tarifa['precio']; ?>
                    </button>
                  <?php else: ?>
                    <button class="btn btn-outline-secondary btn-sm disabled" disabled>
                      Costo: $0
                    </button>
                  <?php endif; ?>
                  
                  <?php if ($totalUsers > 0): ?>
                    <button class="btn btn-outline-secondary btn-sm" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#usuarios-<?php echo $tarifa['hospedajeTarifaId']; ?>"
                            onclick="closeOtherCollapses(this)">
                      Usuarios: <?php echo $totalUsers; ?>
                    </button>
                  <?php else: ?>
                    <button class="btn btn-outline-secondary btn-sm disabled" disabled>
                      Usuarios: 0
                    </button>
                  <?php endif; ?>
                </div>

                <div id="costos-<?php echo $tarifa['hospedajeTarifaId']; ?>" class="collapse mt-2">
                  <table class="table table-sm table-borderless mb-0 fs-7">
                    <thead>
                      <tr class="border-bottom">
                        <th class="text-muted p-1 text-start">Categoría</th>
                        <th class="text-muted p-1 text-start">Alcance</th>
                        <th class="text-muted p-1 text-end">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                      $totalBuzos = $tarifa['precio'];
                      $totalAcompanantes = $tarifa['precio'];
                      // Display grouped costs
                      foreach ($groupedCosts as $group):

                        if($group['soloBuzos'] == '1'){
                          $badge = '<span class="badge bg-info text-white">Buzos</span>';
                        }else{
                          $badge = '<span class="badge bg-secondary text-white">Todos</span>';
                          $totalAcompanantes += $group['total'];
                        }
                        $totalBuzos += $group['total'];
                      ?>
                        <tr>
                          <td class="py-1"><?php echo $group['subrubro']; ?></td>
                          <td class="py-1"><?php echo $badge?></td>
                          <td class="py-1 text-end">
                            <b><?php echo $group['simbolo'] . number_format($group['total'], 2); ?></b>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <div id="usuarios-<?php echo $tarifa['hospedajeTarifaId']; ?>" class="collapse mt-2">
                  <table class="table table-sm table-borderless mb-0 fs-7">
                    <thead>
                      <tr class="border-bottom">
                        <th class="text-muted p-1 text-start">Viajeros</th>
                        <th class="text-muted p-1 text-start">Cama</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($usuarios as $usuario): ?>
                        <tr>
 <td class="py-1 w-100">
   <div class="d-flex align-items-center">
     <?php 
     $badgeColor = match($usuario['viajeroTipoId']) {
       '3' => 'bg-secondary',
       default => 'bg-info'  
     };
     ?>
     <span class="me-2 rounded-circle <?php echo $badgeColor; ?>" 
           style="width: 10px; height: 10px; display: inline-block;"
           data-bs-toggle="tooltip" data-bs-placement="top"
           title="<?php echo $usuario['viajero_tipo']; ?>"></span>
     <span class="text-truncate flex-grow-1" 
          data-bs-toggle="tooltip" 
          data-bs-placement="top" 
          title="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>">
        <?php echo htmlspecialchars($usuario['apodo']); ?>
     </span>
   </div>
 </td>
 <td class="py-1 text-end" style="white-space: nowrap;">
   <?php 
   if ($usuario['cama_doble'] == '1') echo '<span class="badge bg-light text-secondary border">Doble</span>'; 
   if ($usuario['cama_simple'] == '1') echo '<span class="badge bg-light text-secondary border">Simple</span>'; 
   ?>
 </td>
</tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer border-top-1 d-flex flex-column align-items-stretch py-2 px-3">
                <!-- First div for total hoodies cost -->
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Costo p/Buzo:</small>
                    <small class="text-secondary">$<?php echo $totalBuzos; ?></small>
                </div>
                
                <!-- Second div for total companions/accompaniers cost -->
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Costo p/Acompañante:</small>
                    <small class="text-secondary">$<?php echo $totalAcompanantes; ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>
<?php endforeach; ?>

<script type="text/javascript">
  function closeOtherCollapses(currentButton) {
    // Find all collapse elements in the page
    var collapseElements = document.querySelectorAll('.collapse');
    
    collapseElements.forEach(function(element) {
      // Close the element if it's not the one being opened and is currently open
      if (element.id !== currentButton.getAttribute('data-bs-target').replace('#', '') && 
          element.classList.contains('show')) {
        var bsCollapse = new bootstrap.Collapse(element);
        bsCollapse.hide();
      }
    });
  }
</script>




