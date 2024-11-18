<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarViajeCostos" ) {
    echo eliminarViajeCostos($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajeCosto" ) {
    echo altaViajeCostos($_POST);
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

  $viajerosTipos = getViajesViajeroTipo();
  $monedas = getMonedas();
  $paisNombre = getPais($viaje['paisId']);

  $hospedajes = getHospedajes($viaje['paisId']);

  $seccion = isset($_GET["seccion"]) ? $_GET["seccion"] : "costos";

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
    <div class="card shadow-lg mx-4" style="margin-top: 3rem !important;">
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


    <div class="container-fluid py-4">

      
      <div class="row pb-3">
        <div class="col-12">
          <div class="card">
            <div class="card-body">

              <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist" style="border-radius: 10px; background-color: #f8f9fa;">

                  <!-- Costos -->
                  <li class="nav-item">
                    <a class="nav-link <?= ($seccion == 'costos') ? 'active' : '' ?> mb-0 px-4 py-3 d-flex align-items-center justify-content-center" 
                       data-bs-toggle="tab" href="#costos-tabs-icons" role="tab" aria-controls="costos-tabs-icons" aria-selected="<?= ($seccion == 'costos') ? 'true' : 'false' ?>" 
                       style="border-radius: 8px; text-align: center;">
                      <i class="ni ni-credit-card text-lg me-2"></i>
                      <span>Costos</span>
                      <span class="badge bg-primary ms-2 px-2 py-1" style="font-size: 0.85rem;">$<?php echo number_format(0, 2, '.', ','); ?></span>
                    </a>
                  </li>

                  <!-- Viajeros -->
                  <li class="nav-item">
                    <a class="nav-link <?= ($seccion == 'viajeros') ? 'active' : '' ?> mb-0 px-4 py-3 d-flex align-items-center justify-content-center" 
                       data-bs-toggle="tab" href="#viajeros-tabs-icons" role="tab" aria-controls="viajeros-tabs-icons" aria-selected="<?= ($seccion == 'viajeros') ? 'true' : 'false' ?>" 
                       style="border-radius: 8px; text-align: center;">
                      <i class="ni ni-circle-08 text-lg me-2"></i>
                      <span>Viajeros</span>
                      <span class="badge bg-warning ms-2 px-2 py-1" style="font-size: 0.85rem;"><?php echo count($viajeros); ?> personas</span>
                    </a>
                  </li>

                  <!-- Hospedajes -->
                  <li class="nav-item">
                    <a class="nav-link <?= ($seccion == 'hospedajes') ? 'active' : '' ?> mb-0 px-4 py-3 d-flex align-items-center justify-content-center" 
                       data-bs-toggle="tab" href="#hospedajes-tabs-icons" role="tab" aria-controls="hospedajes-tabs-icons" aria-selected="<?= ($seccion == 'hospedajes') ? 'true' : 'false' ?>" 
                       style="border-radius: 8px; text-align: center;">
                      <i class="ni ni-building text-lg me-2"></i>
                      <span>Hospedajes</span>
                      <span class="badge bg-success ms-2 px-2 py-1" style="font-size: 0.85rem;"><?php echo count($viajesHospedajes); ?></span>
                    </a>
                  </li>
                </ul>
              </div>

              <div class="tab-content">
                <div class="tab-pane fade <?= ($seccion == 'costos') ? 'show active' : '' ?>" id="costos-tabs-icons" role="tabpanel" aria-labelledby="costos-tabs-icons-tab">
                  <!-- Content for Costos Tab -->

                  <div class="row">
                    <div class="col">
                      <h6 class="float-start"></h6>
                      <div class="float-end">
                        <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-costo">
                            <i class="ni ni-fat-add"></i> COSTO
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="custom-scroll-container">
                    <div class="table-responsive custom-pagination" style="margin: 0px !important;">
                      <table class="table mb-0 dataTable">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subrubro</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alcance</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($costos as $item): ?>
                          <tr>
                            <td>
                              <?php echo $item["viajeCostoId"] ?>
                            </td>
                            <td>
                              <?php echo $item["subrubro"] ?>
                            </td>
                            <td class="text-center">
                              <?php echo $item["simbolo"] ?> <?php echo $item["monto"] ?>
                            </td>
                            <td class="text-center">
                              <?php echo $item["soloBuzos"] == "1" ? "Buzos" : "Todos" ?>
                            </td>
                            <td>
                              <?php echo $item["comentario"] ?>
                            </td>
                            <td class="align-middle text-center">
                                <a href="javascript:confirmarEliminarCosto(<?php echo $item["viajeCostoId"] ?>)"
                                   class="btn btn-icon btn-outline-danger btn-xs mb-0">
                                  <span class="btn-inner--icon"><i class="fa fa-times"></i></span>
                                </a>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade <?= ($seccion == 'viajeros') ? 'show active' : '' ?>" id="viajeros-tabs-icons" role="tabpanel" aria-labelledby="viajeros-tabs-icons-tab">
                  <!-- Content for Viajeros Tab -->
                  <?php include("viajes_dashboard_usuarios.php"); ?>
                </div>
                <div class="tab-pane fade <?= ($seccion == 'hospedajes') ? 'show active' : '' ?>" id="hospedajes-tabs-icons" role="tabpanel" aria-labelledby="hospedajes-tabs-icons-tab">
                  <!-- Content for Hospedajes Tab -->
                  <?php include("viajes_dashboard_hospedajes.php"); ?>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <!-- Card 1: Today's Money -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="mb-4 card" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); transition: box-shadow 0.3s ease;">
            <div class="p-3 card-body">
              <div class="d-flex flex-row-reverse justify-content-between">
                <div>
                  <div class="text-center icon icon-shape bg-gradient-primary border-radius-2xl">
                    <i class="text-lg opacity-10 ni ni-money-coins" aria-hidden="true"></i>
                  </div>
                </div>
                <div>
                  <div class="numbers">
                    <p class="mb-0 text-sm text-uppercase font-weight-bold">Total cobrado</p>
                    <h5 class="font-weight-bolder">$53,000</h5>
                    <span class="text-sm text-info font-weight-bold">12%</span> del total de deuda
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 2: Today's Users -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="mb-4 card" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); transition: box-shadow 0.3s ease;">
            <div class="p-3 card-body">
              <div class="d-flex flex-row-reverse justify-content-between">
                <div>
                  <div class="text-center icon icon-shape bg-gradient-danger border-radius-2xl">
                    <i class="text-lg opacity-10 ni ni-world" aria-hidden="true"></i>
                  </div>
                </div>
                <div>
                  <div class="numbers">
                    <p class="mb-0 text-sm text-uppercase font-weight-bold">Falta cobrar</p>
                    <h5 class="font-weight-bolder">2,300</h5>
                    <span class="text-sm text-success font-weight-bold">+3%</span> since last week
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 3: New Clients -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="mb-4 card" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); transition: box-shadow 0.3s ease;">
            <div class="p-3 card-body">
              <div class="d-flex flex-row-reverse justify-content-between">
                <div>
                  <div class="text-center icon icon-shape bg-gradient-success border-radius-2xl">
                    <i class="text-lg opacity-10 ni ni-paper-diploma" aria-hidden="true"></i>
                  </div>
                </div>
                <div>
                  <div class="numbers">
                    <p class="mb-0 text-sm text-uppercase font-weight-bold">Ganancia total</p>
                    <h5 class="font-weight-bolder">+3,462</h5>
                    <span class="text-sm text-danger">-2%</span> since last quarter
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 4: Sales -->
        <div class="col-lg-3 col-md-6 col-12">
          <div class="mb-4 card" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.06); transition: box-shadow 0.3s ease;">
            <div class="p-3 card-body">
              <div class="d-flex flex-row-reverse justify-content-between">
                <div>
                  <div class="text-center icon icon-shape bg-gradient-warning border-radius-2xl">
                    <i class="text-lg opacity-10 ni ni-cart" aria-hidden="true"></i>
                  </div>
                </div>
                <div>
                  <div class="numbers">
                    <p class="mb-0 text-sm text-uppercase font-weight-bold">Costos nuestros</p>
                    <h5 class="font-weight-bolder">$3500.00</h5>
                    <span class="text-sm text-success"></span> Ver detalle
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-4">
          
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">DASHBOARD</p>
                <div class="d-flex align-items-center">
                  <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                    <i class="ni ni-bold-left"></i> Volver
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body">
              
              <div class="row">
                <div class="col">
                  <div class="card text-dark bg-light">
                    <div class="card-body p-3">
                      <div class="row" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <div class="col-8">
                          <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">Costos</p>
                            <h5 class="font-weight-bolder">
                              $53,000
                            </h5>
                            <p class="mb-0">
                              <canvas id="myDoughnutChart" height="70" width="70"></canvas>
                            </p>
                          </div>
                        </div>
                        <div class="col-4 text-end">
                          <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
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
      </div>

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

    <button type="button" id="btn-modal-errores" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" style="display:none;">Default</button>

    <div id="toast" class="toast align-items-center text-white <?php echo ($_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="font-size: 18px;">
          <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Usuario creado!" : "Usuario actualizado!"; ?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>

      
    

   

    <div class="modal fade" id="modal-costo" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar costo</h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:black">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0">
            <div class="card card-plain">
              <div class="card-body">
                <form role="form text-left" method="post" action"" id="formNuevoCosto">
                  <input type="hidden" value="agregarCosto" name="action">
                  <p class="text-uppercase text-sm">Categorías del costo</p>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="rubro" class="form-control-label">Rubro</label>
                        <select id="pagosRubroId" name="pagosRubroId" class="form-control custom-select" disabled>
                          <option value="2" selected>Viajes</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="subrubro" class="form-control-label">Subrubro</label>
                        <select id="pagosSubrubroId" name="pagosSubrubroId" class="form-control">
                          <option value="" selected disabled>Seleccione un subrubro</option>
                            <?php foreach ($subrubros as $sub): ?>
                              <option value="<?php echo $sub['pagosSubrubroId']; ?>">
                              <?php echo $sub['subrubro']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Datos del costo</p>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label" style="display: block;">Moneda</label>
                      <div class="btn-group btn-group-toggle w-100" data-bs-toggle="buttons">
                        <?php foreach ($monedas as $moneda): ?>
                        <label class="btn w-100 <?php echo $moneda['monedaId'] == 1 ? "active" : ""; ?>">
                          <input type="radio" name="monedaId" value="<?php echo $moneda['monedaId']; ?>" <?php echo $moneda['monedaId'] == 1 ? "selected" : ""; ?>">
                          <?php echo $moneda['moneda']; ?>
                        </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Monto</label>
                        <div class="input-group mb-4">
                          <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                          <input type="number" step="any" 
                                id="monto" name="monto" 
                                placeholder="00.00"
                                value="" 
                                class="form-control" style="text-align: right;">
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label" id="fecha_cotizacion">Cotización</label>
                        <div class="input-group mb-4">
                          <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                          <input type="text" 
                                id="cotizacion" name="cotizacion" 
                                value="" 
                                class="form-control" style="text-align: right;">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group my-auto">
                    <label class="form-control-label">Alcance</label>
                    <div class="d-grid gap-4">
                      <input type="checkbox" 
                              name="soloBuzos"
                              id="soloBuzos"
                              data-onvalue="2"
                              data-offvalue="1"
                              data-toggle="toggle" 
                              data-onlabel="Sólo buzos" 
                              data-offlabel="Todos" 
                              data-onstyle="info" 
                              data-offstyle="secondary" 
                              data-style="android"
                              style="min-height: 42px !important;"
                              >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="comentario">Comentario</label>
                    <textarea id="comentario" name="comentario" class="form-control"></textarea>
                  </div>

                  <div class="form-check form-switch">
                    <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" 
                          class="habilitado-checkbox"
                          name="aplicarCostoViajeros"
                          id="aplicarCostoViajeros"
                          checked>
                      Aplicar costo a los viajeros actuales
                    </label>
                  </div>
                  
                  <div class="row">
                    <div class="text-center alert alert-danger fade mb-0 mt-2" id="error_div_costos">
                      <span class="alert-icon"><i class="fa fa-warning"></i></span>
                      <span id="error-text-costos"></span>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="button" onclick="javascript:altaCosto()" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">GUARDAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  <script>
    var texto;
    var usuarioId;
    var viajeCostoId;

    function confirmarEliminarCosto(id){
      $("#modal_promt").modal("show");
      viajeCostoId = id;
    }

    function eliminarViajeCostos(){
      $.ajax({
        type: 'POST',
        url: '',
        data: {
          viajeCostoId: viajeCostoId, 
          action:"eliminarViajeCostos",
          viajesId:<?= $viaje[$idNombre] ?>,
        },
        dataType: 'text',
        success: function(data) {
          if(data == "ok")
            location.reload();
          else{
            $('#error_div_costos').removeClass('fade').addClass('show');
            $('#error-text-costos').text(data);
          }
        },
        error: function(e, i){
          
        }
      })
    };

    function altaCosto(){

      var pagosSubrubroId = $("#pagosSubrubroId").val();
      var monedaId = $('input[name="monedaId"]:checked').val();
      var monto = $("#monto").val();
      var cotizacion = $("#cotizacion").val();
      var soloBuzos = $('input[name="soloBuzos"]:checked').val();
      var comentario = $("#comentario").val();
      var aplicarCostoViajeros = $('input[name="aplicarCostoViajeros"]:checked').val();

      if(!pagosSubrubroId || pagosSubrubroId == undefined)
        var error = 'Hay que seleccionar un subrubro';

      if(!monedaId || monedaId == undefined)
        var error = 'Hay que seleccionar el tipo de moneda"';

      if(!monto || monto == "")
        var error = 'Ingresa monto';

      if(!monto || monto == "")
        var error = 'Ingresa monto';

      if (error) {
        $('#error_div_costos').removeClass('fade').addClass('show');
        $('#error-text-costos').text(error);
        return;
      } else {
        $('#error_div_costos').removeClass('show').addClass('fade');
      }

      $.ajax({
        type: 'POST',
        url: '',
        data: {
          pagosSubrubroId: pagosSubrubroId, 
          action:"altaViajeCosto",
          viajesId:<?= $viaje[$idNombre] ?>,
          monedaId:monedaId,
          monto:monto,
          cotizacion:cotizacion,
          soloBuzos:soloBuzos,
          comentario:comentario,
          aplicarCostoViajeros:aplicarCostoViajeros,
        },
        dataType: 'text',
        success: function(data) {
          if(data == "ok")
            location.reload();
          else{
            $('#error_div_costos').removeClass('fade').addClass('show');
            $('#error-text-costos').text(data);
          }
        },
        error: function(e, i){
          
        }
      });
    }

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
    var ctx = document.getElementById('myDoughnutChart').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Primario', 'Éxito', 'Peligro', 'Advertencia', 'Info'],
        datasets: [{
          data: [100, 25, 30, 15, 10],
          backgroundColor: [
            '#5e72e4', // Primario
            '#2dce89', // Éxito
            '#f5365c', // Peligro
            '#fb6340', // Advertencia
            '#11cdef'  // Info
          ],
          hoverBackgroundColor: [
            '#5e72e4cc',
            '#2dce89cc',
            '#f5365ccc',
            '#fb6340cc',
            '#11cdefcc'
          ],
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

  </style>
</body>

</html>