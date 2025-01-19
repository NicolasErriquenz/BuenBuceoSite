<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "hospedajes";
    $idNombre = "hospedajesId";
    $hospedajes = getHospedajes();
    $title = "HOSPEDAJES";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
        updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
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
          <div class="card mb-4">
            <div class="card-header pb-0">
                <h6 class="float-start">Listado</h6>
                <a href="hospedajes_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar rubro">
                      <i class="ni ni-fat-add"></i> AGREGAR HOSPEDAJE
                  </button>
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="custom-scroll-container">
                <div class="table-responsive custom-pagination">
                  <table class="table mb-0 dataTable" id="tableDataTables">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pais</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Direccion</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Calificación</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($hospedajes as $item): ?>
                    <tr>
                      <td>
                        <div class="">
                          <?php echo $item[$idNombre] ?>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $item["nombre"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $item["pais"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $item["direccion"] ?></p>
                      </td>
                      <td class="text-center">
                        <p class="text-sm font-weight-bold mb-0"><span class="fa fa-star">&nbsp;<?php echo $item["estrellas"] ?></span></p>
                      </td>
                      <td class="">
                        <span class="text-secondary text-xs font-weight-bold">
                          <span class="comment-tooltip" title="<?php echo $item["comentario"] ?>" alt="<?php echo $item["comentario"] ?>">
                              <?php echo strlen($item["comentario"]) > 20 ? substr($item["comentario"], 0, 20) . '...' : $item["comentario"]; ?>
                          </span>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="hospedajes_editar.php?<?php echo $idNombre ?>=<?php echo $item[$idNombre] ?>">
                          <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                            Editar
                          </button>
                        </a>
                        <a href="hospedajes_tarifas.php?<?php echo $idNombre ?>=<?php echo $item[$idNombre] ?>">
                          <button class="btn btn-icon btn-2 btn-sm btn-dark mb-0 ajuste_boton" type="button">
                            Tarifas
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
      
      <?php include("includes/footer.php") ?>

      <div id="toast" class="toast align-items-center text-white <?php echo ($_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" style="font-size: 18px;">
            <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Hospedaje creado!" : "Hospedaje actualizado!"; ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>

    </div>
  </main>
  
  <?php include("includes/scripts.php") ?>

  <script>
    function crearToast(){
      const toast = new bootstrap.Toast(document.getElementById('toast'), {
        animation: true,
        autohide: true,
        delay: 2000,
      });

      // Muestra el toast
      toast.show();
    }

    $(document).ready(function() {
        $('.habilitado-checkbox').click(function() {
            var id = $(this).attr('id').split('-')[1]; // Obtenemos el ID desde el atributo ID del span
            var habilitado = $(this).hasClass('bg-gradient-success') ? 0 : 1; // Toggle habilitado/deshabilitado

            $.ajax({
                url: '', 
                type: 'POST',
                data: {
                    action: "actualizar",
                    id: id,
                    habilitado: habilitado,
                    tabla: "<?php echo $tabla ?>"
                },
                success: function(response) {
                    $(`#badge-${id}`).removeClass('bg-gradient-success bg-gradient-secondary')
                                     .addClass(habilitado == 1 ? 'bg-gradient-success' : 'bg-gradient-secondary')
                                     .text(habilitado == 1 ? 'Online' : 'Offline');
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

  </script>

  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>