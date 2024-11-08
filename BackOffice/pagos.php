<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "pagos";
    $idNombre = "pagoId";
    //$subpagos = getPagos();
    $title = "PAGOS";
    $usuarioId = isset($_GET["usuarioId"]) && !empty($_GET["usuarioId"]) ? $_GET["usuarioId"] : null;
    $pagos = getPagos($usuarioId);

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
          <div class="card mb-4" style="padding: 18px;">
            <div class="card-header pb-0">
              <h6 class="float-start">Listado</h6>
              <div class="float-end">
                <?php if (isset($_GET['usuarioId'])): ?>
                <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                  <i class="ni ni-bold-left"></i> Volver
                </a>
                <?php endif; ?>
                <a href="pagos_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar pago">
                      <i class="ni ni-fat-add"></i> AGREGAR PAGO
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
                        <td class="text-center">
                          <p class="text-sm mb-0">
                            <span class="badge 
                              <?php if ($pago["pagoTransaccionTipoId"] == 2) echo 'bg-gradient-info'; 
                                    elseif ($pago["pagoTransaccionTipoId"] == 1) echo 'bg-gradient-danger'; ?>">
                              <?php echo ($pago["pagoTransaccionTipoId"] == 2) ? 'Ingreso' : 'Egreso'; ?>
                            </span>
                          </p>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0"><?php echo date("d/m/Y", strtotime($pago["fecha"])) ?></p>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0"><?php echo $pago["simbolo"] ?> <?php echo number_format($pago["monto"], 2) ?> </p>
                        </td>
                        <td>
                          <p class="text-sm font-weight-bold mb-0"><?php echo $pago["medioPago"] ?></p>
                        </td>
                        <td>
                          <a href="usuarios_editar.php?usuarioId=<?php echo $pago["usuarioId"] ?>">
                            <p class="text-sm font-weight-bold mb-0"><?php echo isset($pago["usuario_nombre"]) ? $pago["usuario_nombre"]." ".$pago["usuario_apellido"]." (".$pago["apodo"].") - ".$pago["dni"] : '-' ?></p>
                          </a>
                        </td>
                        <td>
                          <a href="deudas_editar.php?deudaId=<?php echo $pago['deudaId'] ?>">
                            <p class="text-sm font-weight-bold mb-0">
                              <?php if($pago["deudaId"] !== null): ?>
                                <?php echo $pago['deuda_tipo']; ?> (<?php echo $pago['deuda_simbolo']; ?> <?php echo $pago['deuda']; ?>)
                              <?php endif; ?>
                            </p>
                          </a>
                        </td>
                        <td class="text-center">
                          <span id="badge-<?php echo $pago[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                              <?php echo ($pago["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                              <?php echo ($pago["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <a href="pagos_editar.php?<?php echo $idNombre ?>=<?php echo $pago[$idNombre] ?>">
                            <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
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
      </div>
      
      <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" style="font-size: 18px;">
            <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> Item creado correctamente!
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