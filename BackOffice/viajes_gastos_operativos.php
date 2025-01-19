<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarAlquilerEquipo" ) {
    guardarAlquilerEquipo($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "getSubrubros" ) {
    echo getSubrubrosPagos(true, $_POST["pagosRubroId"], true);
    die();
  }

  $viaje = [];
  $viaje["activo"] = 1;
  
  $usuarios = [];
  $tipoViajeros = [];

  $title = "Editar viaje";
  $subtitle = "Podés editar la info del viaje";
  $action = "editar";

  $viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);
  $viajeros = getTodosViajesUsuarios($viaje[$idNombre]);
  $viajesHospedajes = getViajesHospedajes($viaje[$idNombre]);
  $redirect = "viajes.php";
  $paises = getPaises();

  $viajerosTipos = getViajesViajeroTipo();
  $paisNombre = getPais($viaje['paisId']);

  $equipos = getAlquilerEquipos();

  $tarifas = obtenerTarifasAlquilerEquipo($_GET[$idNombre]);

  //para precompletar los checkbox
  $equiposSeleccionados = obtenerEquiposSeleccionados($_GET[$idNombre]);

  $tieneTarifas = count($tarifas) != 0; 
  $subrubros = getSubrubrosPagos();
  $rubros = getRubrosPagos();

  $costos = getCostosOperativos($_GET[$idNombre]);

  // echo json_encode($viajeros);
  // die();
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
      <div id="status-tab" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background-color: white; color: #007bff; font-size: 0.9rem; font-weight: bold; padding: 5px 15px; border-radius: 10px; border: 2px solid #007bff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <!-- Contenido dinámico del tiempo restante -->
        <span id="time-remaining">Calculando...</span>
      </div>
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
                <?php echo $paisNombre ?>
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
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-end">
            <span id="badge-<?php echo $viaje[$idNombre]; ?>" class="badge habilitado-checkbox 
            <?php echo ($viaje["activo"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>" 
            style="font-size: 15px; padding: 10px 20px; border-radius: 10px;margin-right: 50px;">
              <?php echo ($viaje["activo"] == 1) ? 'ACTIVO' : 'FINALIZADO'; ?>
            </span>
          </div>
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
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0">Costos Operativos</h6>
                    </div>
                    <div class="col text-right">
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
                          foreach ($costos as $item): 
                        ?>
                        <tr>
                          <td>
                            <div class="">
                              <?php echo $item["viajesUsuariosId"] ?>
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
                          <td class="text-center">
                              <a href="pagos_editar.php?<?php echo $idNombre ?>=<?php echo $deuda[$idNombre] ?>"
                                 data-bs-toggle="tooltip" data-bs-placement="top" title="Pagar deuda" data-container="body" data-animation="true">
                                <button class="btn btn-icon btn-2 btn-sm btn-default mb-0 ajuste_boton" type="button">
                                  <span class="btn-inner--icon text-danger"><i class="fa fa-money"></i></span>
                                </button>
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
    </div>

    <?php include("includes/scripts.php") ?>

  </div>

    <div class="modal fade" id="modalCosto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Costo Operativo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCosto">
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

    <script>
        $(document).ready(function(){

            $('#btnGuardar').click(function() {
                // Crear FormData con los datos del formulario
                const formData = new FormData($('#formCosto')[0]);
                
                // Agregar action para el PHP
                formData.append('action', 'alta');
                
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
                            window.location.href = window.location.href + '?success=true';
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
    </script>

    <style>
    /* Restaurar estilos de paginación */
    .dataTables_paginate .paginate_button {
        padding: 0.5rem 0.75rem !important;
        margin-left: 2px !important;
        border: 1px solid #dee2e6 !important;
        background: white !important;
        border-radius: 0.25rem !important;
        color: #8898aa !important;
    }

    .dataTables_paginate .paginate_button:hover {
        background: #f6f9fc !important;
        color: #525f7f !important;
        border-color: #dee2e6 !important;
    }

    .dataTables_paginate .paginate_button.current {
        background: #5e72e4 !important;
        color: white !important;
        border-color: #5e72e4 !important;
    }

    .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Asegurar que los íconos de anterior/siguiente se vean correctamente */
    .dataTables_paginate .paginate_button.previous,
    .dataTables_paginate .paginate_button.next {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem !important;
    }
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