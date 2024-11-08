<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
    // Validación de campos
    $errores = array();
    if (!isset($_POST['paisId']) || empty($_POST['paisId']))  $errores[] = 'País es requerido';
    if (empty($_POST['fecha_inicio']))  $errores[] = 'Fecha de inicio es requerida';
    if (empty($_POST['fecha_fin']))  $errores[] = 'Fecha de fin es requerida';
    if (!empty($_POST['viaje_pdf']) && !filter_var($_POST['viaje_pdf'], FILTER_VALIDATE_URL))  $errores[] = 'URL del PDF inválida';
    //if (empty($_POST['descripcion']))  $errores[] = 'Descripción es requerida';

    // Validación de fechas
    if (strtotime($_POST['fecha_inicio']) >= strtotime($_POST['fecha_fin']))  $errores[] = 'Fecha de inicio debe ser anterior a la fecha de fin';

    if (count($errores) > 0) {
      $respuesta = array('estado' => 'error_validacion', 'errores' => $errores);
    } else {
      $respuesta = array('estado' => 'ok');
    }
    
    if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
      echo json_encode($respuesta);
    else{

      if(isset($_GET[$idNombre]) && !empty($_GET["viajesId"]))
        echo editarViaje($_POST, $_GET[$idNombre]);
      else{
        echo altaViaje($_POST);
      }
    }

    die();
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarArchivo" ) {
    eliminarArchivo($_POST[$idNombre]);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "agregarRedSocial" ) {
    echo guardarRedSocial($_POST);
    die();
  }

  
  $viaje = [];
  $viaje["activo"] = 1;
  
  $usuarios = [];
  $tipoViajeros = [];

  if( isset($_GET[$idNombre]) ){
    $title = "Editar viaje";
    $subtitle = "Podés editar la info del viaje";
    $action = "editar";
    $viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);
  }else{
    $title = "Alta de viaje";
    $subtitle = "Podés dar de alta un viaje";
    $action = "alta";
  }

  $redirect = "viajes.php";
  $goBackLink = "viajes.php";
  $paises = getPaises();

?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<?php include("includes/head.php"); ?>

<body class="g-sidenav-show   bg-gray-100">
  
  <?php echo $HEADER_IMAGEN ?>
  
  <?php include("includes/menu.php"); ?>

  <div class="main-content position-relative max-height-vh-100 h-100">
    <!-- Navbar -->
    
    <?php include("includes/navbar.php"); ?>
    
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
                        <?php if(isset($viaje[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>" class="form-control-label"><?php echo $idNombre ?></label>
                          <input id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" type="text" 
                                 value="<?php echo isset($viaje[$idNombre]) ? $viaje[$idNombre] : ''; ?>" 
                                 disabled class="form-control">
                        </div>
                        <?php } ?>
                        
                        
                        <div class="form-group">
                          <label for="paisId" class="form-control-label">País</label>
                          <select id="paisId" name="paisId" class="form-control">
                            <option value="" selected disabled>Seleccione un pais</option>
                            <?php foreach ($paises as $pais): ?>
                            <option value="<?php echo $pais['paisId']; ?>" 
                                    <?php echo (isset($viaje['paisId']) && $viaje['paisId'] == $pais['paisId']) ? "selected" : ""; ?>>
                              <?php echo $pais['pais']; ?>
                            </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha inicio</label>
                              <div class="input-group">
                                <input class="form-control" 
                                       type="date" 
                                       value="<?php echo isset($viaje['fecha_inicio']) ? date("Y-m-d", strtotime($viaje['fecha_inicio'])) : date("Y-m-d"); ?>" 
                                       id="fecha_inicio" name="fecha_inicio">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                              <label class="form-control-label">Fecha fin</label>
                              <div class="input-group">
                                <input class="form-control" 
                                       type="date" 
                                       value="<?php echo isset($viaje['fecha_fin']) ? date("Y-m-d", strtotime($viaje['fecha_fin'])) : date("Y-m-d"); ?>" 
                                       id="fecha_fin" name="fecha_fin">
                              </div>
                            </div>
                          </div>
                        </div>

                        
                        
                        <div class="form-group">
                          <label for="descripcion" class="form-control-label">Descripción</label>
                          <input class="form-control" type="text" name="descripcion" id="descripcion" value="<?php echo isset($viaje["descripcion"]) ? $viaje["descripcion"] : "" ?>">
                        </div>

                        <div id="archivo-existente" style="display:none;">
                          <a id="enlace-archivo" href="#" target="_blank">Ver archivo</a>
                          <button id="eliminar-archivo" class="btn btn-danger ">Eliminar archivo</button>
                        </div>
                        <?php
                        if ($action == 'editar' && !empty($viaje)) {
                          // Mostrar enlace al archivo existente y botón para eliminar
                          if ($viaje['viaje_pdf'] != '') {
                            ?>
                            <div class="form-group">
                              <label class="form-control-label">Archivo existente:</label><br>
                              <a href="_recursos/viajes_pdf/<?= $viaje['viaje_pdf'] ?>" target="_blank" class="ml-2">Ver archivo</a>
                                <i class="fas fa-times habilitado-checkbox" onclick="javascript:eliminarArchivo()"></i>
                            </div>
                            <?php
                          } else {
                            // Mostrar input para subir archivo
                            ?>
                            <div class="form-group">
                              <label class="form-control-label">Seleccionar archivo</label>
                              <div class="input-group">
                                <input type="file" 
                                       class="form-control" 
                                       id="viaje_pdf" 
                                       name="viaje_pdf" 
                                       accept="pdf/*">
                              </div>
                            </div>
                            <?php
                          }
                        } elseif ($action == 'alta') {
                          // Mostrar input para subir archivo
                          ?>
                          <div class="form-group">
                            <label class="form-control-label">Seleccionar archivo</label>
                            <div class="input-group">
                              <input type="file" 
                                     class="form-control" 
                                     id="viaje_pdf" 
                                     name="viaje_pdf" 
                                     accept="pdf/*">
                            </div>
                          </div>
                          <?php
                        }
                        ?>
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

  </div>

  <?php include("includes/scripts.php") ?>

  <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="fa fa-warning text-warning"></i>&nbsp;
          <h6 class="modal-title" id="modal-title-default">Errores de validación</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-group list-group-flush" id="ul_errores" style="padding-left: 20px;">
            <!-- Errores se mostrarán aquí -->
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-primary ml-auto" data-bs-dismiss="modal">ENTENDIDO</button>
        </div>
      </div>
    </div>
  </div>

  <button type="button" id="btn-modal-errores" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" style="display:none;">Default</button>

  <div id="toast" class="toast align-items-center text-white <?php echo ($_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" style="font-size: 18px;">
        <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Usuario creado!" : "Usuario actualizado!"; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

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

    <?php if ($action == 'editar' && !empty($viaje)): ?>
    function eliminarArchivo() {
      var viajesId = <?= $viaje[$idNombre] ?>; // Obtener el ID del viaje

      $.ajax({
        type: 'POST',
        url: '', // URL del archivo PHP que elimina el archivo
        data: {viajesId: viajesId, action:"eliminarArchivo"},
        beforeSend: function() {
          // Opcional: Mostrar cargando
          $('#eliminar-archivo').html('Eliminando...');
        },
        success: function(respuesta) {
          location.reload(true);
        },
        complete: function() {
          
        }
      });
    }
    <?php endif; ?>

    $(document).ready(function() {
        
      $('.habilitado-checkbox').click(function() {
          var id = $(this).attr('id').split('-')[1]; // Obtenemos el ID desde el atributo ID del span
          var habilitado = $(this).hasClass('bg-success') ? 0 : 1; // Toggle habilitado/deshabilitado

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
                  $(`#badge-${id}`).removeClass('bg-success bg-secondary')
                                   .addClass(habilitado == 1 ? 'bg-success' : 'bg-secondary')
                                   .text(habilitado == 1 ? 'HABILITADO' : 'DESACTIVADO');
              },
              error: function(xhr, status, error) {
                  console.error('Error al actualizar:', error);
              }
          });
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var datos = new FormData(form);

        // Obtener la extensión del archivo
        var archivo = datos.get('imagen');
        if (archivo !== null) {
          var extension = archivo.name.split('.').pop().toLowerCase();
          console.log(extension);
          // Validar extensión
          if (extension !== 'jpg' && extension !== 'jpeg' && extension !== "") {
            $('#ul_errores').html('Sólo se permiten imágenes .JPG y .JPEG');
            $('#btn-modal-errores').click();
            return false;
          }
        }

        $.ajax({
          type: 'POST',
          url: '',
          data: datos,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(respuesta) {
            console.log(respuesta);
            if(respuesta.estado == "ok"){
              window.location.href = "<?php echo $redirect; ?>?action=<?php echo $action ?>&success=true";
              
            }else if(respuesta.estado == "error"){
              $('#ul_errores').html(respuesta.mensaje);
              $('#btn-modal-errores').click();
            }else{
              // Formulario inválido, muestra errores en modal
              var errores = respuesta.errores;
              $('#ul_errores').empty();
              $.each(errores, function(index, error) {
                $('#ul_errores').append('<li>' + error + '</li>');
              });
              $('#btn-modal-errores').click();  
            }
            
          },
          error: function(error){
            
            if(error == "Error"){
              $('#ul_errores').html('Error al insertar usuario');
              $('#btn-modal-errores').click();
            }
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
  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>