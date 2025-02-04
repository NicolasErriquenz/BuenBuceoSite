
  <div class="row">
    <div class="col">
      <h6 class="float-start"></h6>
      <div class="float-end">
        <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-hospedaje">
            AGREGAR HOSPEDAJE
        </button>
      </div>
    </div>
  </div>
  <?php  
    $bases = getHospedajeHabitacionesBases();
    $tipos = getHospedajeHabitacionesTipos();
  ?>
  <div class="nav-wrapper position-relative mb-3">
  <?php foreach ($viajesHospedajes as $item): 
    $tarifas = getHospedajeHabitacionesTarifas($item["hospedajesId"]);
    $isFirst = $item === reset($viajesHospedajes);
  ?>
    <div class="border rounded mb-3">
      <div class="d-flex align-items-center p-3 bg-gray-100" 
           data-bs-toggle="collapse" 
           data-bs-target="#collapse-<?php echo $item["viajesHospedajesId"] ?>"
           style="cursor: pointer">
        <h6 class="mb-0"><?php echo $item["hospedaje"] ?></h6>
        <i class="fas fa-chevron-down ms-auto"></i>
      </div>

      <div class="collapse <?php echo $isFirst ? 'show' : ''; ?>" 
           id="collapse-<?php echo $item["viajesHospedajesId"] ?>">
        <div class="p-3">
          <div class="row">
            <!-- Stats panel -->
            <div class="col-md-4 p-4">
              <h6 class="mb-4">Datos del Hospedaje</h6>
              <div class="stats-item mb-3">
               <div class="d-flex">
                 <div class="icon icon-shape bg-gradient-primary shadow text-center">
                   <i class="ni ni-building text-white"></i>
                 </div>
                 <div class="ms-3">
                   <p class="text-sm mb-0">Habitaciones</p>
                   <h5 class="font-weight-bold mb-0"><?php echo $item["habitaciones_creadas"] ?></h5>
                 </div>
               </div>
              </div>

              <div class="stats-item mb-3">
               <div class="d-flex">
                 <div class="icon icon-shape bg-gradient-success shadow text-center">
                   <i class="ni ni-single-02 text-white"></i>
                 </div>
                 <div class="ms-3">
                   <p class="text-sm mb-0">Viajeros</p>
                   <h5 class="font-weight-bold mb-0"><?php echo $item["usuarios_asignados"] ?></h5>
                 </div>
               </div>
              </div>

              <div class="stats-item mb-3">
               <div class="d-flex">
                 <div class="icon icon-shape bg-gradient-warning shadow text-center">
                   <i class="ni ni-chart-bar-32 text-white"></i>
                 </div>
                 <div class="ms-3">
                   <p class="text-sm mb-0">Capacidad Total</p>
                   <h5 class="font-weight-bold mb-0">
                     <?php echo $item["capacidad_total"] ?>
                     <span class="text-sm text-muted">(<?php
                       $porcentaje = $item["capacidad_total"] != 0 ? 
                         100 - ($item["capacidad_disponible"] * 100) / $item["capacidad_total"] : 0;
                       echo number_format($porcentaje, 0);
                     ?>%)</span>
                   </h5>
                 </div>
               </div>
              </div>

              <div class="stats-item mb-4">
               <div class="d-flex">
                 <div class="icon icon-shape bg-gradient-info shadow text-center">
                   <i class="ni ni-circle-08 text-white"></i>
                 </div>
                 <div class="ms-3">
                   <p class="text-sm mb-0">Camas Disponibles</p>
                   <h5 class="font-weight-bold mb-0"><?php echo $item["capacidad_disponible"] ?></h5>
                 </div>
               </div>
              </div>

              <div class="text-center">
               <a href="viajes_habitaciones_editar.php?viajesHospedajesId=<?php echo $item["viajesHospedajesId"] ?>" 
                  class="btn btn-sm btn-outline-primary">
                 <i class="ni ni-ungroup"></i> Distribución
               </a>
              </div>
            </div>

            <!-- Tarifas panel -->  
            <div class="col-md-8 p-4">
              <div class="bg-white rounded shadow-sm p-4">
                <h6 class="mb-3">Tarifas del Hospedaje</h6>
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th></th>
                        <?php foreach ($tipos as $tipo) { ?>
                          <th><?= $tipo['nombre'] ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($bases as $base) { ?>
                        <tr>
                          <th><?= $base['nombre'] ?></th>
                          <?php foreach ($tipos as $tipo) { ?>
                            <?php 
                              $tarifa = array_filter($tarifas, function($t) use ($base, $tipo) {
                                return $t['base'] == $base['nombre'] && $t['tipo'] == $tipo['nombre'];
                              });
                              $tarifa = reset($tarifa);
                            ?>
                            <td>
                              <div class='celda-clickeable' 
                                   data-hospedajesid='<?= $item['hospedajesId'] ?>' 
                                   data-base='<?= $base['baseHospedajeId'] ?>' 
                                   data-tipo='<?= $tipo['tipoHospedajeId'] ?>' 
                                   data-base-nombre='<?= $base['nombre'] ?>' 
                                   data-tipo-nombre='<?= $tipo['nombre'] ?>'>
                                <?php if (isset($tarifa['precio'])): ?>
                                  <div class="nombre"><?= $tarifa['alias'] ?></div>
                                  <div class="precio">$<?= $tarifa['precio'] ?></div>
                                <?php else: ?>
                                  <div class="nombre"></div>
                                  <div class="precio"></div>
                                <?php endif; ?>
                              </div>
                            </td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


  <div class="modal fade" id="modal-agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Valores de la tarifa - </h5>
        </div>
        <div class="modal-body">
          <form id="form-agregar">
            <div class="form-group">
              <label>Nombre:</label>
              <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Por ej. Estudio Single">
            </div>
            <div class="form-group">
              <label>Precio x persona:</label>
              <input type="number" id="precio" name="precio" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <div>
            <button onclick="javascript:eliminarTarifa();" class="btn btn-danger">Eliminar</button>
            <button onclick="javascript:guardarTarifa();" class="btn btn-primary ms-auto">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-hospedaje" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar hospedaje</h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:black">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-0">
          <div class="card card-plain">
            <div class="card-body">
              <form role="form text-left" method="post" action"" id="formNuevoViajero">
                <input type="hidden" value="agregarViajero" name="action">
                <div class="form-group">
                  <label for="hospedajesId" class="form-control-label">Hospedajes</label>
                  <select id="hospedajesId" name="hospedajesId" class="form-control">
                    <option value="" selected disabled>Elegí un hospedaje</option>
                      <?php foreach ($hospedajes as $item): ?>
                      <option value="<?php echo $item['hospedajesId']; ?>">
                        <?php echo $item['nombre']; ?>
                      </option>
                      <?php endforeach; ?>
                  </select>
                </div>
                <div class="row">
                  <div class="text-center alert alert-danger fade" id="error_div_hospedaje">
                    <span class="alert-icon"><i class="fa fa-warning"></i></span>
                    <span id="error-text-hospedaje"></span>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" onclick="javascript:altaViajeHospedaje()" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">GUARDAR</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<style>
.table-tarifas {
 font-size: 0.75rem;
}

.table-tarifas th, 
.table-tarifas td {
 padding: 0.5rem;
}

.celda-clickeable {
 height: 35px;
}

.celda-clickeable .nombre {
 font-size: 0.7rem;
 font-weight: 500;
}

.celda-clickeable .precio {
 font-size: 0.65rem;
 color: #67748e;
}

.table-tarifas thead th {
 background: #f8f9fa;
 font-weight: 600;
 color: #344767;
}

.table-tarifas tbody th {
 font-weight: 500;
 color: #344767;
}

.celda-clickeable {
  width: 100%;
  height: 40px; /* altura fija */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  box-sizing: border-box;
}

.celda-clickeable .nombre {
  font-weight: bold;
}

.celda-clickeable .precio {
  color: #666;
}

.celda-clickeable:hover {
  background-color: #e5e5e5;
}

.error {
  margin-top: 10px;
  padding: 5px 10px;
  border-radius: 5px;
  background-color: #f8d7da;
  color: #842029;
  font-size: 12px;
  text-align: center;
  display: flex;
  align-items: center;
  color:white;
  justify-content: center;
}

.error i {
  font-size: 16px;
  margin-right: 5px;

}
</style>

<script>
  


</script>