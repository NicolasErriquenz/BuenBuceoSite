<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "pagos_subrubros";
  $idNombre = "pagosSubrubroId";
  

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editar" ) {
    editarSubrubroPago($_POST, $_GET);
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "alta" ) {
    altaSubrubroPago($_POST, $_GET);
  }
  
  if( isset($_GET["pagosSubrubroId"]) ){
    $title = "Editar subrubro";
    $subtitle = "Podés editar el subrubro desde aquí";
    $action = "editar";
    $subrubro = getItem($tabla, $idNombre, $_GET[$idNombre]);

  }else{
    $title = "Alta subrubro";
    $subtitle = "Podés dar de alta un subrubro desde aquí";
    $action = "alta";
  }

  $rubrosAlfabeticos = true;
  $rubros = getRubrosPagos($rubrosAlfabeticos);
  $goBackLink = "pagos_subrubros.php";

  if(isset($_GET["pagosRubrosId"])){
    $goBackLink = "pagos_subrubros.php?pagosRubrosId=".$_GET["pagosRubrosId"].conservarQueryString();
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
                <h6 class="float-start"><?php echo $title ?></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <form action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <?php if(isset($subrubro[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>" class="form-control-label"><?php echo $idNombre ?></label>
                          <input id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" type="text" 
                                 value="<?php echo isset($subrubro[$idNombre]) ? $subrubro[$idNombre] : ''; ?>" 
                                 disabled class="form-control">
                        </div>
                        <?php } ?>
                        
                        <div class="form-group">
                          <label for="rubro" class="form-control-label">Rubro</label>
                          <select id="rubro" name="pagosRubrosId" class="form-control">
                            <option value="" selected disabled>Seleccione un rubro</option>
                            <?php foreach ($rubros as $rubro): ?>
                            <option value="<?php echo $rubro['pagosRubroId']; ?>" 
                                    <?php echo (isset($subrubro['pagosRubrosId']) && $subrubro['pagosRubrosId'] == $rubro['pagosRubroId']) || 
                                           (isset($_GET['pagosRubrosId']) && $_GET['pagosRubrosId'] == $rubro['pagosRubroId']) ? "selected" : ""; ?>>
                              <?php echo $rubro['rubro']; ?>
                            </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        
                        <div class="form-group">
                          <label for="subrubro" class="form-control-label">Subrubro</label>
                          <input id="subrubro" name="subrubro" type="text" 
                                 value="<?php echo isset($subrubro['subrubro']) ? $subrubro['subrubro'] : ''; ?>" 
                                 class="form-control">
                        </div>
                        
                        <!-- 
                        <div class="form-group">
                          <label for="comentario" class="form-control-label">Comentario</label>
                          <textarea id="comentario" name="comentario"><?php echo isset($subrubro['comentario']) ? $subrubro['comentario'] : ''; ?></textarea>
                        </div>
                        -->
                        
                        <div class="form-check form-switch">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" 
                               class="habilitado-checkbox"
                               name="habilitado_sys"
                               data-id="<?php echo isset($subrubro['pagosRubroId']) ? $subrubro['pagosRubroId'] : ''; ?>"
                               <?php echo isset($subrubro['habilitado_sys']) && $subrubro["habilitado_sys"] == 1 ? "checked" : "" ?>
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