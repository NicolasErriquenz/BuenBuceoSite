<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "deuda_tipo";
  $idNombre = "deudaTipoId";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editar" ) {
    editarTipoDeuda($_POST, $_GET);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "alta" ) {
    altaTipoDeuda($_POST);
  }

  if( isset($_GET[$idNombre]) ){
    $title = "Editar tipo de deuda";
    $subtitle = "Podés editar el tipo de deuda desde aquí";
    $action = "editar";
    $tipoDeuda = getItem($tabla, $idNombre, $_GET[$idNombre]);
  }else{
    $title = "Alta tipo de deuda";
    $subtitle = "Podés dar de alta un tipo de deuda desde aquí";
    $action = "alta";
  }

  $goBackLink = "deudaTipo_listado.php";
  
  // if(isset($_GET["ref"])){
  //   $goBackLink = "pagos_subrubros.php";
  // }
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
                <h6 class="float-start"><?php echo $title ?></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <form action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <?php if(isset($tipoDeuda[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="pagosRubroId">Tipo deuda ID</label>
                          <input type="text" id="pagosRubroId" name="pagosRubroId" class="form-control" 
                                 value="<?php echo isset($tipoDeuda[$idNombre]) ? $tipoDeuda[$idNombre] : ''; ?>" 
                                 disabled>
                        </div>
                        <?php } ?>
                        
                        <div class="form-group">
                          <label for="deuda">Descripción</label>
                          <input type="text" id="deuda" name="deuda" class="form-control" 
                                 value="<?php echo isset($tipoDeuda['deuda']) ? $tipoDeuda['deuda'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                          <label for="comentario">Comentario</label>
                          <textarea id="comentario" name="comentario" class="form-control"><?php echo isset($tipoDeuda['comentario']) ? $tipoDeuda['comentario'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-check form-switch">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" 
                               class="habilitado-checkbox"
                               name="habilitado_sys"
                               data-id="<?php echo isset($tipoDeuda[$idNombre]) ? $tipoDeuda[$idNombre] : ''; ?>"
                               <?php echo $tipoDeuda["habilitado_sys"] == 1 ? "checked" : "" ?>
                               onclick="habilitadoCheckboxChange(this)">
                            Habilitado
                          </label>
                        </div>
                      </div>
                      <div class="card-footer d-flex justify-content-between">
                        <input type="hidden" name="action" value="<?php echo $action ?>">
                        <a href="<?php echo $goBackLink ?>" class="btn bg-gradient-outline-danger btn-sm">
                          <i class="ni ni-bold-left"></i> Volver
                        </a>
                        <button type="submit" class="btn btn-sm bg-gradient-primary">
                          <i class="ni ni-check-bold"></i> Guardar
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <?php include("includes/footer.php") ?>

    </div>
  </main>
  
  <?php include("includes/scripts.php") ?>

  <script>
    function habilitadoCheckboxChange(checkbox) {
        var id = $(checkbox).data('id');
        var habilitado = $(checkbox).is(':checked') ? 1 : 0;
        console.log(id, habilitado);
        $.ajax({
            url: '', // URL del mismo archivo PHP
            type: 'POST',
            data: {
                action: "actualizar",
                id: id,
                habilitado: habilitado,
                tabla: "<?php echo $tabla ?>"
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar:', error);
            }
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    form.submit();
                }
            });
        });
    });

  </script>

</body>

</html>