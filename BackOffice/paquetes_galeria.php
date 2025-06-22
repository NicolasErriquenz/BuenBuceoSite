<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "paquetes_galeria";
  $idNombre = "paquetesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['paquetesId'])) {
     $errores = [];

    // Validaciones mínimas
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        $errores[] = 'Debe subir una imagen válida.';
    }

    if (!isset($_POST['paquetesId']) || empty($_POST['paquetesId'])) {
        $errores[] = 'ID del paquete no especificado.';
    }

    if (!isset($_POST['tipo'])) {
        $errores[] = 'Tipo de imagen no especificado.';
    }

    if (count($errores) > 0) {
        echo json_encode([
            'estado' => 'error_validacion',
            'errores' => $errores
        ]);
        exit;
    }

    // Si todo está OK, guardar
    $resultado = guardarGaleria($_POST, $_FILES['imagen']);

    echo json_encode($resultado);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'actualizar_estado_galeria') {
    $id = intval($_POST['id'] ?? 0);
    $tipoAccion = $_POST['tipoAccion'] ?? '';
    $estado = isset($_POST['estado']) ? intval($_POST['estado']) : null;

    if (!$id || !in_array($tipoAccion, ['activo', 'portada', 'destacada']) || $estado === null) {
        echo json_encode([
            'estado' => 'error_validacion',
            'mensaje' => 'Parámetros inválidos.'
        ]);
        exit;
    }

    $resultado = updateGaleriaTipo($id, $tipoAccion, $estado);

    echo json_encode($resultado);
    exit;
  }

  $paquete = [];
  $paquete["activo"] = 1;
  
  $usuarios = [];
  $tipopaqueteros = [];

  $paquete = getItem("paquetes", $idNombre, $_GET[$idNombre]);

  $title = "Editar imágenes del paquete ".strtoupper($paquete["titulo"]);
  $subtitle = "Podés editar la info del paquete";
  $action = "editar";
  $galeria = getGaleria($_GET[$idNombre]);

  $goBackLink = "paquetes.php";
  $redirect = "paquetes_galeria.php";
    
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
              
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      
                      <div class="card shadow mb-4">
                        <div class="card-body pt-3">
                          <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="<?php echo $idNombre ?>" value="<?php echo $_GET[$idNombre] ?>">

                            <div class="mb-3">
                              <label for="imagen" class="form-label"><i class="fas fa-image me-2"></i>Seleccionar imagen</label>
                              <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                              <label for="descripcion" class="form-label"><i class="fas fa-align-left me-2"></i>Descripción (opcional)</label>
                              <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Breve descripción">
                            </div>

                            <div class="mb-4">
                              <label for="tipo" class="form-label fw-bold">Tipo de Foto</label>
                              <select class="form-select" name="tipo" id="tipo" required onchange="actualizarLeyendaTipo()">
                                <option value="0" selected>Normal</option>
                                <option value="2">Destacada</option>
                                <option value="1">Portada</option>
                              </select>
                              <small id="leyenda-tipo" class="text-muted d-block mt-1">Se aceptan imágenes de cualquier tamaño.</small>
                            </div>

                            <div class="d-flex justify-content-end">
                              <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-1"></i>Guardar imagen
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>


                      <hr class="my-4" />

                      <div class="row mt-4">
                        <?php foreach ($galeria as $foto): ?>
                          <?php
                            $esPortada = $foto['tipo'] == 1;
                            $esDestacada = $foto['tipo'] == 2;
                            $esActiva = $foto['activo'] == 1;
                          ?>

                          <div class="col-md-3 mb-3 galeria-card" data-paqueteid="<?= $foto['paquetesId'] ?>" data-id="<?= $foto['id'] ?>">
                            <div class="card position-relative">
                              
                              <!-- Ribbon -->
                              <div class="position-absolute top-0 start-0 z-index-2">
                                
                              </div>

                              <button type="button"
                                class="btn btn-sm btn-outline-dark border-0 rounded-circle position-absolute top-0 end-0 m-2 p-1"
                                style="background-color: white; width: 24px; height: 24px;"
                                onclick="confirmarEliminar(<?php echo $foto['id']; ?>)">
                                <i class="fas fa-times small"></i>
                              </button>


                              <!-- Imagen -->
                              <img src="<?= RUTA_PAQUETES_GALERIA_DISPLAY . $foto['imagen'] ?>" class="card-img-top" alt="Imagen del paquete">

                              <!-- Contenido -->
                              <div class="card-body p-2">
                                <p class="mb-2"><?= $foto['descripcion'] ?: '<em>Sin descripción</em>' ?></p>

                                <!-- Switches -->
                                <div class="d-flex flex-column gap-1">

                                  <!-- Switch Activo -->
                                  <div class="form-check form-switch m-0">
                                    <input class="form-check-input switch-estado" type="checkbox"
                                      role="switch"
                                      <?= $esActiva ? 'checked' : '' ?>
                                      onchange="cambiarEstado(<?= $foto['id'] ?>, 'activo', this.checked)">
                                    <label class="form-check-label small">Activo</label>
                                  </div>

                                  <!-- Switch Portada -->
                                  <div class="form-check form-switch m-0">
                                    <input class="form-check-input switch-portada" type="checkbox"
                                      role="switch"
                                      <?= $esPortada ? 'checked' : '' ?>
                                      onchange="cambiarEstado(<?= $foto['id'] ?>, 'portada', this.checked)">
                                    <label class="form-check-label small">Portada</label>
                                  </div>

                                  <!-- Switch Destacada -->
                                  <div class="form-check form-switch m-0">
                                    <input class="form-check-input switch-destacada" type="checkbox"
                                      role="switch"
                                      <?= $esDestacada ? 'checked' : '' ?>
                                      onchange="cambiarEstado(<?= $foto['id'] ?>, 'destacada', this.checked)">
                                    <label class="form-check-label small">Destacada</label>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>



                      </div>

                    </div>
                    <div class="card-footer d-flex justify-content-between">
                      <input type="hidden" name="action" value="<?php echo $action ?>">
                      <a href="<?php echo $goBackLink ?>" class="btn bg-gradient-outline-danger btn-sm">
                        <i class="ni ni-bold-left"></i> Volver
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              
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
        <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Galería actualizada" : "Galería actualizada"; ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      actualizarRibbons(); // Genera ribbons iniciales según el estado de los switches
    });
    function confirmarEliminar(id) {
      if (confirm("¿Estás seguro de que querés eliminar esta imagen? Esta acción no se puede deshacer.")) {
        window.location.href = `eliminar_foto.php?id=${id}`;
      }
    }

    function cambiarEstado(id, tipoAccion, estado) {
  const formData = new FormData();
  formData.append('action', 'actualizar_estado_galeria');
  formData.append('id', id);
  formData.append('tipoAccion', tipoAccion);
  formData.append('estado', estado ? 1 : 0);

  fetch(window.location.href, {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.estado === 'ok') {

        const card = document.querySelector(`.galeria-card[data-id="${id}"]`);

        if (tipoAccion === 'activo' && !estado) {
          // Si se desactiva la imagen, apagar los otros switches
          if (card) {
            const switchPortada = card.querySelector('.switch-portada');
            const switchDestacada = card.querySelector('.switch-destacada');
            if (switchPortada) switchPortada.checked = false;
            if (switchDestacada) switchDestacada.checked = false;
          }

          actualizarRibbons(); // Limpiar posibles ribbons visuales
        }

        if (tipoAccion === 'portada' || tipoAccion === 'destacada') {
          document.querySelectorAll(`.galeria-card`).forEach(card => {
            const cardId = card.dataset.id;

            // Si no es la actual, desmarcar el switch del mismo tipo
            if (cardId != id) {
              const switchEl = card.querySelector(`.switch-${tipoAccion}`);
              if (switchEl) switchEl.checked = false;
            } else {
              // Si es la actual, desmarcar el otro tipo (no puede tener ambos)
              const opuesto = tipoAccion === 'portada' ? 'destacada' : 'portada';
              const otroSwitch = card.querySelector(`.switch-${opuesto}`);
              if (otroSwitch) otroSwitch.checked = false;
            }
          });

          actualizarRibbons(tipoAccion, id);
        }

      } else {
        alert(data.mensaje || 'Error inesperado');
      }
    })
    .catch(() => alert('Error de red'));
}



    function actualizarRibbons(tipo, idActivo) {
      document.querySelectorAll('.galeria-card').forEach(card => {
        const id = card.dataset.id;
        const ribbonExistente = card.querySelector('.galeria-ribbon');
        if (ribbonExistente) ribbonExistente.remove();

        const switchPortada = card.querySelector('.switch-portada');
        const switchDestacada = card.querySelector('.switch-destacada');

        if (switchPortada && switchPortada.checked) {
          card.querySelector('.card').insertAdjacentHTML('afterbegin', `
            <div class="position-absolute top-0 start-0 z-index-2 galeria-ribbon">
              <span class="badge bg-primary rounded-start rounded-bottom px-3 py-2">Portada</span>
            </div>
          `);
        } else if (switchDestacada && switchDestacada.checked) {
          card.querySelector('.card').insertAdjacentHTML('afterbegin', `
            <div class="position-absolute top-0 start-0 z-index-2 galeria-ribbon">
              <span class="badge bg-warning text-dark rounded-start rounded-bottom px-3 py-2">Destacada</span>
            </div>
          `);
        }
      });
    }

  </script>


  <script>
    function actualizarLeyendaTipo() {
      const tipo = document.getElementById('tipo').value;
      const leyenda = document.getElementById('leyenda-tipo');

      if (tipo == 1) {
        leyenda.innerText = '📐 Recomendado para portada: 2500x1700 px (horizontal)';
      } else if (tipo == 2) {
        leyenda.innerText = '📐 Recomendado para destacada: 1700x2560 px (vertical) Se usa para la galería del front';
      } else {
        leyenda.innerText = 'Se aceptan imágenes de cualquier tamaño.';
      }
    }
  </script>

  <script>

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
              window.location.href = "<?php echo $redirect; ?>?action=<?php echo $action ?>&success=true&paquetesId=<?php echo $_GET[$idNombre] ?>";
              
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