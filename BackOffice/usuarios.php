<?php 
    
    
    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "usuarios";
    $idNombre = "usuarioId";
    $usuarios = getUsuarios();
    $title = "USUARIOS";

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
                <a href="usuarios_editar.php">
                  <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-toggle="tooltip" data-original-title="Agregar rubro">
                      <i class="ni ni-fat-add"></i> AGREGAR USUARIO
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Avatar</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Apodo/Nombre</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Viajero</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deudas</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pagos</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habilitado</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($usuarios ?? [] as $usuario): ?>
                    <tr>
                      <td>
                        <div class="">
                          <?php echo $usuario[$idNombre] ?>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="imagen-circular" style="background-image: url('_recursos/profile_pics/<?php 
                          echo !empty($usuario['imagen']) ? $usuario['imagen'] : 'generic_user.png'; 
                        ?>')"></div>
                      </td>
                      <td>
                       <p class="text-sm mb-0">
                            <?php 
                                if (empty($usuario["apodo"])) {
                                    echo $usuario["nombre"] . " (" . $usuario["nombre"] . " " . $usuario["apellido"] . ")";
                                } else {
                                    echo $usuario["apodo"] . " (" . $usuario["nombre"] . " " . $usuario["apellido"] . ")";
                                }
                            ?>
                        </p>
                      </td>
                      <td>
                        <p class="text-sm mb-0"><?php echo $usuario["email"] ?> </p>
                      </td>
                      <td>
                        <p class="text-sm mb-0"><?php echo $usuario["viajero_tipo"] ?> </p>
                      </td>
                      <td>
                        <p class="text-sm mb-0"><?php echo $usuario["tipo"] ?> </p>
                      </td>
                      <td class="text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                          <a href="deudas.php?usuarioId=<?php echo $usuario[$idNombre]; ?>">
                              <u><?php echo $usuario["cantidad_deudas"] ?></u>
                          </a>
                        </span>
                      </td>
                      <td class="text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                          <a href="pagos.php?usuarioId=<?php echo $usuario[$idNombre]; ?>">
                              <u><?php echo $usuario["cantidad_pagos"] ?></u>
                          </a>
                        </span>
                      </td>
                      <td class="text-center">
                        <span id="badge-<?php echo $usuario[$idNombre]; ?>" class="badge badge-sm habilitado-checkbox 
                            <?php echo ($usuario["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                            <?php echo ($usuario["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="usuarios_editar.php?<?php echo $idNombre ?>=<?php echo $usuario[$idNombre] ?>">
                          <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                            Editar
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
    .imagen-circular {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin-top: -2px;

    }
  </style>
</body>

</html>