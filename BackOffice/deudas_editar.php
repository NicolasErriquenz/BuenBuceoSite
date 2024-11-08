<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "deudas";
  $idNombre = "deudaId";
  $errores = array();
  $redirect = "deudas.php";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
      // Validación de campos
      if (empty($_POST['pagosRubroId']))  $errores[] = 'Categoría es requerida';
      if (empty($_POST['monedaId']))  $errores[] = 'Moneda es requerido';
      if (empty($_POST['usuarioId']))  $errores[] = 'Usuario es requerido';
      if (empty($_POST['deuda']))  $errores[] = 'Monto es requerido';
      
      // Validación de formato
      if (!filter_var($_POST['deuda'], FILTER_VALIDATE_FLOAT))  $errores[] = 'Monto debe ser un número';

      if (count($errores) > 0) {
        $respuesta = array('estado' => 'error', 'errores' => $errores);
      } else {
        $respuesta = array('estado' => 'ok');
      }
      
      if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
        echo json_encode($respuesta);
      else{
        if(isset($_GET["deudaId"]) && !empty($_GET["deudaId"]))
          echo editarDeuda($_POST);
        else
          echo altaDeuda($_POST);
      } 

      die();
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

   if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == "buscar" ) {
    echo buscarUsuarios($_GET["q"]);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == "cotizacion" ) {
    echo getCotizacion($_GET["monedaId"]);
    die();
  }

  
  $deuda = [];
  $deuda["habilitado_sys"] = 1;
  $usuario = null;

  if( isset($_GET[$idNombre]) ){
    $title = "Editar deuda";
    $subtitle = "Podés editar la deuda desde acá";
    $action = "editar";
    $deuda = getItem($tabla, $idNombre, $_GET[$idNombre]);

    if($deuda["usuarioId"] != null)
      $usuario = getItem("usuarios", "usuarioId", $deuda["usuarioId"]);
  }else{
    $title = "Alta deuda";
    $subtitle = "Podés dar de alta una deuda desde acá";
    $action = "alta";
  }

  $goBackLink = "deudas.php";
  $rubros = getRubrosPagos();
  
  $monedas = getMonedas();
  $cotizacion = "";
  $mediosPago = getMediosDePago();
  
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

                        <?php if(isset($deuda[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>">Deuda ID</label>
                          <input type="text" id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" class="form-control" 
                                 value="<?php echo isset($deuda[$idNombre]) ? $deuda[$idNombre] : ''; ?>" 
                                 disabled>
                        </div>
                        <?php } ?>

                        <p class="text-uppercase text-sm">Categorías</p>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label for="rubro" class="form-control-label">Categoría</label>
                              <select id="pagosRubroId" name="pagosRubroId" class="form-control custom-select">
                                <option value="" selected disabled>Seleccione una categoría</option>
                                <?php foreach ($rubros as $rubro): ?>
                                <option value="<?php echo $rubro['pagosRubroId']; ?>" 
                                        <?php echo (isset($deuda['pagosRubroId']) && $deuda['pagosRubroId'] == $rubro['pagosRubroId']) ? "selected" : ""; ?>>
                                  <?php echo $rubro['rubro']; ?>
                                </option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <hr class="horizontal dark">
                        
                        <p class="text-uppercase text-sm">Datos generales</p>

                        <div class="row align-items-center">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Monto</label>
                              <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                <input type="number" step="any" 
                                       id="deuda" name="deuda" 
                                       placeholder="00.00"
                                       value="<?php echo isset($deuda['deuda']) ? $deuda['deuda'] : ''; ?>" 
                                       class="form-control" style="text-align: right;">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label" style="display: block;">Moneda</label>
                              <div class="btn-group btn-group-toggle w-100" data-bs-toggle="buttons">
                                <?php foreach ($monedas as $moneda): ?>
                                <label class="btn w-100 <?php echo (isset($deuda['monedaId']) && $deuda['monedaId'] == $moneda['monedaId']) ? "active" : ($action == "editar" && $moneda['monedaId'] == 1 ? "active" : ""); ?>">
                                  <input type="radio" name="monedaId" value="<?php echo $moneda['monedaId']; ?>" <?php echo (isset($deuda['monedaId']) && $deuda['monedaId'] == $moneda['monedaId']) ? "checked" : ($action == "alta" && $moneda['monedaId'] == 1 ? "checked" : ""); ?>>
                                  <?php echo $moneda['moneda']; ?>
                                </label>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="form-control-label">Asignar deuda al usuario</label>
                            <div class="row">
                              <div class="col-md-9">
                                <input autocomplete="off" 
                                type="text" id="buscar" 
                                name="buscar" 
                                class="form-control" 
                                value="<?php echo $usuario != null ? $usuario["nombre"]." ".$usuario["apellido"]." (".$usuario["apodo"].") - ".$usuario["dni"] : ''?>"
                                placeholder="Ingrese al menos 1 caracter">
                              </div>
                              <div class="col-md-3">
                                <button id="deseleccionar" 
                                        class="btn btn-outline-secondary w-100" 
                                        <?php echo isset($usuario['usuarioId']) ? "" : 'disabled'; ?>>
                                  <i class="fas fa-times"></i> Deseleccionar
                                </button>
                              </div>
                            </div>
                            <div id="resultado" class="dropdown-menu dropdown-menu-left w-100"></div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="comentario">Comentario</label>
                          <textarea id="comentario" name="comentario" class="form-control"><?php echo isset($deuda['comentario']) ? $deuda['comentario'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-check form-switch">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" 
                               class="habilitado-checkbox"
                               name="habilitado_sys"
                               data-id="<?php echo isset($deuda['deudaId']) ? $deuda['deudaId'] : ''; ?>"
                               <?php echo $deuda["habilitado_sys"] == 1 ? "checked" : "" ?>
                               onclick="habilitadoCheckboxChange(this)">
                            Habilitado
                          </label>
                        </div>
                      </div>

                      <div class="card-footer d-flex justify-content-between">
                        <input type="hidden" name="action" value="<?php echo $action ?>">
                        <input type="hidden" name="usuarioId" id="usuarioId" value="<?php echo $usuario != null ? $usuario["usuarioId"] : ''?>">
                        <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
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

    $(document).ready(function() {
        
        $(document).on('click', '.dropdown-item', function() {
          var usuarioId = $(this).data('usuario-id');
          var texto = $(this).text();
          $('#buscar').val(texto);
          $('#resultado').hide();
          $("#usuarioId").val(usuarioId);
          // Aquí puedes agregar la lógica para seleccionar el usuario
          console.log('Usuario seleccionado: ', usuarioId, texto);

          $('#deseleccionar').prop("disabled", false);
          $('#buscar').prop("disabled", true);
        });

        $('#deseleccionar').click(function(){
          $('#buscar').prop("disabled", false);
          $('#deseleccionar').prop("disabled", true);
          $('#buscar').val("");
          $("#usuarioId").val("");
        });

        $('#buscar').on('keyup', function() {
          var q = $(this).val();
          if (q.length >= 1) {
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

        $('form').submit(function(e) {
          e.preventDefault();
          var datos = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: '',
            data: datos,
            dataType: 'json',
            success: function(respuesta) {
                // Formulario inválido, muestra errores en modal
                var errores = respuesta.errores;
                $('#ul_errores').empty();
                $.each(errores, function(index, error) {
                  $('#ul_errores').append('<li>' + error + '</li>');
                });
                $('#btn-modal-errores').click();
            },
            error: function(error){
              if(error.responseText == "ok")
                window.location.href = "<?php echo $redirect; ?>?success=true";
            }
          });
        });

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