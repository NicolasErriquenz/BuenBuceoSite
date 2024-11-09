<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes_hospedajes";
  $idNombre = "viajesHospedajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajesHospedajesHabitacion" ) {
    echo json_encode(altaViajesHospedajesHabitacion($_POST));
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarViajesHospedajesHabitacion" ) {
    echo eliminarViajesHospedajesHabitacion($_POST["viajesHospedajesHabitacionId"]);
    die();
  }

  $viaje = [];
  
  $usuarios = [];
  $tipoViajeros = [];

  $viaje_hospedaje = getItem($tabla, $idNombre, $_GET[$idNombre]);
  
  $viajeId = $viaje_hospedaje["viajesId"];
  $hospedajeId = $viaje_hospedaje["hospedajesId"];

  $habitacionesTarifas = getHospedajeHabitacionesTarifas($hospedajeId);
// print_r(json_encode($habitacionesTarifas));
//   die();
  $viaje = getItem("viajes", "viajesId", $viajeId);

  $viajeros = getViajesUsuarios($viajeId);
  
  $viajeHospedajes = getViajeHospedaje($_GET[$idNombre]);

  // print_r(json_encode($viajeHospedaje));
  // die();
  $redirect = "viajes_dashboard.php?viajeId=".$viajeId;

  $title = "Editar habitaciones";
  $subtitle = "Podés editar la info del viaje";
  $action = "editar";

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
        </div>
      </div>
    </div>

    <div class="container-fluid py-4">
      <div class="row">

        <div class="col-md-12">

          <div class="card mb-4">
            <div class="card-header ">
              <div class="row">
                <div class="col">
                  <h6 class="float-start">ADMINISTRAR HABITACIONES/VIAJEROS (<?php echo count($viajeros) ?>)</h6>
                  <div class="float-end">
                    <button class="btn btn-sm btn-icon bg-gradient-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-crear-habitacion">
                        <i class="ni ni-fat-add"></i> AGREGAR HABITACIÓN
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                    <!-- Div lateral flotante con viajeros -->
                    <div id="viajeros" draggable="true">
                    <div class="titulo">
                    <i class="fa fa-arrows-v"></i> 
                    <span> Viajeros </span>
                  </div>
                    <ul style="list-style-type: none; padding: 0; margin: 0;">
                        <?php foreach ($viajeros as $viajero) { ?>
                            <li class="viajero" id="viajero-<?php echo $viajero['viajesUsuariosId']; ?>" 
                                data-viajero='<?php echo json_encode($viajero); ?>'>
                                <img src="_recursos/profile_pics/<?php echo isset($viajero['usuario']['imagen']) && !empty($viajero['usuario']['imagen']) ? $viajero['usuario']['imagen'] : 'generic_user.png'; ?>" 
                                    alt="<?php echo $viajero['usuario']['nombre'] . ' ' . $viajero['usuario']['apellido']; ?>" 
                                    class="img-profile">
                                <?php echo $viajero['usuario']['nombre'] . ' ' . $viajero['usuario']['apellido']; ?> (<?php echo $viajero['usuario']['apodo'] ?>)
                            </li>
                        <?php } ?>
                    </ul>
                    </div>
                    <div id="contenedor" class="row">
                        <?php foreach ($viajeHospedajes["hospedaje"]["habitaciones"] as $habitacion): ?>

                        <div id="habitacion-<?php echo $habitacion["viajesHospedajesHabitacionId"] ?>" 
                            class="habitacion card border-rounded" >
                            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center pt-0 pb-0">
                                <div>
                                    <span style="font-size: 18px;"><?php echo $habitacion["tarifa"]["alias"] ?></span>
                                    <div style="font-size: 14px; color: #fff;"><?php echo $habitacion["tarifa"]["base"] ?> - $<?php echo $habitacion["tarifa"]["precio"] ?></div>
                                </div>
                                <button class="btn btn-link" onclick="eliminarHabitacion(<?php echo $habitacion["viajesHospedajesHabitacionId"] ?>)" style="color:white; margin-top: auto; margin-bottom: auto;">
                                    <i class="fa fa-times fa-sm"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="camas">
                                    <?php for ($i = 0; $i < $habitacion["camas_dobles"]; $i++): ?>
                                        <div class="cama doble"></div>
                                    <?php endfor; ?>
                                    <?php for ($i = 0; $i < $habitacion["camas_simples"]; $i++): ?>
                                        <div class="cama simple"></div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="card-footer bg-light pt-0 pb-0">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center" style="font-size: 12px; text-align: left;">
                                    <div>
                                        <div>Camas Dobles: <?php echo $habitacion["camas_dobles"] ?></div>
                                        <div>Camas Simples: <?php echo $habitacion["camas_simples"] ?></div>
                                    </div>
                                    </div>
                                    <div class="col-3 border-left text-center">
                                    <div style="font-size: 12px;">Usuarios</div>
                                    <div style="font-size: 18px;"><?php echo count($habitacion["usuarios"]) ?></div>
                                    </div>
                                    <div class="col-3 border-left text-center">
                                    <div style="font-size: 12px;">Completado</div>
                                    <div style="font-size: 18px;">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
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

      
    <div class="modal fade" id="modal-crear-habitacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Habitación</h5>
            </div>
            <div class="modal-body">
                <form id="form-crear-habitacion">
                    <div class="form-group">
                        <label for="hospedajeTarifaId">Tarifa:</label>
                        <select class="form-control" id="hospedajeTarifaId" name="hospedajeTarifaId">
                        <?php foreach ($habitacionesTarifas as $tarifa) { ?>
                            <option value="<?php echo $tarifa['hospedajeTarifaId']; ?>">
                            <?php echo $tarifa['alias'] . ' - $' . $tarifa['precio']; ?> (<?php echo $tarifa['base'] ?>)
                            </option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="camasDobles">Camas Dobles:</label>
                        <input type="number" class="form-control" id="camasDobles" name="camasDobles" value="0">
                    </div>
                    <div class="form-group">
                        <label for="camasSimples">Camas Simples:</label>
                        <input type="number" class="form-control" id="camasSimples" name="camasSimples" value="0">
                    </div>
                </form>
                <div class="row">
                    <div class="text-center alert alert-danger fade" id="error_div">
                        <span class="alert-icon"><i class="fa fa-warning"></i></span>
                        <span id="error-text"></span>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" 
                        class="btn btn-primary" 
                        id="btn-crear-habitacion" 
                        onclick="javascript:validarFormCrearHabitacion()">Crear Habitación</button>
            </div>
            </div>
        </div>
    </div>
  </div>

    <div id="habitacion-template" 
        class="habitacion card border-rounded" 
        style="display:none;">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center pt-0 pb-0">
            <div>
                <span style="font-size: 18px;">%ALIAS%</span>
                <div style="font-size: 14px; color: #fff;">%BASE% - $%PRECIO%</div>
            </div>
            <button class="btn btn-link" onclick="eliminarHabitacion(%ID%)" style="color:white; margin-top: auto; margin-bottom: auto;">
                <i class="fa fa-times fa-sm"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="camas">
            </div>
        </div>
        <div class="card-footer bg-light pt-0 pb-0">
            <div class="row">
                <div class="col-6 d-flex align-items-center" style="font-size: 12px; text-align: left;">
                <div>
                    <div>Camas Dobles: %CANT_CAMAS_DOBLES%</div>
                    <div>Camas Simples: %CANT_CAMAS_SIMPLES%</div>
                </div>
                </div>
                <div class="col-3 border-left text-center">
                <div style="font-size: 12px;">Usuarios</div>
                <div style="font-size: 18px;">%CANT_USUARIOS%</div>
                </div>
                <div class="col-3 border-left text-center">
                <div style="font-size: 12px;">Completado</div>
                <div style="font-size: 18px;">%PORCENTAJE%%</div>
                </div>
            </div>
        </div>
    </div>
  <script>

    var habitacionesTarifas = <?php echo json_encode($habitacionesTarifas); ?>;

    function crearHabitacion(nombre, hospedajeTarifaId, camasDobles, camasSimples, viajesHospedajesHabitacionId) {
        var habitacionTarifa = habitacionesTarifas.find(habitacionTarifa => habitacionTarifa.hospedajeTarifaId == hospedajeTarifaId);
        console.log(habitacionTarifa);
        
        // Clonar template
        var habitacionDiv = document.getElementById('habitacion-template').cloneNode(true);
        habitacionDiv.style.display = 'block'; // Mostrar el div
        habitacionDiv.classList.add('col-4');
        // Ahora puedes utilizar este ID para actualizar el ID de la habitación en tu HTML
        habitacionDiv.id = 'habitacion-' + viajesHospedajesHabitacionId;

        // Reemplazar comodines
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%ALIAS%', habitacionTarifa.alias);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%BASE%', habitacionTarifa.base);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%PRECIO%', habitacionTarifa.precio);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_CAMAS_DOBLES%', camasDobles);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_CAMAS_SIMPLES%', camasSimples);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_USUARIOS%', '0');
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%PORCENTAJE%', '0');
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%ID%', viajesHospedajesHabitacionId);
        
        // Agregar camas
        var camasDiv = habitacionDiv.querySelector('.camas');

        for (var i = 0; i < camasDobles; i++) {
            var camaDobleDiv = document.createElement('div');
            camaDobleDiv.className = 'cama doble';
            camasDiv.appendChild(camaDobleDiv);
        }
        for (var i = 0; i < camasSimples; i++) {
            var camaSimpleDiv = document.createElement('div');
            camaSimpleDiv.className = 'cama simple';
            camasDiv.appendChild(camaSimpleDiv);
        }
        
        // Agregar div de habitación al contenedor
        document.getElementById('contenedor').prepend(habitacionDiv);
    }

    // Manejar formulario para crear habitación
    function validarFormCrearHabitacion(){
        event.preventDefault();

        // Obtener datos del formulario
        var hospedajeTarifaId = $('#hospedajeTarifaId').val();
        var camasDobles = $('#camasDobles').val();
        var camasSimples = $('#camasSimples').val();
        
        /// Validar campos
        var error = '';

        if (!hospedajeTarifaId || hospedajeTarifaId == undefined) 
            error += 'Hay que seleccionar una tarifa.\n';

        if (!camasDobles || camasDobles == undefined || isNaN(camasDobles) || camasDobles < 0) 
            error += 'Hay que ingresar un número válido de camas dobles.\n';

        if (!camasSimples || camasSimples == undefined || isNaN(camasSimples) || camasSimples < 0)
            error += 'Hay que ingresar un número válido de camas simples.\n';

        if (camasDobles == 0 && camasSimples == 0)
            error += 'Debe haber al menos una cama doble o simple.\n';

        // Mostrar errores
        if (error) {
            $('#error_div').removeClass('fade').addClass('show');
            $('#error-text').text(error);
            return;
        } else {
            $('#error_div').removeClass('show').addClass('fade');
        }

        // Enviar datos al servidor para crear habitación
        $.ajax({
            type: 'POST',
            url: '',
            dataType:"json",
            data: {
                action:"altaViajesHospedajesHabitacion",
                viajesHospedajesId: <?php echo $_GET[$idNombre]; ?>,
                hospedajeTarifaId: hospedajeTarifaId,
                camasDobles: camasDobles,
                camasSimples: camasSimples
            },
            success: function(response) {
                var nombre = 'Habitación Ejecutiva';

                var viajesHospedajesHabitacionId = response.viajesHospedajesHabitacionId;
                

                crearHabitacion(nombre, hospedajeTarifaId, camasDobles, camasSimples, viajesHospedajesHabitacionId);
                resetForm();
                $('#modal-crear-habitacion').modal('hide');
            }
        });
    }

    function eliminarHabitacion(viajesHospedajesHabitacionId){
        console.log(eliminarHabitacion);
        $.ajax({
            type: 'POST',
            url: '',
            dataType:"text",
            data: {
                action:"eliminarViajesHospedajesHabitacion",
                viajesHospedajesId: <?php echo $_GET[$idNombre]; ?>,
                viajesHospedajesHabitacionId: viajesHospedajesHabitacionId,
            },
            success: function(response) {
                if(response == "ok"){
                    $("#habitacion-" + viajesHospedajesHabitacionId).fadeOut(400, function() {
                      $(this).remove();
                    });    
                }
            }
        });
    }

    function resetForm(){
        //var hospedajeTarifaId = $('#hospedajeTarifaId').val();
        // $('#camasDobles').val(0);
        // $('#camasSimples').val(0);
    }

    $(document).ready(function() {

        // Permitir que el viajero vuelva a la lista original al hacer clic
        $(".cama").on("click", ".viajero", function() {
            $(this).appendTo($("#viajeros ul"));
            $(this).removeClass("viajero-en-cama");

            // Asegurar que sigan siendo arrastrables después de devolverlos
            $(".viajero").draggable({
                containment: "window",
                cursor: "move",
                revert: true,
                helper: "clone",
                appendTo: "body",
                zIndex: 1000,
            });
        });

        $(".cama .viajero").draggable({
          containment: "window",
          cursor: "move",
          revert: true,
          appendTo: "body" // Agrega esto
        });

        // Hacer que los viajeros sean arrastrables
        $(".viajero").draggable({
            containment: "window",
            cursor: "move",
            helper: "clone",
            appendTo: "body",
            zIndex: 1000,
            revert: function(droppable) {
                // Si se soltó sobre un droppable válido, no revertir
                return droppable === false;
            },
            start: function(event, ui) {
                ui.helper.addClass("dragging-viajero");
            },
            stop: function(event, ui) {
                // Limpieza visual
                $(this).removeClass("dragging-viajero");
            }
        });


        // Hacer que las camas sean receptivas
        $(".cama").droppable({
            accept: ".viajero",
            tolerance: "pointer",
            hoverClass: "cama-hover",
            drop: function(event, ui) {

                ui.draggable.removeClass("dragging-viajero");
                ui.draggable.addClass("viajero-en-cama");

                var viajeroId = ui.draggable.attr("id");
                var camaId = $(this).attr("id");

                // Verificar la cantidad máxima de viajeros por cama
                var tipoCama = $(this).attr("data-tipo-cama");
                var viajerosAsignados = $(this).find('.viajero').length;

                if ((tipoCama === "doble" && viajerosAsignados >= 2) || 
                    (tipoCama === "simple" && viajerosAsignados >= 1)) {
                    alert('La cama ya está ocupada.');
                    return;
                }

                // Asignar el viajero a la cama
                $(this).append(ui.draggable);

                // Actualizar el estado en la base de datos
                $.ajax({
                    type: 'POST',
                    url: '', // URL del endpoint del servidor
                    data: { viajeroId: viajeroId, camaId: camaId },
                    success: function(response) {
                        console.log('Asignación exitosa:', response);
                    }
                });
            }
        });

  // Código adicional
  $('#hospedajeTarifaId').change(function() {
    var hospedajeTarifaId = $(this).val();
    console.log(hospedajeTarifaId);
    var tarifa = habitacionesTarifas.find(tarifa => tarifa.hospedajeTarifaId == hospedajeTarifaId);
    console.log(tarifa);
    var baseHospedajeId = tarifa.baseHospedajeId;

    var camasDobles = Math.floor(baseHospedajeId / 2);
    var camasSimples = baseHospedajeId % 2;

    $('#camasDobles').val(camasDobles);
    $('#camasSimples').val(camasSimples);
  });

  $('#hospedajeTarifaId').trigger('change');

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

    const viajeros = document.getElementById('viajeros');

    viajeros.addEventListener('dragstart', (e) => {
      e.dataTransfer.setData('text', '');
    });

    viajeros.addEventListener('dragover', (e) => {
      e.preventDefault();
    });

    viajeros.addEventListener('dragend', (e) => {
      const rect = viajeros.getBoundingClientRect();
      const alturaPantalla = window.innerHeight;
      const nuevaPosicion = Math.max(0, Math.min(e.clientY, alturaPantalla - rect.height));
      viajeros.style.top = `${nuevaPosicion}px`;
    });

  </script>
  <style type="text/css">
   


  </style>
</body>

</html>