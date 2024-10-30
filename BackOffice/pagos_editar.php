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
      if (empty($_POST['cotizacion']))  $errores[] = 'Cotización es requerido';
      if (empty($_POST['monto']))  $errores[] = 'Monto es requerido';
      if (empty($_POST['medioPagoId']))  $errores[] = 'Medio de pago es requerido';
      
      // Validación de formato
      if (!filter_var($_POST['monto'], FILTER_VALIDATE_FLOAT))  $errores[] = 'Monto debe ser un número';
      if (!preg_match('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}/', $_POST['fecha']))  $errores[] = 'Fecha debe tener formato YYYY-MM-DDTHH:MM';

      if (count($errores) > 0) {
        $respuesta = array('estado' => 'error', 'errores' => $errores);
      } else {

        
        $respuesta = array('estado' => 'ok');
      }

      echo json_encode($respuesta);
      die();
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "getSubrubros" ) {
    echo getSubrubrosPagos(true, $_POST["pagosRubroId"], true);
    die();
  }

  
  
  if( isset($_GET["pagosSubrubroId"]) ){
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
  $cotizacion = getCotizacion();
  $mediosPago = getMediosDePago();
  // if(isset($_GET)){
  //   $goBackLink = "pagos_subrubros.php?pagosRubrosId=".$_GET["pagosRubrosId"].conservarQueryString();
  // }
?>
<!DOCTYPE html>
<html lang="es">
   
   <?php include("includes/head.php"); ?>

   <body>
      
      <?php include("includes/navbar.php"); ?>

      <?php include("includes/menu.php"); ?>

      <section class="content-wrap">


         <!-- Breadcrumb -->
         <div class="page-title">
            <div class="row">
               <div class="col s12 m9 l10">
                  <h1>Editar Subrubro de pagos</h1>
                  <ul>
                     <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a> /</li>
                     <li><a href="pagos_rubros.php">Subrubros</a> /</li>
                     <li><a href="#"><?php echo  $title ?></a></li>
                  </ul>
               </div>
               <!-- <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a></div> -->
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="card-panel">
            <?php echo $subtitle ?>
         </div>
         <br>
         
        <form action="" method="POST">
          <input type="hidden" name="action" id="action" value="<?php echo $action ?>">
            <div class="row">
                <div class="col s12">
                    <div class="card-panel custom-card-panel">
                        <h5 class="center-align custom-title"><?php echo $title ?></h5>
                        
                        <?php if(isset($pago["pagoId"])){ ?>
                        <div class="input-field custom-input-field">
                            <label for="pagoId" class="custom-label">ID</label>
                            <input id="pagoId" name="pagoId" type="text" 
                                   value="<?php echo isset($pago["pagoId"]) ? $pago["pagoId"] : ''; ?>" 
                                   disabled>
                        </div>
                        <?php } ?>
                        
                      <div class="row">
                        <div class="col s6">
                          <div class="input-field custom-input-field">
                            <select id="pagosRubroId" name="pagosRubroId" class="browser-default custom-select">
                              <option value="" selected disabled>Seleccione un rubro</option>
                              <?php foreach ($rubros as $rubro): ?>
                              <option value="<?php echo $rubro['pagosRubroId']; ?>" 
                                      <?php echo (isset($pago['pagosRubroId']) && $pago['pagosRubroId'] == $rubro['pagosRubroId']) ? "selected" : ""; ?>>
                                <?php echo $rubro['rubro']; ?> (<?php echo $rubro['total_subrubros']; ?>)
                              </option>
                              <?php endforeach; ?>
                            </select>
                            <label for="pagosRubroId" class="custom-label active">Rubro</label>
                          </div>
                        </div>
                        <div class="col s6">
                          <div class="input-field custom-input-field">
                            <select id="pagosSubrubroId" name="pagosSubrubroId" class="browser-default custom-select">
                              <option value="" selected disabled>Seleccione un subrubro</option>
                              <?php foreach ($subrubros as $subrubro): ?>
                              <option value="<?php echo $subrubro['pagosSubrubroId']; ?>" 
                                      <?php echo (isset($pago['pagosSubrubroId']) && $pago['pagosSubrubroId'] == $subrubro['pagosSubrubroId']) ? "selected" : ""; ?>>
                                <?php echo $subrubro['subrubro']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                            <label for="pagosSubrubroId" class="custom-label active">Subrubro</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s6">
                          <div class="input-field custom-input-field" style="margin-bottom: 31px; background-color: #f0f0f0; padding: 10px;">
                            <p class="inline" style="margin-top: -10px;">
                              <?php foreach ($transaccionTipos as $transaccionTipo): ?>
                              <input name="pagoTransaccionTipoId" type="radio" id="transaccionTipo-<?php echo $transaccionTipo['pagoTransaccionTipoId']; ?>" 
                                     value="<?php echo $transaccionTipo['pagoTransaccionTipoId']; ?>" 
                                     <?php echo (isset($pago['pagoTransaccionTipoId']) && $pago['pagoTransaccionTipoId'] == $transaccionTipo['pagoTransaccionTipoId']) ? "checked" : ""; ?>>
                              <label for="transaccionTipo-<?php echo $transaccionTipo['pagoTransaccionTipoId']; ?>" style="color: black;"><?php echo $transaccionTipo['transaccion']; ?></label>
                              <?php endforeach; ?>
                            </p>
                            <label class="custom-label active">Tipo transacción</label>
                          </div>
                        </div>
                        <div class="col s6">
                          <div class="input-field custom-input-field">
                            <input id="fecha" name="fecha" type="datetime-local" 
                                   value="<?php echo isset($pago['fecha']) ? date("Y-m-d\TH:i", strtotime($pago['fecha'])) : date("Y-m-d\TH:i"); ?>">
                            <label for="fecha" class="custom-label active">Fecha</label>
                          </div>
                        </div>
                      </div>
                        
                      <div class="row">
                        <div class="col s12">
                          <div class="row">
                            <div class="col s6">
                              <div class="input-field custom-input-field">
                                <input id="monto" name="monto" type="number" step="any" 
                                       value="<?php echo isset($pago['monto']) ? $pago['monto'] : ''; ?>" 
                                       style="text-align: right;">
                                <label for="monto" class="custom-label active">Monto</label>
                              </div>
                            </div>
                            <div class="col s6">
                              <div class="input-field custom-input-field">
                                <input id="cotizacion" name="cotizacion" type="text"  
                                       value="<?php echo $cotizacion["cotizacion"] ?>" 
                                       style="text-align: right;">
                                <label for="cotizacion" class="custom-label active">Cotización (<?php echo $cotizacion["fecha"] ?>)</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
        
                      <div class="row">
                        <div class="col s6">
                          <div class="input-field custom-input-field">
                            <p class="inline">
                              <?php foreach ($monedas as $moneda): ?>
                              <input name="monedaId" type="radio" id="moneda-<?php echo $moneda['monedaId']; ?>" 
                                     value="<?php echo $moneda['monedaId']; ?>" 
                                     <?php echo (isset($pago['monedaId']) && $pago['monedaId'] == $moneda['monedaId']) ? "checked" : ""; ?>>
                              <label for="moneda-<?php echo $moneda['monedaId']; ?>"><?php echo $moneda['moneda']; ?></label>
                              <?php endforeach; ?>
                            </p>
                            <label class="custom-label active">Moneda</label>
                          </div>
                        </div>
                        <div class="col s6">
                          <div class="input-field custom-input-field">
                            <select id="medioPago" name="medioPago" class="browser-default custom-select">
                              <option value="" selected disabled>Seleccione un medio de pago</option>
                              <?php foreach ($mediosPago as $medioPago): ?>
                              <option value="<?php echo $medioPago['medioPagoId']; ?>" 
                                      <?php echo (isset($pago['medioPagoId']) && $pago['medioPagoId'] == $medioPago['medioPagoId']) ? "selected" : ""; ?>>
                                <?php echo $medioPago['medioPago']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                            <label for="medioPago" class="custom-label active">Medio de pago</label>
                          </div>
                        </div>
                      </div>

                        <div class="input-field custom-input-field">
                            <label for="habilitado_sys" class="custom-label active">Habilitado</label>
                            <p class="inline">
                                <input name="habilitado_sys" type="radio" id="habilitado_sys-1" value="1" 
                                       <?php echo (isset($pago['habilitado_sys']) && $pago['habilitado_sys'] == 1) ? "checked" : ""; ?>>
                                <label for="habilitado_sys-1">Sí</label>
                                <input name="habilitado_sys" type="radio" id="habilitado_sys-0" value="0" 
                                       <?php echo (isset($pago['habilitado_sys']) && $pago['habilitado_sys'] == 0) ? "checked" : ""; ?>>
                                <label for="habilitado_sys-0">No</label>
                            </p>
                        </div>

                        <div class="input-field custom-input-field">
                            <label for="usuarioId" class="custom-label active">Usuario</label>
                            <select id="usuarioId" name="usuarioId" class="browser-default custom-select">
                                <option value="" selected disabled>Seleccione un usuario</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?php echo $usuario['usuarioId']; ?>" 
                                        <?php echo (isset($pago['usuarioId']) && $pago['usuarioId'] == $usuario['usuarioId']) ? "selected" : ""; ?>>
                                    <?php echo $usuario['nombre']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="input-field custom-input-field">
                            <label for="deudaId" class="custom-label active">Deuda</label>
                            <select id="deudaId" name="deudaId" class="browser-default custom-select">
                                <option value="" selected disabled>Seleccione una deuda</option>
                                <?php foreach ($deudas as $deuda): ?>
                                <option value="<?php echo $deuda['deudaId']; ?>" 
                                        <?php echo (isset($pago['deudaId']) && $pago['deudaId'] == $deuda['deudaId']) ? "selected" : ""; ?>>
                                    <?php echo $deuda['descripcion']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="custom-footer">
                            <input type="hidden" name="action" value="<?php echo $action ?>">
                            <a href="<?php echo $goBackLink ?>" class="btn red lighten-1 custom-cancel-btn">Cancelar</a>
                            <button type="submit" class="btn custom-save-btn">Guardar</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>


          <!-- Estructura del modal -->
          <div id="modal_errores" class="modal">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Errores de validación</h5>
                <a href="#!" class="modal-close waves-effect waves-green btn-close">&times;</a>
              </div>
              <div class="modal-body">
                <ul class="list-group">
                  <?php foreach ($errores as $error): ?>
                    <li class="list-group-item list-group-item-danger"><?php echo $error; ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn btn-secondary">Cerrar</a>
              </div>
            </div>
          </div>

          <button id="btn-modal-errores" class="btn modal-trigger" href="#modal_errores" style="display:none;">Abrir modal</button>
      </section>
        
      
      <?php include("includes/footer.php") ?>

      <?php include("includes/scripts.php") ?>

     

      <script>

        $(document).ready(function() {

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
                    alert('Formulario válido');
                  } else {
                    // Formulario inválido, muestra errores en modal
                    var errores = respuesta.errores;
                    $('#modal_errores .modal-content ul').empty();
                    $.each(errores, function(index, error) {
                      $('#modal_errores .modal-content ul').append('<li>' + error + '</li>');
                    });
                    $('#btn-modal-errores').click();
                  }
                }
              });
            });

            $('.habilitado-checkbox').change(function() {
                var id = $(this).data('id');
                var habilitado = $(this).is(':checked') ? 1 : 0;
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

                
            });

            $('#pagosRubroId').change(function() {
                var pagosRubroId = $(this).val();
                console.log(pagosRubroId);
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

      <style type="text/css">
        .custom-card-panel {
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
          padding: 20px;
          border-radius: 4px;
        }

        .custom-title {
          margin-bottom: 30px;
          font-weight: 500;
        }

        .custom-input-field {
          margin-bottom: 20px;
        }

        .custom-label {
          font-size: 1.1em;
          margin-bottom: 5px;
        }

        .custom-input-field input, 
        .custom-input-field textarea {
          border: 1px solid #ccc;
          border-radius: 4px;
          padding: 10px;
          width: 100%;
          box-sizing: border-box;
        }

        .custom-switch {
          margin-bottom: 30px;
        }

        .custom-footer {
          background-color: #f5f5f5;
          padding: 15px;
          border-top: 1px solid #ddd;
          display: flex;
          justify-content: flex-end;
          margin-top: 20px;
        }

        .custom-cancel-btn {
          margin-right: 10px;
        }

        .custom-save-btn {
          background-color: #4A90E2;
          color: white;
        }
      </style>
      
      
   </body>
</html>