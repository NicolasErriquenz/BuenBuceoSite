
  <div class="row">
    <div class="col">
      <h6 class="float-start"></h6>
      <div class="float-end">
        <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-hospedaje">
            <i class="ni ni-fat-add"></i> AGREGAR HOSPEDAJE
        </button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="custom-scroll-container">
        <div class="table-responsive custom-pagination" style="margin: 0px !important;">
          <table class="table mb-0 dataTable" id="tableDataTables">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tarifas</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habitaciones</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Viajeros</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Capacidad Tot.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Camas disp.</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($viajesHospedajes as $item): ?>
              <tr>
                <td>
                  <div class="">
                    <?php echo $item["viajesHospedajesId"] ?>
                  </div>
                </td>
                <td>
                  <p class="text-sm  mb-0"><?php echo $item["hospedaje"] ?></p>
                </td>
                <td class="text-center">
                  <a href="hospedajes_tarifas.php?hospedajesId=<?php echo $item["hospedajesId"] ?>">
                    <p class="text-sm font-weight-bold mb-0"><?php echo $item["tarifas_cargadas"] ?></p>
                  </a>
                </td>
                <td class="text-center">
                  <p class="text-sm  mb-0"><?php echo $item["habitaciones_creadas"] ?></p>
                </td>
                <td class="text-center">
                  <p class="text-sm  mb-0"><?php echo $item["usuarios_asignados"] ?></p>
                </td>
                <td class="text-center">
                  <p class="text-sm  mb-0">
                    <?php echo $item["capacidad_total"] ?>
                    (<?php 
                        if($item["capacidad_total"] != 0)
                          $porcentaje = 100 - ($item["capacidad_disponible"] * 100 ) / $item["capacidad_total"];
                        else
                          $porcentaje = 0;
                        echo number_format($porcentaje, 0) . "%";
                    ?>)
                  </p>
                </td>
                <td class="text-center">
                  <p class="text-sm  mb-0"><?php echo $item["capacidad_disponible"] ?></p>
                </td>
                <td class="align-middle text-center">
                  <a href="viajes_habitaciones_editar.php?viajesHospedajesId=<?php echo $item["viajesHospedajesId"] ?>">
                    <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                      <span class="btn-inner--icon"><i class="ni ni-ungroup"></i> Distribución</span>
                    </button>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
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