<?php 
    
    
    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "pagos_rubros";
    $idNombre = "pagosRubroId";
    $rubros = getRubrosPagos();
    $title = "RUBROS";

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
                <a href="pagos_rubros_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar rubro">
                      <i class="ni ni-fat-add"></i> AGREGAR RUBRO
                  </button>
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rubro</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subrubros (T/H)</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habilitado</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rubros as $rubro): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <?php echo $rubro[$idNombre] ?>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $rubro["rubro"] ?></p>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                          <span class="comment-tooltip" title="<?php echo $rubro["comentario"] ?>">
                              <?php echo strlen($rubro["comentario"]) > 20 ? substr($rubro["comentario"], 0, 20) . '...' : $rubro["comentario"]; ?>
                          </span>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                          <a href="pagos_subrubros.php?pagosRubrosId=<?php echo $rubro[$idNombre]; ?>">
                              <u><?php echo $rubro["total_subrubros"] ?></u> (<?php echo $rubro["subrubros_habilitados"] ?>)
                          </a>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <span id="badge-<?php echo $rubro[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                            <?php echo ($rubro["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                            <?php echo ($rubro["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="pagos_rubros_editar.php?<?php echo $idNombre ?>=<?php echo $rubro[$idNombre] ?>">
                          <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0" type="button">
                            <span class="btn-inner--icon"><i class="ni ni-settings-gear-65"></i> Editar</span>
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
      
      <?php include("includes/footer.php") ?>

    </div>
  </main>
  
  <?php include("includes/scripts.php") ?>

  <script>
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
    });

  </script>

  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>