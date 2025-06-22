<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "paquetes";
  $idNombre = "paquetesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
    // Validación de campos
    $errores = array();
    if (!isset($_POST['titulo']) || empty($_POST['titulo']))  $errores[] = 'Título es requerido';
    if (!isset($_POST['continentesId']) || empty($_POST['continentesId']))  $errores[] = 'Continente es requerido';
    if (!isset($_POST['pais']) || empty($_POST['pais']))  $errores[] = 'País es requerido';
    if (empty($_POST['fecha_inicio']))  $errores[] = 'Fecha de inicio es requerida';
    if (empty($_POST['fecha_fin']))  $errores[] = 'Fecha de fin es requerida';
    if (!isset($_POST['precio']) || empty($_POST['precio']))  $errores[] = 'Precio es requerido';
    if (!isset($_POST['monedaId']) || empty($_POST['monedaId']))  $errores[] = 'Moneda es requerida';
    if (empty($_POST['descripcion']))  $errores[] = 'Descripción es requerida';
    
    // Validación de fechas
    if (strtotime($_POST['fecha_inicio']) >= strtotime($_POST['fecha_fin']))  $errores[] = 'Fecha de inicio debe ser anterior a la fecha de fin';
    
    // Validación de precio
    if (!is_numeric($_POST['precio']) || $_POST['precio'] <= 0)  $errores[] = 'El precio debe ser un número mayor a 0';
    
    if (count($errores) > 0) {
        $respuesta = array('estado' => 'error_validacion', 'errores' => $errores);
    } else {
        $respuesta = array('estado' => 'ok');
    }
    
    if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
        echo json_encode($respuesta);
    else{
        if(isset($_GET[$idNombre]) && !empty($_GET[$idNombre]))
          $resultado = editarPaquete($_POST, $_GET[$idNombre]);
        else{
          $resultado = altaPaquete($_POST);
        }
        echo json_encode($resultado);
    }
    die();
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }


  $paquete = [];
  $paquete["activo"] = 1;
  
  $usuarios = [];
  $tipopaqueteros = [];

  if( isset($_GET[$idNombre]) ){
    $title = "Editar paquete";
    $subtitle = "Podés editar la info del paquete";
    $action = "editar";
    $paquete = getItem($tabla, $idNombre, $_GET[$idNombre]);
  }else{
    $title = "Alta de paquete";
    $subtitle = "Podés dar de alta un paquete";
    $action = "alta";
  }

  $redirect = "paquetes.php";
  $goBackLink = "paquetes.php";
  $paises = getPaises();
  $monedas = getMonedas();
  $continentes = getContinentes();
  $nombrePais = isset($paquete['paisId']) 
    ? ($paises[array_search((string)$paquete['paisId'], array_column($paises, 'paisId'))])['pais'] ?? '' 
    : '';
    
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">

<?php include("includes/head.php"); ?>

<body class="g-sidenav-show   bg-gray-100">
  
  <!-- Place the first <script> tag in your HTML's <head> -->
  <script src="https://cdn.tiny.cloud/1/e4yugtdlvvgxxd579eqx5lkrggtzvr2p3207k1ic6xrgm8lp/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

  <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: [
        // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        // Your account includes a free trial of TinyMCE premium features
        // Try the most popular premium features until Jun 30, 2025:
        'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
      ],
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });
  </script>

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
                        <?php if(isset($paquete[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>" class="form-control-label"><?php echo $idNombre ?></label>
                          <input id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" type="text" 
                                 value="<?php echo isset($paquete[$idNombre]) ? $paquete[$idNombre] : ''; ?>" 
                                 disabled class="form-control">
                        </div>
                        <?php } ?>
                        
                        <div class="form-group">
                          <label for="titulo" class="form-control-label">Titulo</label>
                          <input id="titulo" name="titulo" type="text" 
                                 value="<?php echo isset($paquete["titulo"]) ? $paquete["titulo"] : ''; ?>" 
                                 class="form-control">
                        </div>

                        <div class="form-group">
                          <label for="continentesId" class="form-control-label">Continente</label>
                          <select id="continentesId" name="continentesId" class="form-control">
                            <option value="" selected disabled>Seleccione un continente</option>
                            <?php foreach ($continentes as $continente): ?>
                            <option value="<?php echo $continente['continentesId']; ?>" 
                                    <?php echo (isset($paquete['continentesId']) && $paquete['continentesId'] == $continente['continentesId']) ? "selected" : ""; ?>>
                              <?php echo $continente['continente']; ?>
                            </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="pais" class="form-control-label">País</label>
                          <input type="text" 
                                 id="pais" 
                                 name="pais" 
                                 class="form-control" 
                                 list="lista-paises" 
                                 placeholder="Ingrese un país"
                                 value="<?php echo isset($nombrePais) ? $nombrePais : ''; ?>">
                          
                          <datalist id="lista-paises">
                              <?php foreach ($paises as $pais): ?>
                                  <option value="<?php echo $pais['pais']; ?>">
                              <?php endforeach; ?>
                          </datalist>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha inicio</label>
                              <div class="input-group">
                                <input class="form-control" 
                                       type="date" 
                                       value="<?php echo isset($paquete['fecha_inicio']) ? date("Y-m-d", strtotime($paquete['fecha_inicio'])) : date("Y-m-d"); ?>" 
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
                                       value="<?php echo isset($paquete['fecha_fin']) ? date("Y-m-d", strtotime($paquete['fecha_fin'])) : date("Y-m-d", strtotime('+1 day')); ?>"
                                       id="fecha_fin" name="fecha_fin">
                              </div>
                            </div>
                          </div>
                        </div>

                        
                        
                        <div class="form-group">
                            <label for="descripcion" class="form-control-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="8">
                                <?php echo isset($paquete["descripcion"]) ? htmlspecialchars($paquete["descripcion"]) : ""; ?>
                            </textarea>
                        </div>

                        <div class="row align-items-center">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Valor</label>
                              <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                <input type="number" step="any" 
                                       id="precio" name="precio" 
                                       placeholder="00.00"
                                       value="<?php echo isset($paquete['precio']) ? $paquete['precio'] : ''; ?>" 
                                       class="form-control" style="text-align: right;">
                              </div>
                            </div>
                          </div>

                         <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-control-label" style="display: block;">Moneda</label>
                              <div class="btn-group btn-group-toggle w-100" data-bs-toggle="buttons">
                                  <?php foreach ($monedas as $moneda): ?>
                                  <label class="btn w-100 <?php echo (isset($paquete['monedaId']) && $paquete['monedaId'] == $moneda['monedaId']) ? "active" : ($action == "alta" && $moneda['monedaId'] == 3 ? "active" : ""); ?>">
                                      <input type="radio" name="monedaId" value="<?php echo $moneda['monedaId']; ?>" <?php echo (isset($paquete['monedaId']) && $paquete['monedaId'] == $moneda['monedaId']) ? "checked" : ($action == "alta" && $moneda['monedaId'] == 3 ? "checked" : ""); ?>>
                                      <?php echo $moneda['moneda']; ?>
                                  </label>
                                  <?php endforeach; ?>
                              </div>
                          </div>
                        </div>

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

  <div id="toast" class="toast align-items-center text-white <?php echo (isset($_GET["action"]) && $_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" style="font-size: 18px;">
        <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Usuario creado!" : "Usuario actualizado!"; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <script type="text/javascript">
    
    document.getElementById('fecha_inicio').addEventListener('change', function() {
      var fechaInicio = new Date(this.value);
      var fechaMinFin = new Date(fechaInicio);
      fechaMinFin.setDate(fechaInicio.getDate() + 1);
      
      // Formatear fecha para el atributo min del input
      var minFin = fechaMinFin.toISOString().split('T')[0];
      
      var fechaFinInput = document.getElementById('fecha_fin');
      fechaFinInput.min = minFin;
      
      // Si la fecha fin es menor que la nueva fecha mínima, actualizarla
      if(fechaFinInput.value < minFin) {
          fechaFinInput.value = minFin;
      }
    });

    // Establecer el mínimo inicial al cargar la página
    window.addEventListener('load', function() {
        var fechaInicio = new Date(document.getElementById('fecha_inicio').value);
        var fechaMinFin = new Date(fechaInicio);
        fechaMinFin.setDate(fechaInicio.getDate() + 1);
        document.getElementById('fecha_fin').min = fechaMinFin.toISOString().split('T')[0];
    });
  </script>

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

    <?php if ($action == 'editar' && !empty($paquete)): ?>
    function eliminarArchivo() {
      var paquetesId = <?= $paquete[$idNombre] ?>; // Obtener el ID del paquete

      $.ajax({
        type: 'POST',
        url: '', // URL del archivo PHP que elimina el archivo
        data: {paquetesId: paquetesId, action:"eliminarArchivo"},
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