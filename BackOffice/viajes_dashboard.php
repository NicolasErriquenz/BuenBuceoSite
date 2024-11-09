<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == "buscar" ) {
    echo buscarUsuarios($_GET["q"]);
    die();
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "agregarViajero" ) {
    
    echo altaViajero($_POST);
    die();
  }
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateActivo($_POST["id"], $_POST["activo"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
    // Validación de campos
    if (empty($_POST['nombre']))  $errores[] = 'Nombre es requerido';
    // if (empty($_POST['apellido']))  $errores[] = 'Apellido es requerido';
    if (empty($_POST['email']))  $errores[] = 'Email es requerido';
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  $errores[] = 'Email inválido';
    // if (empty($_POST['dni']))  $errores[] = 'DNI es requerido';
    // if (!is_numeric($_POST['dni']))  $errores[] = 'DNI debe ser un número';
    // if (empty($_POST['fecha_nacimiento']))  $errores[] = 'Fecha de nacimiento es requerido';
    
    // Validación de formato
    // if (!empty($_POST['paisId']) && !is_numeric($_POST['paisId']))  $errores[] = 'País Id debe ser un número';
    // if (!empty($_POST['sexoId']) && !is_numeric($_POST['sexoId']))  $errores[] = 'Sexo Id debe ser un número';
    // if (!empty($_POST['habilitado_sys']) && !is_numeric($_POST['habilitado_sys']))  $errores[] = 'Habilitado sys debe ser un número';

    if (count($errores) > 0) {
      $respuesta = array('estado' => 'error_validacion', 'errores' => $errores);
    } else {
      $respuesta = array('estado' => 'ok');
    }
    
    if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
      echo json_encode($respuesta);
    else{

      if(isset($_POST["usuarioId"]) && !empty($_POST["usuarioId"]))
        echo editarUsuario($_POST);
      else
        echo altaUsuario($_POST);
    }

    die();
  }


  $viaje = [];
  $viaje["activo"] = 1;
  
  $usuarios = [];
  $tipoViajeros = [];

  $title = "Editar viaje";
  $subtitle = "Podés editar la info del viaje";
  $action = "editar";

  $viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);
  $viajeros = getViajesUsuarios($viaje[$idNombre]);
  $viajesHospedajes = getViajesHospedajes($viaje[$idNombre]);
  $redirect = "viajes.php";
  $paises = getPaises();

  $viajerosTipos = getViajesViajeroTipo();

  $paisNombre = getPais($viaje['paisId']);
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
    
    <input type="hidden" name="action" value="<?php echo $action ?>">
    <input type="hidden" name="<?php echo $idNombre ?>" id="<?php echo $idNombre ?>" value="<?php echo $usuario[$idNombre] ?? null ?>">
    <div class="card shadow-lg mx-4" style="margin-top: 3rem !important;">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="_recursos/profile_pics/vuelo.jpg" alt="Perfil" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?php echo $paisNombre ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
                <?php echo $viaje["anio"] ?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-end">
            <span id="badge-<?php echo $viaje[$idNombre]; ?>" class="badge habilitado-checkbox 
            <?php echo ($viaje["activo"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>" 
            style="font-size: 15px; padding: 10px 20px; border-radius: 10px;margin-right: 50px;">
              <?php echo ($viaje["activo"] == 1) ? 'ACTIVO' : 'FINALIZADO'; ?>
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-4">
          
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <p class="mb-0">Editar info</p>
                  <div class="d-flex align-items-center">
                    <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                      <i class="ni ni-bold-left"></i> Volver
                    </a>
                    <button class="btn bg-gradient-primary btn-sm ms-2" type="submit"><span class="fa fa-save"></span></button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <p class="text-uppercase text-sm">Información del viaje</p>
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="sexoId" class="form-control-label">País</label>
                      <select id="sexoId" name="sexoId" class="form-control">
                        <option value="" selected disabled>Seleccione un pais</option>
                        <?php foreach ($paises as $pais): ?>
                        <option value="<?php echo $pais['paisId']; ?>" 
                                <?php echo (isset($viaje['paisId']) && $viaje['paisId'] == $pais['paisId']) ? "selected" : ""; ?>>
                          <?php echo $pais['pais']; ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Fecha inicio</label>
                      <div class="input-group">
                        <input class="form-control" 
                               type="date" 
                               value="<?php echo isset($pago['fecha']) ? date("Y-m-d", strtotime($pago['fecha'])) : date("Y-m-d"); ?>" 
                               id="fecha" name="fecha">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-control-label">Fecha fin</label>
                      <div class="input-group">
                        <input class="form-control" 
                               type="date" 
                               value="<?php echo isset($pago['fecha']) ? date("Y-m-d", strtotime($pago['fecha'])) : date("Y-m-d"); ?>" 
                               id="fecha" name="fecha">
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="comentario" class="form-control-label">Descripción</label>
                      <input class="form-control" type="text" name="comentario" id="comentario" value="<?php echo isset($usuario["comentario"]) ? $usuario["comentario"] : "" ?>">
                    </div>
                  </div>

                </div>
                
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Archivos</p>
                
                <div class="row">
                   
                </div>

                
                <div class="row">
                  <div class="col-md-12">
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
                    <button type="button" id="agregar_red_social" class="btn btn-primary">Agregar archivo</button>
                  </div>
                </div>
              </div>
            </div>
          
        </div>

        <div class="col-md-8">

          <div class="card mb-4">
            <div class="card-header ">
              <div class="row">
                <div class="col">
                  <h6 class="float-start">ADMINISTRAR VIAJEROS (<?php echo count($viajeros) ?>)</h6>
                  <div class="float-end">
                    <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-form">
                        <i class="ni ni-fat-add"></i> AGREGAR VIAJERO
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="custom-scroll-container">
                    <div class="table-responsive custom-pagination" style="margin: 0px !important;">
                      <table class="table mb-0 dataTable" id="tableDataTables">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Viajero</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deudas</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pagos</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habilitado</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($viajeros as $item): ?>
                          <tr>
                            <td>
                              <div class="">
                                <?php echo $item["viajesUsuariosId"] ?>
                              </div>
                            </td>
                            <td>
                              <p class="text-sm font-weight-bold mb-0"><?php echo $item["usuario"]["nombre"] ?> <?php echo $item["usuario"]["apellido"] ?> (<?php echo $item["usuario"]["apodo"] ?>)</p>
                            </td>
                            <td class="text-center">
                              <span class="text-secondary text-xs font-weight-bold">
                                <strong><?php echo $item["viajeroTipo"]["viajero_tipo"] ?></strong>
                              </span>
                            </td>
                            <td class="text-center">
                              -
                            </td>
                            <td class="text-center">
                              -
                            </td>
                            <td class="text-center">
                              <span id="badge-<?php echo $item["viajesUsuariosId"]; ?>" class="badge badge-sm habilitado-checkbox 
                                  <?php echo ($item["habilitado_sys"] == 1) ? 'bg-gradient-success' : 'bg-gradient-secondary'; ?>">
                                  <?php echo ($item["habilitado_sys"] == 1) ? 'Online' : 'Offline'; ?>
                              </span>
                            </td>
                            <td class="align-middle text-center">
                              <a href="pagos_subrubros_editar.php?<?php echo $idNombre ?>=<?php echo $subrubro[$idNombre] ?>">
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

          <div class="card mb-4">
            <div class="card-header ">
              <div class="row">
                <div class="col">
                  <h6 class="float-start">HOSPEDAJES (<?php echo count($viajesHospedajes) ?>)</h6>
                  <div class="float-end">
                    <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-form">
                        <i class="ni ni-fat-add"></i> AGREGAR HOSPEDAJE
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <div class="custom-scroll-container">
                    <div class="table-responsive custom-pagination" style="margin: 0px !important;">
                      <table class="table mb-0 dataTable" id="tableDataTables">
                        <thead>
                          <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tarifas</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Habitaciones</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuarios</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($viajesHospedajes as $item): ?>
                          <tr>
                            <td>
                              <div class="">
                                <?php echo $item["viajesHospedajesId"] ?>
                              </div>
                            </td>
                            <td>
                              <p class="text-sm font-weight-bold mb-0"><?php echo $item["hospedaje"] ?></p>
                            </td>
                            <td class="text-center">
                              <a href="hospedajes_tarifas.php?hospedajesId=<?php echo $item["hospedajesId"] ?>">
                                <p class="text-sm font-weight-bold mb-0"><?php echo $item["tarifas_cargadas"] ?></p>
                              </a>
                            </td>
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0"><?php echo $item["habitaciones_creadas"] ?></p>
                            </td>
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0"><?php echo $item["usuarios_asignados"] ?></p>
                            </td>
                            <td class="align-middle text-center">
                              <a href="viajes_habitaciones_editar.php?viajesHospedajesId=<?php echo $item["viajesHospedajesId"] ?>">
                                <button class="btn btn-icon btn-2 btn-sm btn-outline-dark mb-0 ajuste_boton" type="button">
                                  <span class="btn-inner--icon"><i class="ni ni-ungroup"></i> Habitaciones</span>
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

      
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="card card-plain">
              <div class="card-header pb-0 text-left">
                <h3 class="font-weight-bolder text-info text-gradient">Agregar viajero!</h3>
              </div>
              <div class="card-body">
                <form role="form text-left" method="post" action"" id="formNuevoViajero>
                  <input type="hidden" value="agregarViajero" name="action">
                  <div class="form-group">
                    <label class="form-control-label">Usuario</label>
                    <div class="row">
                      <div class="col-md-9">
                        <input type="hidden" name="usuarioId">
                        <input autocomplete="off" 
                              type="text" 
                              id="buscar" 
                              name="buscar" 
                              class="form-control" 
                              value=""
                              placeholder="Ingrese al menos 3 caracteres">
                      </div>
                      <div class="col-md-3">
                        <button id="deseleccionar" 
                                class="btn btn-outline-secondary w-100" 
                                <?php echo !isset($usuario["usuarioId"]) ? "disabled" : ''; ?>>
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div id="resultado" class="dropdown-menu dropdown-menu-left"></div>
                  </div>
                  <div class="form-group">
                    <label for="viajeroTipoId" class="form-control-label">País</label>
                    <select id="viajeroTipoId" name="viajeroTipoId" class="form-control">
                      <option value="" selected disabled>Elegí un tipo de viajero</option>
                        <?php foreach ($viajerosTipos as $item): ?>
                        <option value="<?php echo $item['viajeroTipoId']; ?>">
                          <?php echo $item['viajero_tipo']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="row">
                    <div class="text-center alert alert-danger fade" id="error_div">
                      <span class="alert-icon"><i class="fa fa-warning"></i></span>
                      <span id="error-text"></span>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="button" onclick="javascript:validarFormNuevoViajero()" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">GUARDAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
    var texto;
    var usuarioId;
    function validarFormNuevoViajero(){


      if(!usuarioId || usuarioId == undefined){
        var error = 'Hay que seleccionar un viajero'; // reemplaza con el mensaje de error real
      }
      
      var viajeroTipoId = $("#viajeroTipoId").val();
      
      if(!viajeroTipoId || viajeroTipoId == undefined){
        var error = 'Hay que seleccionar el tipo de viajero"'; // reemplaza con el mensaje de error real
      }

      if (error) {
        $('#error_div').removeClass('fade').addClass('show');
        $('#error-text').text(error);
        return;
      } else {
        $('#error_div').removeClass('show').addClass('fade');
      }


      $('#deseleccionar').prop("disabled", false);
      $('#buscar').prop("disabled", true);
      $('#resultado').hide();

      $.ajax({
        type: 'POST',
        url: '',
        data: {
          usuarioId: usuarioId, 
          action:"agregarViajero",
          viajesId:<?= $viaje[$idNombre] ?>,
          viajeroTipoId:viajeroTipoId,
          habilitado_sys:1
        },
        dataType: 'json',
        success: function(data) {
          location.reload();
        }
      });

    }

    $('#deseleccionar').click(function(){
        $('#buscar').prop("disabled", false);
        $('#deseleccionar').prop("disabled", true);
        $('#buscar').val("");
        usuarioId = null;
        $("#viajeroTipoId").val("");
        $('#deudaId').empty();
      });

    $(document).ready(function() {
      $(document).on('click', '.dropdown-item', function() {
        usuarioId = $(this).data('usuario-id');
        var texto = $(this).text();
        var viajeroTipoId = $("#viajeroTipoId").val();

        $('#buscar').val(texto);
        $('#resultado').hide();

          console.log('Usuario seleccionado: ', usuarioId, texto);

          $('#deseleccionar').prop("disabled", false);
          $('#buscar').prop("disabled", true);

        

        
      });

      


      $('#buscar').on('keyup', function() {
        var q = $(this).val();
        if (q.length >= 3) {
          $.ajax({
            type: 'GET',
            url: '',
            data: {q: q, action:"buscar"},
            dataType: 'json',
            success: function(data) {
              $('#resultado').empty();
              $.each(data, function(index, value) {
                $('#resultado').append('<div class="dropdown-item" data-usuario-id="'+value.usuarioId+'">' + value.nombre + '</div>');
              });
              $('#resultado').show();
            }
          });
        } else {
          $('#resultado').hide();
        }
      });

      $('.habilitado-checkbox').click(function() {
         var id = $(this).attr('id').split('-')[1]; // Obtenemos el ID desde el atributo ID del span
          var activo = $(this).hasClass('bg-gradient-success') ? 0 : 1; // Toggle habilitado/deshabilitado

          $.ajax({
            url: '', 
            type: 'POST',
            data: {
              action: "actualizar",
              id: id,
              activo: activo,
              tabla: "<?php echo $tabla ?>"
            },
            success: function(response) {
              $(`#badge-${id}`).removeClass('bg-gradient-success bg-gradient-secondary')
                                .addClass(activo == 1 ? 'bg-gradient-success' : 'bg-gradient-secondary')
                                .text(activo == 1 ? 'ACTIVO' : 'INACTIVO');
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
        var extension = archivo.name.split('.').pop().toLowerCase();
        console.log(extension);
        // Validar extensión
        if (extension !== 'jpg' && extension !== 'jpeg' && extension !== "") {
          $('#ul_errores').html('Sólo se permiten imágenes .JPG y .JPEG');
          $('#btn-modal-errores').click();
          return false;
        }

        $.ajax({
          type: 'POST',
          url: 'usuarios_editar.php',
          data: datos,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(respuesta) {
            console.log(respuesta);
            if(respuesta.estado == "ok"){
              window.location.href = "<?php echo $redirect; ?>?action=<?php echo $action ?>&success=true&usuarioId="+respuesta.usuarioId;
              
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
            alert(error)
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

  </script>
  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>