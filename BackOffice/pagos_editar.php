<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "pagos";
  $idNombre = "pagoId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
      // Validación de campos
      if (empty($_POST['pagosRubroId']))  $errores[] = 'Rubro es requerido';
      if (empty($_POST['pagosSubrubroId']))  $errores[] = 'Subrubro es requerido';
      if (empty($_POST['pagoTransaccionTipoId']))  $errores[] = 'Tipo transacción es requerido';
      if (empty($_POST['fecha']))  $errores[] = 'Fecha es requerido';
      if (empty($_POST['monedaId']))  $errores[] = 'Moneda es requerido';
      if (!empty($_POST['monedaId']) && $_POST['monedaId'] != 1 && empty($_POST['cotizacion']))  $errores[] = 'Cotización es requerido';
      if (empty($_POST['monto']))  $errores[] = 'Monto es requerido';
      if (empty($_POST['medioPagoId']))  $errores[] = 'Medio de pago es requerido';
      
      // Validación de formato
      if (!filter_var($_POST['monto'], FILTER_VALIDATE_FLOAT))  $errores[] = 'Monto debe ser un número';

      if (count($errores) > 0) {
        $respuesta = array('estado' => 'error', 'errores' => $errores);
      } else {
        $respuesta = array('estado' => 'ok');
      }
      
      if(isset($respuesta["errores"]) && count($respuesta["errores"]) > 0)
        echo json_encode($respuesta);
      else
        altaPago($_POST);

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

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "getSubrubros" ) {
    echo getSubrubrosPagos(true, $_POST["pagosRubroId"], true);
    die();
  }

  
  $pago = [];
  $pago["habilitado_sys"] = 1;
  
  if( isset($_GET[$idNombre]) ){
    $title = "Editar pago";
    $subtitle = "Podés editar el pago desde aquí";
    $action = "editar";
    $pago = getItem($tabla, $idNombre, $_GET[$idNombre]);

  }else{
    $title = "Alta pago";
    $subtitle = "Podés dar de alta un pago desde aquí";
    $action = "alta";
  }

  $goBackLink = "pagos.php";
  $rubros = getRubrosPagos();
  $subrubros = getSubrubrosPagos();
  $transaccionTipos = getTransaccionTipos();
  $monedas = getMonedas();
  $cotizacion = "";
  //$cotizacion = 0;
  $mediosPago = getMediosDePago();
  // if(isset($_GET)){
  //   $goBackLink = "pagos_subrubros.php?pagosRubrosId=".$_GET["pagosRubrosId"].conservarQueryString();
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

                        <?php if(isset($pago[$idNombre])){ ?>
                        <div class="form-group">
                          <label for="<?php echo $idNombre ?>">Pagos Rubro ID</label>
                          <input type="text" id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" class="form-control" 
                                 value="<?php echo isset($pago[$idNombre]) ? $pago[$idNombre] : ''; ?>" 
                                 disabled>
                        </div>
                        <?php } ?>

                        <p class="text-uppercase text-sm">Categorías del pago</p>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="rubro" class="form-control-label">Rubro</label>
                              <select id="pagosRubroId" name="pagosRubroId" class="form-control custom-select">
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
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="subrubro" class="form-control-label">Subrubro</label>
                              <select id="pagosSubrubroId" name="pagosSubrubroId" class="form-control">
                                <option value="" selected disabled>Seleccione un subrubro</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <hr class="horizontal dark">
                        
                        <p class="text-uppercase text-sm">Datos de transacción</p>
                        
                        <div class="row align-items-center">
                          <div class="col-md-6">
                            <div class="form-group my-auto">
                              <label class="form-control-label">Tipo transacción</label>
                              <div class="d-grid gap-4">
                                <input type="checkbox" 
                                       name="pagoTransaccionTipoId"
                                       id="pagoTransaccionTipoId"
                                       data-onvalue="2"
                                       data-offvalue="1"
                                       checked
                                       data-toggle="toggle" 
                                       data-onlabel="Ingreso" 
                                       data-offlabel="Egreso" 
                                       data-onstyle="success" 
                                       data-offstyle="danger" 
                                       data-style="android">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Fecha</label>
                              <div class="input-group">
                                <input class="form-control" 
                                       type="date" 
                                       value="<?php echo isset($pago['fecha']) ? date("Y-m-d", strtotime($pago['fecha'])) : date("Y-m-d"); ?>" 
                                       id="fecha" name="fecha">
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr class="horizontal dark">

                        <p class="text-uppercase text-sm">Datos del pago</p>

                        <div class="row align-items-center">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-control-label">Monto</label>
                              <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                <input type="number" step="any" 
                                       id="monto" name="monto" 
                                       placeholder="00.00"
                                       value="<?php echo isset($pago['monto']) ? $pago['monto'] : ''; ?>" 
                                       class="form-control" style="text-align: right;">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-control-label" id="fecha_cotizacion">Cotización</label>
                              <div class="input-group mb-4">
                                <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                <input type="text" 
                                       id="cotizacion" name="cotizacion" 
                                       value="" 
                                       class="form-control" style="text-align: right;">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="form-control-label">Moneda</label>
                              <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                                <?php foreach ($monedas as $moneda): ?>
                                <label class="btn <?php echo (isset($pago['monedaId']) && $pago['monedaId'] == $moneda['monedaId']) ? "active" : ""; ?>">
                                  <input type="radio" name="monedaId" value="<?php echo $moneda['monedaId']; ?>" <?php echo (isset($pago['monedaId']) && $pago['monedaId'] == $moneda['monedaId']) ? "checked" : ""; ?>>
                                  <?php echo $moneda['moneda']; ?>
                                </label>
                                <?php endforeach; ?>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="col-md-12 pb-1">
                          <div class="form-group">
                            <label class="form-control-label">Medio de pago</label>
                            <select id="medioPagoId" name="medioPagoId" class="form-control">
                              <option value="" selected disabled>Seleccione un medio de pago</option>
                              <?php foreach ($mediosPago as $medioPago): ?>
                              <option value="<?php echo $medioPago['medioPagoId']; ?>" 
                                      <?php echo (isset($pago['medioPagoId']) && $pago['medioPagoId'] == $medioPago['medioPagoId']) ? "selected" : ""; ?>>
                                <?php echo $medioPago['medioPago']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>

                        <hr class="horizontal dark">

                        <p class="text-uppercase text-sm">Datos opcionales</p>

                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="form-control-label">Asignar pago al usuario</label>
                            <div class="row">
                              <div class="col-md-9">
                                <input autocomplete="off" type="text" id="buscar" name="buscar" class="form-control" placeholder="Ingrese al menos 3 caracteres">
                              </div>
                              <div class="col-md-3">
                                <button id="deseleccionar" class="btn btn-outline-secondary w-100" disabled>
                                  <i class="fas fa-times"></i> Deseleccionar
                                </button>
                              </div>
                            </div>
                            <div id="resultado" class="dropdown-menu dropdown-menu-left w-100"></div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="comentario">Agregar comentario</label>
                          <textarea id="comentario" name="comentario" class="form-control"><?php echo isset($pago['comentario']) ? $pago['comentario'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-check form-switch">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" 
                               class="habilitado-checkbox"
                               name="habilitado_sys"
                               data-id="<?php echo isset($pago['pagosRubroId']) ? $pago['pagosRubroId'] : ''; ?>"
                               <?php echo $pago["habilitado_sys"] == 1 ? "checked" : "" ?>
                               onclick="habilitadoCheckboxChange(this)">
                            Habilitado
                          </label>
                        </div>
                      </div>

                      <div class="card-footer d-flex justify-content-between">
                        <input type="hidden" name="action" value="<?php echo $action ?>">
                        <input type="hidden" name="usuarioId" id="usuarioId" value="">
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
        
        $('.btn-group').on('change', 'input[type="radio"]', function() {
          var monedaId = $(this).val();
          $('#cotizacion').prop("disabled", true);
          $('#cotizacion').val("");

          if (monedaId == 2 || monedaId == 3) {

            $('#cotizacion').attr('placeholder', 'Cargando cotización...');
            
            $.ajax({
              type: 'GET',
              url: '',
              data:{
                monedaId:monedaId,
                action:"cotizacion"
              },
              dataType: 'json',
              success: function(data) {
                console.log('Cotización dólar:', data);
                $('#cotizacion').val(data.cotizacion);
                $('#fecha_cotizacion').val("Cotización (" + data.fecha + ")");
                // Actualiza el valor de la cotización dólar en tu interfaz

                $('#cotizacion').attr('placeholder', '');
                $('#cotizacion').prop("disabled", false);
              },
              error: function(error){
                console.log(error);

                $.ajax({
                  type: 'GET',
                  url: 'https://api.bluelytics.com.ar/v2/latest',
                  dataType: 'json',
                  success: function(data) {
                    const ultimoUpdate = data.last_update;
                    const dolarOficial = data.oficial.value_avg;
                    const euroOficial = data.oficial_euro.value_avg;
                    const dolarBlue = data.blue.value_avg;
                    const euroBlue = data.blue_euro.value_avg;

                    console.log(`Última actualización: ${ultimoUpdate}`);
                    console.log(`Dólar oficial: ${dolarOficial}`);
                    console.log(`Euro oficial: ${euroOficial}`);
                    console.log(`Dólar blue: ${dolarBlue}`);
                    console.log(`Euro blue: ${euroBlue}`);

                    const fechaHoy = new Date();
                    const fechaFormateada = fechaHoy.toLocaleDateString('es-AR');

                    // Actualiza los valores en tu interfaz
                    $('#ultimoUpdate').text(ultimoUpdate);
                    $('#dolarOficial').text(dolarOficial);
                    $('#euroOficial').text(euroOficial);
                    $('#dolarBlue').text(dolarBlue);
                    $('#euroBlue').text(euroBlue);

                    $('#cotizacion').val(monedaId == 2 ? dolarBlue : euroBlue);
                    $('#fecha_cotizacion').val("Cotización (" + fechaFormateada + ")");

                    $('#cotizacion').attr('placeholder', '');
                    $('#cotizacion').prop("disabled", false);

                  },
                  error: function(xhr, status, error) {
                    $('#ul_errores').html('<li>' + error.responseText + '</li>');
                    $('#btn-modal-errores').click();

                    
                  }
                });
              }
            });
          } else {
            $('#cotizacion').val();
          }
        });

        $('#pagoTransaccionTipoId').on('change', function() {
          $(this).val($(this).prop('checked') ? 2 : 1);
          console.log($(this).val());
        });

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

        $('form').submit(function(e) {
          e.preventDefault();
          var datos = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: '',
            data: datos,
            dataType: 'json',
            success: function(respuesta) {
              if (respuesta.estado === 'ok') {
                // Formulario válido, puedes continuar
                
              } else {
                // Formulario inválido, muestra errores en modal
                var errores = respuesta.errores;
                $('#ul_errores').empty();
                $.each(errores, function(index, error) {
                  $('#ul_errores').append('<li>' + error + '</li>');
                });
                $('#btn-modal-errores').click();
              }
            }
          });
        });

        $('#pagosRubroId').change(function() {
            var pagosRubroId = $(this).val();
            
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                data: {
                  pagosRubroId: pagosRubroId, 
                  action: 'getSubrubros'
                },
                success: function(response) {
                    $('#pagosSubrubroId').empty();
                    $.each(response, function(index, value) {
                        $('#pagosSubrubroId').append('<option value="' + value.pagosSubrubroId + '">' + value.subrubro + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar:', error);
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