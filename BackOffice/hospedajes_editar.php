<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "hospedajes";
  $idNombre = "hospedajesId";
  $goBackLink = "hospedajes.php";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editar" ) {
    editarHospedaje($_POST, $_GET["hospedajesId"]);
    header("location:".$goBackLink."?success=true&action=editar");
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "alta" ) {
    altaHospedaje($_POST);
    header("location:".$goBackLink."?success=true&action=alta");
    die();
  }

  if( isset($_GET[$idNombre]) ){
    $title = "Editar hospedaje";
    $subtitle = "Podés editar el hospedaje";
    $action = "editar";
    $item = getItem($tabla, $idNombre, $_GET[$idNombre]);
  }else{
    $title = "Alta hospedaje";
    $subtitle = "Podés dar de alta un hospedaje";
    $action = "alta";
  }

  
  
  $paises = getPaises();
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
                        <?php if(isset($item[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>">Hospedaje ID</label>
                          <input type="text" id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" class="form-control" 
                                 value="<?php echo isset($item[$idNombre]) ? $item[$idNombre] : ''; ?>" 
                                 disabled>
                        </div>
                        <?php } ?>
                        
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="nombre">Nombre</label>
                              <input type="text" id="nombre" name="nombre" class="form-control" 
                                     value="<?php echo isset($item['nombre']) ? $item['nombre'] : ''; ?>">
                            </div>
                          </div>
                          <div class="col-6">
                             <div class="form-group">
                                <label for="estrellas">Estrellas</label>
                                <input type="number" step="0.1" id="estrellas" name="estrellas" class="form-control" 
                                       value="<?php echo isset($item['estrellas']) ? $item['estrellas'] : ''; ?>">
                              </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="direccion">Direccion</label>
                              <input type="text" id="direccion" name="direccion" class="form-control" 
                                     value="<?php echo isset($item['direccion']) ? $item['direccion'] : ''; ?>">
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-group">
                              <label for="paisId">Pais</label>
                              <select id="paisId" name="paisId" class="form-control">
                                <option value="" selected disabled>Seleccione un pais</option>
                                <?php foreach ($paises as $pais): ?>
                                <option value="<?php echo $pais['paisId']; ?>" 
                                        <?php echo (isset($item['paisId']) && $item['paisId'] == $pais['paisId']) ? "selected" : ""; ?>>
                                  <?php echo $pais['pais']; ?>
                                </option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        

                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                              <label for="telefono">Teléfonos</label>
                              <input type="text" id="telefono" name="telefono" class="form-control" 
                                     value="<?php echo isset($item['telefono']) ? $item['telefono'] : ''; ?>">
                            </div>
                          </div>
                          <div class="col-6">
                             <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" 
                                     value="<?php echo isset($item['email']) ? $item['email'] : ''; ?>">
                              </div>
                          </div>
                        </div>
                        
                       

                        <div class="form-group">
                          <label for="comentario">Comentario</label>
                          <textarea id="comentario" name="comentario" class="form-control"><?php echo isset($item['comentario']) ? $item['comentario'] : ''; ?></textarea>
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

    

    $(document).ready(function() {
        
      
    });


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