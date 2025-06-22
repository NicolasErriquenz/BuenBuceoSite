<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "paquetes";
    $idNombre = "paquetesId";
    //$subpagos = getPagos();
    $title = "PAQUETES";
    $usuarioId = isset($_GET["usuarioId"]) && !empty($_GET["usuarioId"]) ? $_GET["usuarioId"] : null;
    $paquetes = getPaquetes();
    $monedas = getMonedas();

    $paises = getPaises();
    $continentes = getContinentes();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
        updateActivo($_POST["id"], $_POST["activo"], $tabla, $idNombre);
    }

?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<?php include("includes/head.php"); ?>

<body class="g-sidenav-show   bg-gray-100">
  
  <?php echo $HEADER_IMAGEN ?>
  
  <?php include("includes/menu.php"); ?>

  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    
    <?php include("includes/navbar.php"); ?>

    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4" style="padding: 18px;">
            <div class="card-header pb-0">
              <h6 class="float-start">Listado de paquetes</h6>
              <div class="float-end">
                <?php if (isset($_GET['usuarioId'])): ?>
                <a href="viajes.php" class="btn btn-sm btn-icon grey darken-1 mx-1">
                  <i class="fa fa-trash"></i> Limpiar filtro de usuario
                </a>
                <?php endif; ?>
                <a href="paquetes_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar paquete">
                      <i class="ni ni-fat-add"></i> AGREGAR PAQUETE
                  </button>
                </a>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="custom-scroll-container">
                <div class="table-responsive custom-pagination">
                  <table class="table mb-0 dataTable" id="tableDataTables">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Título</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">País</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inicio/Fin</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">País</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Activo</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($paquetes as $item): ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <?php echo $item[$idNombre] ?>
                          </div>
                        </td>
                        <td class="text-center">
                          <p class="text-sm font-weight-bold mb-0"><?php echo $item["titulo"] ?></p>
                          <p class="text-xs text-secondary mb-0"><?php echo substr($item["descripcion"], 0, 50) ?>...</p>
                        </td>
                        <td>
                          <?php 
                              // Buscar país
                              $nombrePais = '';
                              foreach($paises as $pais) {
                                  if($pais['paisId'] == $item['paisId']) {
                                      $nombrePais = $pais['pais'];
                                      break;
                                  }
                              }
                              
                              // Buscar continente
                              $nombreContinente = '';
                              foreach($continentes as $continente) {
                                  if($continente['continentesId'] == $item['continentesId']) {
                                      $nombreContinente = $continente['continente'];
                                      break;
                                  }
                              }
                          ?>
                          <p class="text-sm font-weight-bold mb-0"><?php echo $nombrePais; ?></p>
                          <p class="text-xs text-secondary mb-0"><?php echo $nombreContinente; ?></p>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0">
                            <?php 
                              $fecha_inicio = !empty($item["fecha_inicio"]) ? date("d-m-Y", strtotime($item["fecha_inicio"])) : 'N/A'; 
                              $fecha_fin = !empty($item["fecha_fin"]) ? date("d-m-Y", strtotime($item["fecha_fin"])) : 'N/A'; 
                            ?>
                            <?php echo $fecha_inicio ?> / <?php echo $fecha_fin ?>
                          </p>
                          <p class="text-xs text-secondary mb-0"><?php echo $item["cantidad_dias"] ?? 0 ?> días</p>
                        </td>
                        <td class="text-center">
                          <p class="text-sm font-weight-bold mb-0">
                            <?php echo number_format($item["precio"], 2) ?>
                          </p>
                          <p class="text-xs text-secondary mb-0">
                            <?php 
                                foreach($monedas as $moneda) {
                                    if($moneda['monedaId'] == $item['monedaId']) {
                                        echo $moneda['simbolo'] . ' ' . $moneda['moneda'];
                                        break;
                                    }
                                }
                            ?>
                          </p>
                        </td>
                        <td class="text-center">
                          <span id="badge-<?php echo $item[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                              <?php echo ($item["activo"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                              <?php echo ($item["activo"] == 1) ? 'ACTIVO' : 'INACTIVO'; ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <a href="paquetes_editar.php?<?php echo $idNombre ?>=<?php echo $item[$idNombre] ?>">
                            <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                              Editar
                            </button>
                          </a>
                          <a href="paquetes_galeria.php?<?php echo $idNombre ?>=<?php echo $item[$idNombre] ?>">
                            <button class="btn btn-icon btn-2 btn-sm bg-gradient-info mb-0 ajuste_boton" type="button">
                              Galería de fotos
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
        </div>
      </div>
      
      <div id="toast" class="toast align-items-center text-white <?php echo (isset($_GET["action"]) && $_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?>" 
         border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" style="font-size: 18px;">
                <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i>
                <?php echo (isset($_GET["action"]) && $_GET["action"] == "alta") ? "Viaje creado!" : "Viaje actualizado!"; ?>
            </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>

      <?php include("includes/footer.php") ?>

    </div>
  </main>
  
  <?php include("includes/scripts.php") ?>

  <script>
    $(document).ready(function() {

        

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

  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>