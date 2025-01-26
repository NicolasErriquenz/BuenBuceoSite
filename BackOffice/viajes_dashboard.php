<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarTarifa" ) {
    echo guardarHospedajeHabitacionesTarifas($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarTarifa" ) {
    echo eliminarHospedajeHabitacionesTarifas($_POST);
    die();
  }
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "aplicarViajeCostoaTodosViajeros" ) {
    echo aplicarViajeCostoaTodosViajeros($_POST["viajeCostoId"]);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarViajeCostos" ) {
    echo eliminarViajeCostos($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajeCosto" ) {
    echo altaViajeCostos($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editarViajeCosto" ) {
    echo editarViajeCosto($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == "buscar" ) {
    echo buscarUsuarios($_GET["q"]);
    die();
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajero" ) {
    echo altaViajero($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editarViajero" ) {
    echo editarViajero($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarViajero" ) {
    echo eliminarViajero($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajeHospedaje" ) {
    
    echo altaViajeHospedaje($_POST);
    die();
  }
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateActivo($_POST["id"], $_POST["activo"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
    // Validación de campos
    if (empty($_POST['nombre']))  $errores[] = 'Nombre es requerido';
    // if (empty($_POST['apellido']))  $errores[] = 'Apellido es requerido';
    if (empty($_POST['email']))  $errores[] = 'Email es requerido';
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  $errores[] = 'Email inválido';
    // if (empty($_POST['dni']))  $errores[] = 'DNI es requerido';
    // if (!is_numeric($_POST['dni']))  $errores[] = 'DNI debe ser un número';
    // if (empty($_POST['fecha_nacimiento']))  $errores[] = 'Fecha de nacimiento es requerido';
    
    // Validación de formato
    // if (!empty($_POST['paisId']) && !is_numeric($_POST['paisId']))  $errores[] = 'País Id debe ser un número';
    // if (!empty($_POST['sexoId']) && !is_numeric($_POST['sexoId']))  $errores[] = 'Sexo Id debe ser un número';
    // if (!empty($_POST['habilitado_sys']) && !is_numeric($_POST['habilitado_sys']))  $errores[] = 'Habilitado sys debe ser un número';

    if (count($errores) > 0) {
      $respuesta = array('estado' => 'error_validacion', 'errores' => $errores);
    } else {
      $respuesta = array('estado' => 'ok');
    }
    
    if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
      echo json_encode($respuesta);
    else{

      if(isset($_POST["usuarioId"]) && !empty($_POST["usuarioId"]))
        echo editarUsuario($_POST);
      else
        echo altaUsuario($_POST);
    }

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

  $subrubros = getSubrubrosPagos(true, pagosRubrosId: 2);

  $costos = getCostos($_GET[$idNombre]);

  $groupedCosts = [];
  foreach ($costos as $costo) {
    $subrubroId = $costo['pagosSubrubroId'];
    if (!isset($groupedCosts[$subrubroId])) {
      $groupedCosts[$subrubroId] = [
        'subrubro' => $costo['subrubro'],
        'soloBuzos' => $costo['soloBuzos'],
        'total' => 0,
        'simbolo' => $costo['simbolo']
      ];
    }
    $groupedCosts[$subrubroId]['total'] += floatval($costo['monto']);
  }
    
  $viajerosTipos = getViajesViajeroTipo();
  $monedas = getMonedas();
  $paisNombre = getPais($viaje['paisId']);

  $hospedajes = getHospedajes();

  $seccion = isset($_GET["seccion"]) ? $_GET["seccion"] : "costos";
  $sub_seccion = isset($_GET["sub_seccion"]) ? $_GET["sub_seccion"] : "costos_totales";

  $estadisticasCostosTotales = getDetalleCostosTotalesPorViaje($_GET[$idNombre]);
  $costosTotalesSumados = array_sum(array_column($estadisticasCostosTotales, 'monto_total'));

  $costosHospedajes = getDetallesCostosHospedajes($_GET[$idNombre]);

  $costoTotalHabitaciones = getCostoTotalHabitaciones($costosHospedajes);
  $costoTotalViaje = $costoTotalHabitaciones + $costosTotalesSumados;

  $deudasViaje = getDeudasViaje($_GET[$idNombre]);
  $totalDeudaViaje = array_sum(array_column($deudasViaje, 'deuda'));
  
  $cobrosRealizados  = getPagosViaje($_GET[$idNombre]);
  $totalCobrado = array_sum(array_column($cobrosRealizados, 'monto'));

  $totalPendiente = $totalDeudaViaje - $totalCobrado;
  $costosOperativos = getCostosOperativos($_GET[$idNombre]);
  $totalCostosOperativos = array_sum(array_column($costosOperativos, 'monto'));;

  $costoPromedioPersona = count($viajeros) == 0 ? 0 : number_format($costoTotalViaje/count($viajeros), 2, ',', '.');
  $porcentajeCobradoDelTotal = $totalDeudaViaje == 0 ? 0 : number_format(($totalCobrado/$totalDeudaViaje)*100, 1);
  $costosOperativosPorcentaje = $totalDeudaViaje == 0 ? 0 : number_format(($totalCostosOperativos/$totalDeudaViaje)*100, 1);

  $param = array();
  $param["viajesId"] = $_GET[$idNombre];
  $costosAlquileres = obtenerIngresosAlquileres($param);
  
  $totalDeudaViaje = array_sum(array_column($deudasViaje, 'deuda'));
  $totalIngresos = $costosAlquileres["ganancia"] + $totalDeudaViaje;
  $totalCostos = $totalCostosOperativos;
  $margenGanancia = $totalIngresos - $totalCostos;
  $porcentajeMargen = number_format(($margenGanancia / $totalIngresos) * 100, 1);

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
    <div class="card shadow-lg mx-4" style="margin-top: 1rem !important;">
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


    <div class="container-fluid py-4">

      
    <div class="row g-3 mb-3">
      <!-- Costo Total -->
      <div class="col">
          <div class="card border-0 border-top border-primary border-5">
              <div class="py-2 px-3 card-body d-flex align-items-center">
                  <div class="me-3 icon-container bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="ni ni-chart-pie-35 text-white" style="font-size: 1.2rem;"></i>
                  </div>
                  <div>
                      <p class="mb-0 text-xs text-muted text-uppercase">Costo Total</p>
                      <h6 class="mb-1 fw-bold">$<?= number_format($costoTotalViaje, 2, ',', '.'); ?></h6>
                      <small class="text-xs text-primary">Promedio/persona: $<?= $costoPromedioPersona; ?></small>
                  </div>
              </div>
          </div>
      </div>

      <!-- Deuda Total -->
      <div class="col">
          <div class="card border-0 border-top border-danger border-5">
              <div class="py-2 px-3 card-body d-flex align-items-center">
                  <div class="me-3 icon-container bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="ni ni-credit-card text-white" style="font-size: 1.2rem;"></i>
                  </div>
                  <div>
                      <p class="mb-0 text-xs text-muted text-uppercase">Deuda Total</p>
                      <h6 class="mb-1 fw-bold">$<?= number_format($totalDeudaViaje, 2, ',', '.'); ?></h6>
                      <small class="text-xs text-danger">Cantidad de items: <?php echo count($deudasViaje) ?></small>
                  </div>
              </div>
          </div>
      </div>

      <!-- Total Cobrado -->
      <div class="col">
          <div class="card border-0 border-top border-success border-5">
              <div class="py-2 px-3 card-body d-flex align-items-center">
                  <div class="me-3 icon-container bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                      <i class="ni ni-check-bold text-white" style="font-size: 1.2rem;"></i>
                  </div>
                  <div>
                      <p class="mb-0 text-xs text-muted text-uppercase">Cobrado</p>
                      <h6 class="mb-1 fw-bold">$<?= number_format($totalCobrado, 2, ',', '.'); ?></h6>
                      <small class="text-xs text-success"><?= $porcentajeCobradoDelTotal ?>% del total</small>
                  </div>
              </div>
          </div>
      </div>

      <!-- Gastos Internos -->
      <div class="col"
           data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Administrar gastos operativos">
        <a href="viajes_gastos_operativos.php?viajesId=<?php echo $viaje[$idNombre]; ?>">
          <div class="card border-0 border-top border-info border-5">
            <div class="py-2 px-3 card-body d-flex align-items-center">
              <div class="me-3 icon-container bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="ni ni-cart text-white" style="font-size: 1.2rem;"></i>
              </div>
              <div>
                <p class="mb-0 text-xs text-muted text-uppercase">Costos operativos</p>
                <h6 class="mb-1 fw-bold">$<?= number_format($totalCostos, 2, ',', '.'); ?></h6>
                <small class="text-xs text-info"> $<?= number_format($margenGanancia, 2, ',', '.'); ?> Ganancia (<?= $porcentajeMargen ?>%)</small>
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Pendiente -->
      <div class="col"
            data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="Editar alquileres de equipos">
        <a href="viajes_alquiler_equipos.php?viajesId=<?php echo $viaje[$idNombre]; ?>">
          <div class="card border-0 border-top border-warning border-5">
            <div class="py-2 px-3 card-body d-flex align-items-center">
                <div class="me-3 icon-container bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="ni ni-bulb-61 text-white" style="font-size: 1.2rem;"></i>
                </div>
                <div>
                    <p class="mb-0 text-xs text-muted text-uppercase">Alquiler equipos</p>
                    <h6 class="mb-1 fw-bold">$<?= number_format($costosAlquileres["costoTotal"], 2, ',', '.'); ?></h6>
                    <small class="text-xs text-warning">Ganancia $<?= number_format($costosAlquileres["ganancia"], 2, ',', '.'); ?></small>
                </div>
            </div>
          </div>
        </a>
      </div>
    </div>

  

      <div class="row pb-3">
        <div class="col-9 d-flex">
          <div class="card flex-fill">
            <div class="card-body">

              <div class="nav-wrapper position-relative end-0">

                <ul class="nav nav-tabs nav-justified mb-3 nav-border-top-primary"  role="tablist">
                  <li class="nav-item" role="presentation">
                      <a class="nav-link fw-medium <?= ($sub_seccion == 'costos_totales') ? 'active' : '' ?> text-secondary text-bold" 
                         data-bs-toggle="tab" 
                         href="#costos-tabs-icons" role="tab" aria-selected="<?= ($sub_seccion == 'costos_totales') ? 'true' : 'false' ?>" tabindex="-1">
                        Costos hospedajes <span class="badge bg-secondary rounded-circle">$<?php echo number_format($costoTotalHabitaciones, 2, '.', ','); ?></span>
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link fw-medium <?= ($sub_seccion == 'costos_listado') ? 'active' : '' ?> text-secondary text-bold" 
                         data-bs-toggle="tab" 
                         href="#costos_listado-tabs-icons" role="tab" aria-selected="<?= ($sub_seccion == 'costos') ? 'true' : 'false' ?>" tabindex="-1">
                        Costos planificados  <span class="badge bg-secondary rounded-circle"><?php echo count($costos); ?></span>
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link fw-medium align-middle <?= ($sub_seccion == 'viajeros') ? 'active' : '' ?> text-secondary text-bold" 
                         data-bs-toggle="tab" 
                         href="#viajeros-tabs-icons" 
                         role="tab" aria-selected="<?= ($sub_seccion == 'viajeros') ? 'true' : 'false' ?> " tabindex="-1">
                        Viajeros <span class="badge bg-secondary rounded-circle"><?php echo count($viajeros); ?></span>
                      </a>
                  </li>
                  <li class="nav-item" role="presentation">
                      <a class="nav-link fw-medium align-middle <?= ($sub_seccion == 'hospedajes') ? 'active' : '' ?> text-secondary text-bold" 
                         data-bs-toggle="tab" 
                         href="#hospedajes-tabs-icons" 
                         role="tab" 
                         aria-selected="<?= ($sub_seccion == 'hospedajes') ? 'true' : 'false' ?>">
                        Hospedajes <span class="badge bg-secondary "><?php echo count($viajesHospedajes); ?></span>
                      </a>
                  </li>
                </ul>
              </div>

              <div class="tab-content">
                <div class="tab-pane fade <?= ($sub_seccion == 'costos_totales') ? 'show active' : '' ?>" id="costos-tabs-icons" role="tabpanel" aria-labelledby="costos-tabs-icons-tab">
                  <!-- Content for Costos Tab -->

                  <?php 
                    if(isset($costosHospedajes['hospedajes']))
                      include("viajes_dashboard_costos.php"); 
                    else{
                  ?>
                  <p>No hay tarifas cargadas aun para el hospedaje</p>
                  <?php } ?>

                </div>
                <div class="tab-pane fade <?= ($sub_seccion == 'costos_listado') ? 'show active' : '' ?>" id="costos_listado-tabs-icons" role="tabpanel" aria-labelledby="costos_listado-tabs-icons-tab">
                  <!-- Content for Costos Tab -->

                  <?php include("viajes_dashboard_costos_listado.php"); ?>

                </div>
                <div class="tab-pane fade <?= ($sub_seccion == 'viajeros') ? 'show active' : '' ?>" id="viajeros-tabs-icons" role="tabpanel" aria-labelledby="viajeros-tabs-icons-tab">
                  <!-- Content for Viajeros Tab -->
                  <?php include("viajes_dashboard_usuarios.php"); ?>
                </div>
                <div class="tab-pane fade <?= ($sub_seccion == 'hospedajes') ? 'show active' : '' ?>" id="hospedajes-tabs-icons" role="tabpanel" aria-labelledby="hospedajes-tabs-icons-tab">
                  <!-- Content for Hospedajes Tab -->
                  <?php include("viajes_dashboard_hospedajes.php"); ?>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-3 d-flex">
          <div class="card mb-3 flex-fill">
            <div class="card-header pb-0">
              <h5 class="card-title">Pagos realizados (próximamente)</h5>
            </div>
            <div class="card-body">
              <div class="">
                <div class="d-grid gap-4">
                  <!-- <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 rounded-2 p-3 me-3">
                      <i class="ni ni-credit-card fs-4" style="color:white;"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h7 class="mb-0">18/7/2024</h7>
                      <p class="text-truncate m-0">Viajes - Vuelos</p>
                      <p class="text-secondary lh-sm small m-0" style="font-size: 11px;color: #c0cadb !important;">
                        El vuelo de Alber lo pagué con lo que cobré de lo que recibí de la devolución de los vuelos a Costa Rica
                      </p>
                    </div>
                    <h4 class="m-0 ms-auto text-danger">$670.19</h4>
                  </div>
                  
                  <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 rounded-2 p-3 me-3">
                      <i class="ni ni-mobile-button fs-4" style="color:white;"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h7 class="mb-0">18/7/2024</h7>
                      <p class="text-truncate m-0">Viajes - Vuelos</p>
                      <p class="text-secondary lh-sm small m-0" style="font-size: 11px;color: #c0cadb !important;">
                        Vuelos Facu y Ana
                      </p>
                    </div>
                    <h4 class="m-0 ms-auto text-danger">$1361.78</h4>
                  </div>

                  <div class="d-flex align-items-center">
                    <div class="bg-secondary bg-opacity-10 rounded-2 p-3 me-3">
                      <i class="ni ni-money-coins fs-4" style="color:white;"></i>
                    </div>
                    <div class="d-flex flex-column">
                      <h7 class="mb-0">26/9/2024</h7>
                      <p class="text-truncate m-0">Viajes - Excursiones</p>
                      <p class="text-secondary lh-sm small m-0" style="font-size: 11px;color: #c0cadb !important;">
                        Son 4300 pesos mexicanos a 18,50 el dólar, en pesos mexicanos. Esos son 240 dólares, que pagué en pesos a ANA CAROLINA CUTAIA, la amiga de Nani. Le transferí $296,400 a cotización de 1235
                      </p>
                    </div>
                    <h4 class="m-0 ms-auto text-danger">$240.00</h4>
                  </div> -->
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="row pb-3">

        <div class="col-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="card text-dark bg-light">
                    <div class="card-body p-3">
                      <div class="row" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <div class="col">
                          <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Costos</p>
                            <h5 class="font-weight-bolder">
                              $<?= number_format($costosTotalesSumados, 2, ',', '.'); ?>
                            </h5>
                            <p class="mb-0">
                              <canvas id="totalCostosChart" height="70" width="70"></canvas>
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        

        <div class="col-md-4 col-sm-4">
          <div class="card h-100 overflow-hidden">
            <div class="card-header pb-0">
                <h5 class="card-title">Tipo de viajeros</h5>
              </div>
            <div class="card-body">
              <table class="table">
                <tbody>
                  <tr>
                    <td>
                      <canvas class="tipoViajerosChart" id="tipoViajerosChart" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                    </td>
                    <td>
                      <table class="table table-borderless mb-0">
                        <tr>
                          <td><p class="mb-0"><i class="fa fa-square text-primary"></i> Total PAX </p></td>
                          <td><?php echo count($viajeros) ?></td>
                        </tr>
                        <tr>
                          <td><p class="mb-0"><i class="fa fa-square text-success"></i> Buzos </p></td>
                          <td>0 (0%)</td>
                        </tr>
                        <tr>
                          <td><p class="mb-0"><i class="fa fa-square text-purple"></i> Acompañantes </p></td>
                          <td>0 (0%)</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div> -->

      


      <?php include("includes/footer.php") ?>

    </div>


    <?php include("includes/scripts.php") ?>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <i class="fa fa-warning text-warning"></i>&nbsp;
            <h6 class="modal-title" id="modal-title-default">Errores de validación</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group list-group-flush" id="ul_errores" style="padding-left: 20px;">
              <!-- Errores se mostrarán aquí -->
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-primary ml-auto" data-bs-dismiss="modal">ENTENDIDO</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_promt" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
              Estás seguro que querés eliminar el item costo? Esta acción no puede deshacerse.
              Se eliminarán los costos asociados a los usuarios.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary ml-auto" data-bs-dismiss="modal">CANCELAR</button>
            <button type="button" 
                    class="btn bg-gradient-primary ml-auto" 
                    onclick="javascript:eliminarViajeCostos()"
                    data-bs-dismiss="modal" >ENTENDIDO</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal_promt_refresh_costo_usuarios" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
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
              Estás seguro que querés refrescar el item costo en todos los usuarios? Esta acción no puede deshacerse.
              Se van a actualizar todos los usuarios que correspondan con este costo al valor asignado.
              Si habias modificado este costo en algun usuario en particular, pasará a tener el nuevo valor desde ahora.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary ml-auto" data-bs-dismiss="modal">CANCELAR</button>
            <button type="button" 
                    class="btn bg-gradient-primary ml-auto" 
                    onclick="javascript:aplicarViajeCostoaTodosViajeros()"
                    data-bs-dismiss="modal" >ENTENDIDO</button>
          </div>
        </div>
      </div>
    </div>

    <button type="button" id="btn-modal-errores" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" style="display:none;">Default</button>

    <div id="toast" class="toast align-items-center text-white <?php echo ($action == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="font-size: 18px;">
          <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $action == "alta" ? "Usuario creado!" : "Usuario actualizado!"; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>

  </div>


  <script>
    var texto;
    var usuarioId;
    

    $(document).ready(function() {


      $('.btn-group').on('change', 'input[type="radio"]', function() {
        var monedaId = $(this).val();
        $('#cotizacion').prop("disabled", true);
        $('#cotizacion').val("");

        if (monedaId == 2 || monedaId == 3) {

          $('#cotizacion').attr('placeholder', 'Cargando cotización...');
          
          $.ajax({
            type: 'GET',
            url: '',
            data:{
              monedaId:monedaId,
              action:"cotizacion"
            },
            dataType: 'json',
            success: function(data) {
              console.log('Cotización dólar:', data);
              $('#cotizacion').val(data.cotizacion);
              $('#fecha_cotizacion').val("Cotización (" + data.fecha + ")");
              // Actualiza el valor de la cotización dólar en tu interfaz

              $('#cotizacion').attr('placeholder', '');
              $('#cotizacion').prop("disabled", false);
            },
            error: function(error){
              console.log(error);

              $.ajax({
                type: 'GET',
                url: 'https://api.bluelytics.com.ar/v2/latest',
                dataType: 'json',
                success: function(data) {
                  const ultimoUpdate = data.last_update;
                  const dolarOficial = data.oficial.value_avg;
                  const euroOficial = data.oficial_euro.value_avg;
                  const dolarBlue = data.blue.value_avg;
                  const euroBlue = data.blue_euro.value_avg;

                  console.log(`Última actualización: ${ultimoUpdate}`);
                  console.log(`Dólar oficial: ${dolarOficial}`);
                  console.log(`Euro oficial: ${euroOficial}`);
                  console.log(`Dólar blue: ${dolarBlue}`);
                  console.log(`Euro blue: ${euroBlue}`);

                  const fechaHoy = new Date();
                  const fechaFormateada = fechaHoy.toLocaleDateString('es-AR');

                  // Actualiza los valores en tu interfaz
                  $('#ultimoUpdate').text(ultimoUpdate);
                  $('#dolarOficial').text(dolarOficial);
                  $('#euroOficial').text(euroOficial);
                  $('#dolarBlue').text(dolarBlue);
                  $('#euroBlue').text(euroBlue);

                  $('#cotizacion').val(monedaId == 2 ? dolarBlue : euroBlue);
                  $('#fecha_cotizacion').val("Cotización (" + fechaFormateada + ")");

                  $('#cotizacion').attr('placeholder', '');
                  $('#cotizacion').prop("disabled", false);

                },
                error: function(xhr, status, error) {
                  $('#ul_errores').html('<li>' + error.responseText + '</li>');
                  $('#btn-modal-errores').click();

                  
                }
              });
            }
          });
        } else {
          $('#cotizacion').val();
        }
      });

      $('input[name="monedaId"][value="2"]').trigger('click');

      $('.habilitado-checkbox').click(function() {
         var id = $(this).attr('id').split('-')[1]; // Obtenemos el ID desde el atributo ID del span
          var activo = $(this).hasClass('bg-gradient-success') ? 0 : 1; // Toggle habilitado/deshabilitado

          $.ajax({
            url: '', 
            type: 'POST',
            data: {
              action: "actualizar",
              id: id,
              activo: activo,
              tabla: "<?php echo $tabla ?>"
            },
            success: function(response) {
              $(`#badge-${id}`).removeClass('bg-gradient-success bg-gradient-secondary')
                                .addClass(activo == 1 ? 'bg-gradient-success' : 'bg-gradient-secondary')
                                .text(activo == 1 ? 'ACTIVO' : 'INACTIVO');
            },
            error: function(xhr, status, error) {
              console.error('Error al actualizar:', error);
            }
          });
      });

    });
  </script>

   <script>

    <?php 
      if(count($estadisticasCostosTotales) != 0){
        $labels = array_column($estadisticasCostosTotales, 'subrubro');
        $data_values = array_column($estadisticasCostosTotales, 'monto_total');
        foreach ($estadisticasCostosTotales as $index => $item) {
          $colors[] = "#".dechex(rand(0,16777215)); // colores aleatorios
        }
    ?>
    var ctx = document.getElementById('totalCostosChart').getContext('2d');
    var totalCostosChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
          data: <?= json_encode($data_values) ?>,
          backgroundColor: <?= json_encode($colors) ?>,
          hoverBackgroundColor: <?= json_encode($colors) ?>,
          borderWidth: 1
        }]
      },
       options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'right', // Leyenda a la derecha
            align: 'center', // Centrado verticalmente
            labels: {
              boxWidth: 15, // Tamaño de la caja de color
              padding: 20,  // Espaciado entre ítems de la leyenda
              color: '#525f7f' // Color de texto
            }
          },
          tooltip: {
            enabled: true,
            backgroundColor: '#2dce89',
            titleColor: '#fff',
            bodyColor: '#fff'
          }
        },
        cutout: '70%' // Ajusta el tamaño del agujero en el centro
      }
    });

    var ctxTipoViajeros = document.getElementById('tipoViajerosChart').getContext('2d');
    var myTipoViajerosChart = new Chart(ctxTipoViajeros, {
      type: 'pie',
      data: {
        labels: ['Buzos', 'Acompañantes'],
        datasets: [{
          data: [17, 6],
          backgroundColor: [
            '#2dce89',
            '#67748e'
          ],
          hoverBackgroundColor: [
            '#2dce89',
            '#67748e'
          ],
          borderWidth: 1
        }]
      },
       options: {
        responsive: true,
        plugins: {
          legend: {
            display: false,
            position: 'right', // Leyenda a la derecha
            align: 'center', // Centrado verticalmente
            labels: {
              boxWidth: 15, // Tamaño de la caja de color
              padding: 20,  // Espaciado entre ítems de la leyenda
              color: '#525f7f' // Color de texto
            }
          },
          tooltip: {
            enabled: true,
            backgroundColor: '#2dce89',
            titleColor: '#fff',
            bodyColor: '#fff'
          }
        },
        cutout: '70%' // Ajusta el tamaño del agujero en el centro
      }
    });

    <?php } ?>
  </script>

  <?php include("includes/scripts_viajes_dashboard_usuarios.php"); ?>
  <?php include("includes/scripts_viajes_dashboard_hospedajes.php"); ?>

  <script>
    // Fecha de partida desde PHP
    var fechaPartida = "<?php echo date('Y-m-d H:i:s', strtotime($viaje['fecha_inicio'])); ?>";


    function updateStatusTab() {
      var partida = new Date(fechaPartida);
      var ahora = new Date();
      var diferencia = partida - ahora;

      var statusTab = document.getElementById("time-remaining");

      if (diferencia <= 0) {
        statusTab.innerHTML = "Finalizado";
      } else {
        var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        var horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
        var segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

        statusTab.innerHTML = dias + "d " + horas + "h " + minutos + "m " + segundos + "s restantes";
      }
    }

    // Actualiza la solapa cada segundo
    setInterval(updateStatusTab, 1000);
    updateStatusTab();


  </script>

  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }

    .toggle.btn{
      min-height: 2.50rem !important;
    }

    .nav-pills .nav-link.active {
      color: #fff;
      background-color: #0d6efd;
      border-radius: 8px;
    }

    .nav-pills .nav-link {
      transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active:hover {
      background-color: #083b86;
    }

    .nav-pills .nav-link.active::before {
      content: "";
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      height: 4px;
      border-radius: 10px;
    }

    .imagen-circular {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin-top: -2px;
    }

    .dropdown-item{
      border: 1px solid #cfcbcb;
      border-radius: inherit;
    }

    #resultado{
      margin-top:-20px;
    }

    .card-hospedaje {
      border: 1px solid #ddd;
      border-radius: 0;
      box-shadow: none;
      padding: 0;
    }

    .card-hospedaje-header {
      background-color: #f7f7f7;
      border-bottom: 1px solid #ddd;
      padding: 10px;
    }

    .card-hospedaje-body {
      padding: 20px;
    }

    .card-hospedaje-footer {
      background-color: #f7f7f7;
      border-top: 1px solid #ddd;
      padding: 10px;
    }

    .nav-border-top-primary .nav-link.active {
      color: var(--bs-secondary);
      border-top-color: var(--bs-secondary);
      border-top: 4px solid !important;
    }

    .fs-7 {
      font-size: 0.75rem !important;
    }

  </style>
</body>

</html>