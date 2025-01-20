    <div class="row">
      <div class="col">
        <h6 class="float-start"></h6>
        <div class="float-end">
          <button class="btn btn-sm btn-icon bg-gradient-primary float-end" onclick="javascript:altaViajero();">
              <i class="ni ni-fat-add"></i> AGREGAR VIAJERO
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Viajero</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">c/Hab</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Venta Paq.</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deudas</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pagos</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pendiente</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habilitado</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $totalVentaPaquetes = 0;
                  foreach ($viajeros as $item): 
                    $pendienteViajero = $item["total_deuda"] - $item["pagos_realizado"];
                    $totalVentaPaquetes += $item["venta_paquete"];
                ?>
                <tr>
                  <td>
                    <div class="">
                      <?php echo $item["viajesUsuariosId"] ?>
                    </div>
                  </td>
                  <td>
                    <div style="display: flex; align-items: center;">
                      <div class="imagen-circular" style="background-image: url('_recursos/profile_pics/<?php 
                        echo !empty($item["usuario"]['imagen']) ? $item["usuario"]['imagen'] : 'generic_user.png'; 
                      ?>')"></div>
                      <a href="usuarios_editar.php?usuarioId=<?php echo $item["usuario"]["usuarioId"] ?>">
                        <p class="text-sm mb-0" style="margin-left: 10px;">
                            <?php 
                                echo (empty($item["usuario"]["apodo"]) ? $item["usuario"]["nombre"] : $item["usuario"]["apodo"]) . 
                                " (" . $item["usuario"]["nombre"] . " " . $item["usuario"]["apellido"] . ")";
                            ?>
                        </p>
                      </a>
                    </div>
                  </td>                  
                  <td class="text-center">
                    <span class="text-secondary text-xs ">
                      <?php echo $item["viajeroTipo"]["viajero_tipo"] ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <?php echo $item["habitaciones_asignadas"] ?>
                  </td>
                  <td class="text-center">
                    <?php echo isset($item["venta_paquete"]) ? "USD ".number_format($item["venta_paquete"], 2) : "-" ?>
                  </td>
                  <td class="text-center font-weight-bold ">
                    <a href="deudas.php?usuarioId=<?php echo $item["usuario"]["usuarioId"] ?>">
                      $<?php echo number_format($item["total_deuda"] ?? 0, 2, ',', '.') ?>
                    </a>
                  </td>
                  <td class="text-center">
                    <?php echo number_format($item["pagos_realizado"] ?? 0, 2, ',', '.') ?>
                  </td>
                  <td class="text-center">
                      <span class="<?php echo ($pendienteViajero == 0) ? 'text-info' : 'text-danger'; ?> fw-bold">
                          $<?php echo number_format($pendienteViajero, 2, ',', '.') ?>
                      </span>
                  </td>
                  <td class="text-center">
                    <span id="badge-<?php echo $item["viajesUsuariosId"]; ?>" class="badge badge-sm habilitado-checkbox 
                        <?php echo ($item["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                        <?php echo ($item["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                    </span>
                  </td>
                  <td class="align-middle text-center">
                    <a href="javascript:editarViajero(<?php echo $item["viajesUsuariosId"] ?>, <?php echo $item["viajeroTipo"]["viajeroTipoId"] ?>, '<?php echo $item["venta_paquete"] ?>', '<?php echo $item["usuario"]["nombre"] ?> <?php echo $item["usuario"]["apellido"] ?> (<?php echo $item["usuario"]["apodo"] ?>)')" class="btn btn-icon btn-xs btn-secondary mb-0">
                        <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                    </a>
                    <a href="javascript:confirmarEliminarViajero(<?php echo $item["usuario"]["usuarioId"] ?>)" class="btn btn-icon btn-xs btn-danger mb-0">
                        <span class="btn-inner--icon"><i class="fa fa-times"></i></span>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                  <tr>
                      <td colspan="4" class="text-end fw-bold">Totales:</td>
                      <td class="text-center">$<?php echo number_format($totalVentaPaquetes, 2, ',', '.') ?></td>
                      <td class="text-center">$<?php echo number_format($totalDeudaViaje, 2, ',', '.') ?></td>
                      <td class="text-center">$<?php echo number_format($totalCobrado, 2, ',', '.') ?></td>
                      <td class="text-center">
                          <span class="<?php echo ($totalPendiente == 0) ? 'text-info' : 'text-danger'; ?> fw-bold">
                              $<?php echo number_format($totalPendiente, 2, ',', '.') ?>
                          </span>
                      </td>
                      <td colspan="2"></td>
                  </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>

<div class="modal fade" id="modal-form-viajeros" tabindex="-1" role="dialog" aria-labelledby="modal-form-viajeros" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_editar_viajero">Agregar viajero</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:black">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-body">
            <form role="form text-left" method="post" action"" id="formNuevoViajero">
              <input type="hidden" value="agregarViajero" name="action">
              <input type="hidden" name="viajesUsuariosId" id="viajesUsuariosId">
              <div class="form-group mb-0">
                <label class="form-control-label">Usuario</label>
                <div class="row">
                  <div class="col-md-9">
                    <input type="hidden" name="usuarioId">
                    <input autocomplete="off" 
                          type="text" 
                          id="buscar" 
                          name="buscar" 
                          class="form-control" 
                          value=""
                          placeholder="Ingrese al menos 1 caracter">
                  </div>
                  <div class="col-md-3">
                    <button id="deseleccionar" 
                            class="btn btn-outline-secondary w-100" 
                            <?php echo !isset($usuario["usuarioId"]) ? "disabled" : ''; ?>>
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div id="resultado" class="dropdown-menu dropdown-menu-left"></div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group ">
                    <label for="viajeroTipoId" class="form-control-label">Tipo</label>
                    <select id="viajeroTipoId" name="viajeroTipoId" class="form-control">
                      <option value="" selected disabled>Elegí un tipo de viajero</option>
                        <?php foreach ($viajerosTipos as $item): ?>
                        <option value="<?php echo $item['viajeroTipoId']; ?>">
                          <?php echo $item['viajero_tipo']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="form-control-label">Costo del paquete (U$S)</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                      <input type="number" step="any" 
                            id="venta_paquete" name="venta_paquete" 
                            placeholder="00.00"
                            value="" 
                            class="form-control" style="text-align: right;">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="text-center alert alert-danger fade" id="error_div">
                  <span class="alert-icon"><i class="fa fa-warning"></i></span>
                  <span id="error-text"></span>
                </div>
              </div>
              <div class="text-center">
                <button type="button" onclick="javascript:validarFormNuevoViajero()" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">GUARDAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_eliminar_viajero" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <i class="fa fa-warning text-warning"></i>&nbsp;
        <h6 class="modal-title" id="modal-title-default">Atención</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          Estás seguro que querés eliminar el viajero? Esta acción no puede deshacerse.
          Se eliminarán los costos asociados, habitaciones, etc...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary ml-auto" data-bs-dismiss="modal">CANCELAR</button>
        <button type="button" 
                class="btn bg-gradient-primary ml-auto" 
                onclick="javascript:eliminarViajero()"
                data-bs-dismiss="modal" >ENTENDIDO</button>
      </div>
    </div>
  </div>
</div>

