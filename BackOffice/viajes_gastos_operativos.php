<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarCosto") {
        $errores = [];
        
        // Validaciones básicas
        if (empty($_POST['viajesId'])) $errores[] = 'El viaje es requerido';
        if (empty($_POST['fecha'])) $errores[] = 'La fecha es requerida';
        if (empty($_POST['pagosRubroId'])) $errores[] = 'El rubro es requerido';
        if (empty($_POST['pagosSubrubroId'])) $errores[] = 'El subrubro es requerido';
        if (empty($_POST['descripcion'])) $errores[] = 'La descripción es requerida';
        if (!isset($_POST['monto'])) $errores[] = 'El monto es requerido';
        
        if (count($errores) > 0) {
            echo json_encode(['estado' => 'error_validacion', 'errores' => $errores]);
            die();
        }
        
        if($_POST["viajesCostosOperativosId"] != "")
            $result = editarCostoOperativo($_POST);
        else
            $result = altaCostoOperativo($_POST);

        if ($result) {
            echo json_encode(['estado' => 'ok']);
        } else {
            echo json_encode(['estado' => 'error', 'mensaje' => 'Error al guardar el costo operativo']);
        }
        die();
    }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarCosto" ) {
    echo eliminarCosto($_POST["viajesCostosOperativosId"]);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "getSubrubros" ) {
    echo getSubrubrosPagos(true, $_POST["pagosRubroId"], true);
    die();
  }

  $viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);

  $title = "Editar costos";
  $subtitle = "Podés editar la info de los costos operativos";
  $action = "editar";

  $redirect = "viajes_dashboard.php?viajesId=".$_GET["viajesId"];

  $paises = getPaises();
  $viajerosTipos = getViajesViajeroTipo();
  $paisNombre = getPais($viaje['paisId']);
  $tarifas = obtenerTarifasAlquilerEquipo($_GET[$idNombre]);

  $subrubros = getSubrubrosPagos();
  $rubros = getRubrosPagos();

  $costos = getCostosOperativos($_GET[$idNombre]);

  //eco($rubros);
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<?php include("includes/head.php"); ?>

<body class="g-sidenav-show   bg-gray-100">
  
  <?php echo $HEADER_IMAGEN ?>
  
  <?php include("includes/menu.php"); ?>

  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    
    <?php include("includes/navbar.php"); ?>
    
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <input type="hidden" name="<?php echo $idNombre ?>" id="<?php echo $idNombre ?>" value="<?php echo $usuario[$idNombre] ?? null ?>">
    <div class="card shadow-lg mx-4" style="margin-top: 1rem !important; opacity:1;">
      <div class="card-body p-3">

        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="_recursos/profile_pics/vuelo.jpg" alt="Perfil" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $viaje["nombre"] ?>
              </h5>
              <!-- Fechas del viaje -->
              <p class="text-muted mb-0" style="font-size: 0.85rem;">
                <i class="ni ni-calendar-grid-58 me-1"></i> 
                <?php echo date("d M Y", strtotime($viaje["fecha_inicio"])); ?> 
                - 
                <?php echo date("d M Y", strtotime($viaje["fecha_fin"])); ?>
              </p>
            </div>
          </div>
          <!-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-end">
            <span id="badge-<?php echo $viaje[$idNombre]; ?>" class="badge habilitado-checkbox 
            <?php echo ($viaje["activo"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>" 
            style="font-size: 15px; padding: 10px 20px; border-radius: 10px;margin-right: 50px;">
              <?php echo ($viaje["activo"] == 1) ? 'ACTIVO' : 'FINALIZADO'; ?>
            </span>
          </div> -->
        </div>
      </div>
    </div>


    <div class="container-fluid">

        <!-- Card colapsable para información numérica -->
        <div class="card mb-3 mt-4">
            <div class="card-header p-3" style="cursor: pointer" data-bs-toggle="collapse" data-bs-target="#infoNumerica">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0">Información del Viaje</h6>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
            </div>
            
            <div class="collapse" id="infoNumerica">
                <div class="card-body">
                    <!-- Tabla principal de datos -->
                    <div class="table-responsive mb-4">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Cantidad</th>
                                    <th>Hospedaje</th>
                                    <th>Equipos</th>
                                    <th>Costo Paquete</th>
                                    <th>% Ganancia</th>
                                    <th>Ganancia/Persona</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Buzos</th>
                                    <td>14</td>
                                    <td>$237,180.00</td>
                                    <td>$50,000.00</td>
                                    <td>$237,180.00</td>
                                    <td>50%</td>
                                    <td>$112,820.00</td>
                                </tr>
                                <tr>
                                    <th>Acompañantes</th>
                                    <td>4</td>
                                    <td>$127,180.00</td>
                                    <td>-</td>
                                    <td>$127,180.00</td>
                                    <td>50%</td>
                                    <td>$62,820.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card de Costos Operativos -->
        <div class="card">
           <div class="card-header border-0">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <h6 class="mb-0">Costos Operativos</h6>
                    </div>
                    <div class="col-auto">
                        <a href="<?php echo $redirect ?>" class="btn btn-default btn-sm me-2">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCosto">
                            <i class="fas fa-plus"></i> Nuevo Costo
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="custom-scroll-container">
                  <div class="table-responsive custom-pagination" style="margin: 0px !important;">
                    <table class="table mb-0 dataTable" id="tableDataTables">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subrubro</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Descripcion</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Monto</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pagado</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Porc.</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Liberado</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                        </tr>
                      </thead>
                        <tbody>
                            <?php foreach ($costos as $costo): 
                                $estado_pago = abs($costo['total_pagado']) >= abs($costo['monto']);
                                $porcentaje_pago = round(abs($costo['total_pagado']) / abs($costo['monto']) * 100, 2);
                            ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($costo['fecha'])) ?></td>
                                    <td><?php echo $costo['categoria'] ?></td>
                                    <td><?php echo $costo['descripcion'] ?></td>
                                    <td class="text-end">
                                        $<?php echo number_format(abs($costo['monto']), 2, ',', '.') ?>
                                    </td>
                                    <td class="text-end">
                                        $<?php echo number_format(abs($costo['total_pagado']), 2, ',', '.') ?>
                                    </td>
                                    <td class="text-end">
                                        <span class="<?php echo $porcentaje_pago == 100 ? 'text-success fw-bold' : ($porcentaje_pago > 100 ? 'text-warning' : '') ?>">
                                            <?php echo $porcentaje_pago ?>%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($costo['liberado']): ?>
                                            <span class="badge bg-success" style="font-size: 0.7rem;">Sí</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary" style="font-size: 0.7rem;">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?php echo $estado_pago ? 'bg-success' : ($costo['total_pagado'] > 0 ? 'bg-info' : 'bg-warning') ?>" 
                                                style="font-size: 0.7rem;">
                                            <?php echo $estado_pago ? 'Pagado' : ($costo['total_pagado'] > 0 ? 'Parcialmente pagado' : 'Pendiente') ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-link text-secondary px-1" 
                                                    onclick="editarCosto(<?php echo htmlspecialchars(json_encode($costo)) ?>)"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Editar costo operativo">
                                                <i class="fas fa-edit fa-xs"></i>
                                            </button>
                                            <button class="btn btn-link text-secondary px-1" 
                                                    onclick="eliminarCosto(<?php echo $costo['viajesCostosOperativosId'] ?>)"
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Eliminar costo operativo">
                                                <i class="fas fa-trash fa-xs"></i>
                                            </button>
                                            <?php if (!$estado_pago): ?>
                                                <button type="button"
                                                        class="btn btn-link text-secondary px-1"
                                                        onclick="verificarPagoCosto(<?php echo $costo['viajesCostosOperativosId'] ?>, <?php echo htmlspecialchars(json_encode($costo)) ?>)"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Registrar pago del costo">
                                                    <i class="fas fa-dollar-sign fa-xs"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                      <!-- <tfoot>
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
                      </tfoot> -->
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/scripts.php") ?>

  </div>

    <div class="modal fade" id="modalCosto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCostoTitle">Nuevo Costo Operativo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCosto">
                        <input type="hidden" id="viajesCostosOperativosId" name="viajesCostosOperativosId" value="">
                        <input type="hidden" id="action" name="action" value="guardarCosto">
                        <div class=" mb-3">
                            <label class="form-label">Viaje</label>
                            <input type="hidden" class="form-control" name="viajesId" id="viajesId" value="<?=$_GET[$idNombre]?>" >
                            <input type="text" class="form-control" name="nombreViaje" id="nombreViaje" value="<?php echo $paisNombre ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?=date("Y-m-d")?>">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Rubro</label>
                                <select id="pagosRubroId" name="pagosRubroId" class="form-control custom-select">
                                    <option value="" selected disabled>Seleccione un rubro</option>
                                    <?php foreach ($rubros as $rubro): ?>
                                    <option value="<?php echo $rubro['pagosRubroId']; ?>" 
                                            <?php echo (isset($subrubro['pagosRubrosId']) && $subrubro['pagosRubrosId'] == $rubro['pagosRubroId']) ? "selected" : ""; ?>>
                                    <?php echo $rubro['rubro']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Subrubro</label>
                                <select class="form-select" id="pagosSubrubroId" name="pagosSubrubroId" required>
                                    <option value="">Seleccione...</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" name="monto" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="liberado" id="checkLiberado">
                            <label class="form-check-label" for="checkLiberado">Es liberado (monto negativo)</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" style="font-size: 18px;">
            <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> Item creado correctamente!
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div class="modal fade" id="modalEliminarCosto" tabindex="-1" aria-labelledby="modalEliminarCostoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarCostoLabel">Eliminar Costo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="mensajeEliminarCosto"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarEliminarCosto">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCostoLiberado" tabindex="-1" aria-labelledby="modalCostoLiberadoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCostoLiberadoLabel">Costo Liberado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Este costo ha sido liberado y no puede registrarse un pago.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            document.getElementById("confirmarEliminarCosto").addEventListener("click", function () {
                var viajesCostosOperativosId = this.getAttribute("data-costo-id");
                // Cerrar el modal
                var modalEliminarCosto = bootstrap.Modal.getInstance(document.getElementById("modalEliminarCosto"));
                modalEliminarCosto.hide();
                $.ajax({
                    type: 'POST',
                    url: '', // URL actual
                    data: {
                        action: "eliminarCosto",
                        viajesCostosOperativosId: viajesCostosOperativosId,
                    },
                    dataType: 'json',
                    success: function (respuesta) {
                        if (respuesta.success) {
                            // Recarga la página con el parámetro success=true
                            window.location.href = window.location.href + '&success=true';
                        } else {
                            // Muestra el modal de error con el mensaje correspondiente
                            document.getElementById("mensajeEliminarCosto").textContent = respuesta.message;
                            var modalError = new bootstrap.Modal(document.getElementById("modalEliminarCosto"));
                            modalError.show();
                        }
                    },
                    error: function (xhr, status, error) {
                        // Muestra el modal de error con un mensaje genérico
                        document.getElementById("mensajeEliminarCosto").textContent = "Ha ocurrido un error al eliminar el costo.";
                        var modalError = new bootstrap.Modal(document.getElementById("modalEliminarCosto"));
                        modalError.show();
                    }
                });
            });

            $('#btnGuardar').click(function() {
                console.log("CLICK");
                // Crear FormData con los datos del formulario
                const formData = new FormData($('#formCosto')[0]);
                var viajesCostosOperativosId = document.getElementById("viajesCostosOperativosId").value;

                
                // Si está marcado como liberado, hacer el monto negativo
                if($('#checkLiberado').is(':checked')) {
                    const montoActual = parseFloat(formData.get('monto'));
                    if(montoActual > 0) {
                        formData.set('monto', -montoActual);
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: '', // URL actual
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(respuesta) {
                        if(respuesta.estado === "ok") {
                            // Recargar la página o redirigir
                            window.location.href = window.location.href + '&success=true';
                        } else if(respuesta.estado === "error") {
                            // Error específico
                            $('#modal-campos .modal-body').html(
                                '<ul id="ul_errores"><li>' + respuesta.mensaje + '</li></ul>'
                            );
                            $('#modal-campos').modal('show');
                        } else if(respuesta.estado === "error_validacion") {
                            // Múltiples errores de validación
                            let erroresHtml = '<ul id="ul_errores">';
                            respuesta.errores.forEach(function(error) {
                                erroresHtml += '<li>' + error + '</li>';
                            });
                            erroresHtml += '</ul>';
                            
                            $('#modal-campos .modal-body').html(erroresHtml);
                            $('#modal-campos').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#modal-campos .modal-body').html(
                            '<ul id="ul_errores"><li>Error al procesar la solicitud</li></ul>'
                        );
                        $('#modal-campos').modal('show');
                    }
                });
            });
                    
            $('#pagosRubroId').change(function() {
                var pagosRubroId = $(this).val();
                
                $.ajax({
                    type: 'POST',
                    url: '',
                    dataType: 'json',
                    data: {
                    pagosRubroId: pagosRubroId, 
                    action: 'getSubrubros'
                    },
                    success: function(response) {
                        $('#pagosSubrubroId').empty();
                        $.each(response, function(index, value) {
                            $('#pagosSubrubroId').append('<option value="' + value.pagosSubrubroId + '">' + value.subrubro + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar:', error);
                    }
                });
            });

            <?php if(isset($_GET["success"]) && $_GET["success"]  == "true"): ?>
                crearToast();
            <?php endif ?>
        });

        function crearToast(){
            const toast = new bootstrap.Toast(document.getElementById('toast'), {
                animation: true,
                autohide: true,
                delay: 2000,
            });

            // Muestra el toast
            toast.show();
        }

        function eliminarCosto(costoId) {

            // Guardar el ID del costo en un atributo de datos del botón de confirmación
            document.getElementById("confirmarEliminarCosto").setAttribute("data-costo-id", costoId);

            mensaje = "¿Estás seguro de que deseas eliminar este costo? Esta acción no se puede deshacer.";
            document.getElementById("mensajeEliminarCosto").textContent = mensaje;
            document.getElementById("confirmarEliminarCosto").style.display = "inline-block";
            var modalEliminarCosto = new bootstrap.Modal(document.getElementById("modalEliminarCosto"));
            modalEliminarCosto.show();
        }

         // Pasar los rubros y subrubros como objetos JavaScript
        const rubros = <?php echo json_encode($rubros); ?>;
        const subrubros = <?php echo json_encode($subrubros); ?>;

        function buscarRubroId(pagosSubrubroId) {
            // Buscar el subrubro que coincide con el pagosSubrubroId
            const subrubro = subrubros.find(sub => sub.pagosSubrubroId == pagosSubrubroId);

            // Buscar el rubro que coincide con el pagosRubrosId del subrubro
            const rubro = rubros.find(r => r.pagosRubroId == subrubro.pagosRubrosId);

            // Retornar el pagosRubroId del rubro
            const rubroSelect = document.getElementById("pagosRubroId");
            rubroSelect.value = rubro.pagosRubroId;

            // Obtener el elemento select de subrubros
            const subrubroSelect = document.getElementById("pagosSubrubroId");

            // Limpiar opciones previas
            subrubroSelect.innerHTML = '';

            // Filtrar los subrubros correspondientes al rubroId
            const subrubrosFiltrados = subrubros.filter(subrubro => subrubro.pagosRubrosId == rubro.pagosRubroId);

            subrubrosFiltrados.forEach(subrubro => {
                const option = document.createElement('option');
                option.value = subrubro.pagosSubrubroId;
                option.textContent = subrubro.subrubro;
                subrubroSelect.appendChild(option);
            });

            // Establecer el valor seleccionado en el select de subrubros
            subrubroSelect.value = pagosSubrubroId;
            console.log(subrubroSelect.value );
        }

        function editarCosto(costo) {
            buscarRubroId(costo.pagosSubrubroId);

            // Resto de los campos del formulario
            document.getElementById("viajesCostosOperativosId").value = costo.viajesCostosOperativosId;
            document.getElementById("viajesId").value = costo.viajesId;
            document.querySelector("input[name='fecha']").value = costo.fecha;
            document.querySelector("input[name='descripcion']").value = costo.descripcion;
            document.querySelector("input[name='monto']").value = Math.abs(costo.monto);
            document.getElementById("checkLiberado").checked = costo.liberado;
            document.getElementById("modalCostoTitle").textContent = "Editar Costo Operativo";
            $("#modalCosto").modal("show");
        }

        function verificarPagoCosto(costoId, costoData) {
            // Verificamos si el costo es liberado
            if (costoData.liberado === true || costoData.liberado === 1) {
                // Si es liberado, mostramos el modal
                const modalCostoLiberado = new bootstrap.Modal(document.getElementById('modalCostoLiberado'));
                modalCostoLiberado.show();
            } else {
                // Si no es liberado, redirigimos a la página de pago
                window.location.href = `pagos_editar.php?viajesId=${costoData.viajesId}&viajesCostosOperativosId=${costoId}`;
            }
        }
    </script>

    <style>
    /* Restaurar estilos de paginación */


    .table-bordered tbody tr:last-child td {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .table-bordered td,
    .table-bordered th {
        border-right: 1px solid #dee2e6 !important;
        border-left: 1px solid #dee2e6 !important;
    }

    .table-bordered tbody tr td:last-child {
        border-right: 1px solid #dee2e6 !important;
    }
    /* Estilos personalizados para los switches */
    .form-switch {
        padding-left: 0; /* Elimina el padding predeterminado */
    }

    .form-switch .form-check-input {
        margin: 0 !important; /* Elimina márgenes */
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .form-switch .form-check-input:checked {
        background-color:rgb(30, 113, 223);
        border-color: rgb(30, 113, 223);
    }

    .form-switch .form-check-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Efecto hover */
    .form-switch .form-check-input:not(:disabled):hover {
        cursor: pointer;
        box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
    }

    /* Asegura que el contenedor tenga altura completa */
    .table td {
        vertical-align: middle;
    }
    </style>
</body>

</html>