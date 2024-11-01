<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "pagos";
    $idNombre = "pagoId";
    $subpagos = getPagos();
    $title = "PAGOS";
    $pagos = getPagos();

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
                <a href="pagos_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar pago">
                      <i class="ni ni-fat-add"></i> AGREGAR PAGO
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subrubro</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transacción Tipo</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Medio Pago</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deuda</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habilitado</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pagos as $pago): ?>
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <?php echo $pago[$idNombre] ?>
                        </div>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $pago["rubro"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $pago["subrubro"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $pago["transaccion_tipo"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo date("d/m/Y H:i", strtotime($pago["fecha"])) ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo number_format($pago["monto"], 2) ?> <?php echo $pago["moneda"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo $pago["medioPago"] ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo isset($pago["usuario_nombre"]) ? $pago["usuario_nombre"] : '-' ?></p>
                      </td>
                      <td>
                        <p class="text-sm font-weight-bold mb-0"><?php echo isset($pago["deuda_descripcion"]) ? $pago["deuda_descripcion"] : '-' ?></p>
                      </td>
                      <td class="align-middle text-center">
                        <span id="badge-<?php echo $pago[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                            <?php echo ($pago["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                            <?php echo ($pago["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="pagos_editar.php?<?php echo $idNombre ?>=<?php echo $pago[$idNombre] ?>">
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