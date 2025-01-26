<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "deudas";
    $idNombre = "deudaId";
    //$subpagos = getPagos();
    $title = "DEUDAS";
    $usuarioId = isset($_GET["usuarioId"]) && !empty($_GET["usuarioId"]) ? $_GET["usuarioId"] : null;
    $deudas = getDeudas($usuarioId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
      updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
    }

    $descripcion = "";

    if( isset($_GET["viajesId"]) ){
      $viaje = getItem("viajes", "viajesId", $_GET["viajesId"]);
      $pais = getItem("paises", "paisId", $viaje["paisId"]);
      $descripcion = " de deudas - ".$pais["pais"]." ".$viaje["anio"];
      $deudas = getDeudasViaje($_GET["viajesId"]);
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
              <h6 class="float-start">Listado <?php echo $descripcion ?></h6>
              <div class="float-end">
                <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                  <i class="ni ni-bold-left"></i> Volver
                </a>
                <?php if (isset($_GET['usuarioId']) || isset($_GET["viajesId"])): ?>
                <a href="deudas.php" class="btn btn-sm btn-icon grey darken-1 mx-1">
                  <i class="fa fa-trash"></i> Limpiar filtros
                </a>
                <?php endif; ?>
                <a href="deudas_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar pago">
                      <i class="ni ni-fat-add"></i> AGREGAR DEUDA
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
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deuda</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pagos</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pagar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($deudas as $deuda): ?>
                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <?php echo $deuda[$idNombre] ?>
                          </div>
                        </td>
                        <td class="">
                          <p class="text-sm mb-0" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" 
                            title="<?php echo $deuda["usuario_nombre"] . " " . $deuda["usuario_apellido"]; ?>">
                             <?php 
                             echo !empty($deuda["apodo"]) 
                                 ? $deuda["apodo"] 
                                 : $deuda["usuario_nombre"] . " " . $deuda["usuario_apellido"];
                             ?>
                          </p>
                        </td>
                        <td>
                          <p class="text-sm mb-0"><?php echo $deuda["subrubro"] ?> (<?php echo $deuda["rubro"] ?>)</p>
                        </td>
                        <td>
                          <p class="text-sm mb-0"><?php echo $deuda["comentario"] ?></p>
                        </td>
                        <td>
                          <p class="text-sm mb-0"><?php echo $deuda["simbolo"] ?> <?php echo number_format($deuda["deuda"], 2) ?> </p>
                        </td>
                        <td>
                          <a href="pagos.php?<?php echo $idNombre ?>=<?php echo $deuda[$idNombre] ?>">
                            <p class="text-sm mb-0 text-bold"><?php echo $deuda["simbolo"] ?> <?php echo number_format($deuda["total_pagado"], 2) ?> </p>
                          </a>
                        </td>
                        <td class="text-center">
                          <span class="badge badge-sm
                              <?php echo ($deuda["deuda"] <= $deuda["total_pagado"] ) ? 'bg-gradient-success' : 'bg-gradient-warning'; ?>">
                              <?php echo ($deuda["deuda"] <= $deuda["total_pagado"]) ? 'PAGO' : 'IMPAGO'; ?>
                          </span>
                        </td>
                        <!-- <td class="text-center">
                          <span id="badge-<?php echo $deuda[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                              <?php echo ($deuda["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                              <?php echo ($deuda["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                          </span>
                        </td> -->
                        <td class="text-center">
                          <a href="deudas_editar.php?<?php echo $idNombre ?>=<?php echo $deuda[$idNombre] ?>">
                            <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                              Editar
                            </button>
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