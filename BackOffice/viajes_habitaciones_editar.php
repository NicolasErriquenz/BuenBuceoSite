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

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarViajeroCama" ) {
    echo (eliminarViajeroCama($_POST));
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "altaViajesHospedajesHabitacionesUsuarios" ) {
    echo (altaViajesHospedajesHabitacionesUsuarios($_POST));
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

  $habitacionesTarifas = getHospedajeHabitacionesTarifasAvanzado($hospedajeId);
// print_r(json_encode($habitacionesTarifas));
//   die();
  $viaje = getItem("viajes", "viajesId", $viajeId);

  $viajerosSinHospedaje = getViajesUsuarios($viajeId, $_GET[$idNombre], false);
  $viajerosConHospedaje = getViajesUsuarios($viajeId, $_GET[$idNombre], true);
  //eco($viajerosSinHospedaje);
  $viajeHospedajeHabitaciones = getViajeHospedajeHabitaciones($_GET[$idNombre]);
  $jsonViajeHospedajeHabitaciones = json_encode($viajeHospedajeHabitaciones);
  // print_r(($jsonViajeHospedajeHabitaciones));
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
                <?php echo $viaje["nombre"] ?>
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
                  <h6 class="float-start">ADMINISTRAR HABITACIONES/VIAJEROS (<?php echo count($viajerosSinHospedaje + $viajerosConHospedaje) ?>)</h6>
                  <div class="float-end">
                    <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                      <i class="ni ni-bold-left"></i> Volver
                    </a>
                    &nbsp;
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
                            <?php foreach ($viajerosSinHospedaje as $viajero) { ?>
                                <li class="viajero" id="viajero-<?php echo $viajero['viajesUsuariosId']; ?>" 
                                    data-viajero='<?php echo json_encode($viajero); ?>'>
                                    <img src="_recursos/profile_pics/<?php echo isset($viajero['usuario']['imagen']) && !empty($viajero['usuario']['imagen']) ? $viajero['usuario']['imagen'] : 'generic_user.png'; ?>" 
                                        alt="<?php echo $viajero['usuario']['nombre'] . ' ' . $viajero['usuario']['apellido']; ?>" 
                                        class="img-profile">
                                    <?php 
                                       echo (empty($viajero['usuario']['apodo']) ? $viajero['usuario']['nombre'] : $viajero['usuario']['apodo']) . 
                                       " (" . $viajero['usuario']['nombre'] . " " . $viajero['usuario']['apellido'] . ")";
                                    ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div id="contenedor" class="row">
                        
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

    <div id="toast" class="toast align-items-center bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" style="font-size: 18px;" id="toast-body">
          <i id="toast-icon" style="font-size: 24px; margin-right: 10px;"></i> <span id="toast-text"></span>
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
                            <option value="<?php echo $tarifa['hospedajeTarifaId']; ?>" data-tarifa='<?php echo json_encode($tarifa) ?>'>
                            <?php echo $tarifa['alias'] . ' - $' . $tarifa['precio']; ?> (<?php echo $tarifa['base']["nombre"] ?>)
                            </option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="camasDobles">Camas Dobles:</label>
                        <input type="number" class="form-control" id="camasDobles" name="camasDobles" 
                                value="0" min="0" oninput="this.value = this.value || 0">
                    </div>
                    <div class="form-group">
                        <label for="camasSimples">Camas Simples:</label>
                        <input type="number" class="form-control" id="camasSimples" name="camasSimples" 
                                value="0" min="0" oninput="this.value = this.value || 0">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="codigo_reserva">Código reserva:</label>
                                <input type="text" class="form-control" id="codigo_reserva" name="codigo_reserva" value="">
                            </div>
                            <div class="col-6">
                                <label for="reserva_nombre">A nombre de:</label>
                                <input type="text" class="form-control" id="reserva_nombre" name="reserva_nombre" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <input type="text" class="form-control" id="comentario" name="comentario" value="">
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
            <i class="fa fa-circle icono_habitacion" aria-hidden="true" style="position: absolute;"></i>
            <div style="margin-left: 38px;">
                <span style="font-size: 17px;">%ALIAS%</span>
                <div style="font-size: 12px; color: #fff;">%BASE% - $%PRECIO%</div>
            </div>
            <button class="btn btn-link" onclick="eliminarHabitacion(%ID%)" style="color:white; margin-top: auto; margin-bottom: auto;">
                <i class="fa fa-times fa-sm"></i>
            </button>
        </div>

        <div class="card-body">
            %ETIQUETA%
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
                    <div style="font-size: 18px;" class="usuarios-habitacion">%CANT_USUARIOS%</div>
                </div>
                <div class="col-3 border-left text-center ">
                    <div style="font-size: 12px;">Completado</div>
                    <div style="font-size: 18px;" class="porcentaje-ocupacion">%PORCENTAJE%%</div>
                </div>
            </div>
        </div>
        <div class="info-comentario" style="position: absolute; top: 62px; right: 21px;">
            %COMENTARIO%
        </div>
    </div>


  <script>
    // Acceder a las habitaciones
    var viajeHospedajeHabitaciones = <?= $jsonViajeHospedajeHabitaciones ?>;
    // Recorrer las habitaciones y crear cada una
    viajeHospedajeHabitaciones.forEach(habitacion => {
      crearHabitacion(habitacion);
    });

    var habitacionesTarifas = <?php echo json_encode($habitacionesTarifas); ?>;

    function crearHabitacion(habitacion) {
        
        // Clonar template
        var habitacionDiv = document.getElementById('habitacion-template').cloneNode(true);
        habitacionDiv.style.display = 'block'; // Mostrar el div
        habitacionDiv.classList.add('col-4');
        // Ahora puedes utilizar este ID para actualizar el ID de la habitación en tu HTML
        habitacionDiv.id = 'habitacion-' + habitacion.viajesHospedajesHabitacionId;

        // Reemplazar comodines
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%ALIAS%', habitacion.tarifa.alias);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%BASE%', habitacion.tarifa.base.nombre);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%PRECIO%', habitacion.tarifa.precio);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_CAMAS_DOBLES%', habitacion.camas_dobles);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_CAMAS_SIMPLES%', habitacion.camas_simples);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%CANT_USUARIOS%', '0');
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%PORCENTAJE%', '0');
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%ID%', habitacion.viajesHospedajesHabitacionId);
        habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%ETIQUETA%', !isEmpty(habitacion.codigo_reserva) ? '<div class="etiqueta">'+habitacion.codigo_reserva+'</div>' : "");
       habitacionDiv.innerHTML = habitacionDiv.innerHTML.replace('%COMENTARIO%', 
          (!isEmpty(habitacion.comentario) || !isEmpty(habitacion.reserva_nombre)) 
          ? '<button type="button" class="btn text-info p-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="' 
            + (habitacion.comentario ? habitacion.comentario : '') 
            + (habitacion.reserva_nombre ? ' - reserva a nombre de ' + habitacion.reserva_nombre : '') 
            + '"><i class="fa fa-info-circle" aria-hidden="true"></i></button>' 
          : ""
        );

        
        // Agregar camas
        var camasDiv = habitacionDiv.querySelector('.camas');

        for (var i = 0; i < habitacion.camas_dobles; i++) {
            var camaDobleDiv = document.createElement('div');
            camaDobleDiv.className = 'cama doble';
            camaDobleDiv.setAttribute('viajesHospedajesHabitacionId', habitacion.viajesHospedajesHabitacionId);
            camasDiv.appendChild(camaDobleDiv);
        }
        for (var i = 0; i < habitacion.camas_simples; i++) {
            var camaSimpleDiv = document.createElement('div');
            camaSimpleDiv.className = 'cama simple';
            camaSimpleDiv.setAttribute('viajesHospedajesHabitacionId', habitacion.viajesHospedajesHabitacionId);
            camasDiv.appendChild(camaSimpleDiv);
        }
        
        // Agregar viajeros con hospedaje
        if (habitacion.viajesHospedajesHabitacionUsuarios && habitacion.viajesHospedajesHabitacionUsuarios.length > 0) {
            var camasDiv = habitacionDiv.querySelector('.camas');
            var camas = camasDiv.children;

            habitacion.viajesHospedajesHabitacionUsuarios.forEach(viajero => {
                var tipoCama = viajero.cama_doble == 1 ? 'doble' : 'simple';
                var camaDisponible = getCamaDisponible(camas, tipoCama, viajero);
                if (camaDisponible) {
                    agregarViajeroACama(camaDisponible, viajero);
                }
            });
        }

        // Agregar div de habitación al contenedor
        document.getElementById('contenedor').prepend(habitacionDiv);

        $(".cama").droppable();

        activarListeners();

        calcularOcupacionHabitacion(habitacion.viajesHospedajesHabitacionId);
    }

    function getCamaDisponible(camas, tipo, viajero) {
        if (tipo === 'doble') {
            return Array.from(camas).find(cama => cama.classList.contains(tipo) && cama.childElementCount < 2);
        } else {
            return Array.from(camas).find(cama => cama.classList.contains(tipo) && cama.childElementCount === 0);
        }
    }

    function agregarViajeroACama(cama, viajero) {
        var viajeroLi = document.createElement('li');
        viajeroLi.className = 'viajero';
        viajeroLi.id = 'viajero-' + viajero.viajesUsuariosId;
        viajeroLi.setAttribute('data-viajero', JSON.stringify(viajero));

        var imgProfile = document.createElement('img');
        imgProfile.src = '_recursos/profile_pics/' + (viajero.usuario.imagen || 'generic_user.png');
        imgProfile.alt = viajero.usuario.nombre + ' ' + viajero.usuario.apellido;
        imgProfile.className = 'img-profile';

        var textoViajero = document.createTextNode(
           (viajero.usuario.apodo ? viajero.usuario.apodo : viajero.usuario.nombre) + 
           ' (' + viajero.usuario.nombre + ' ' + viajero.usuario.apellido + ')'
        );

        viajeroLi.appendChild(imgProfile);
        viajeroLi.appendChild(textoViajero);

        cama.appendChild(viajeroLi);
    }

    function actualizarTodasLasHabitaciones() {
        var habitaciones = document.querySelectorAll('#contenedor > [id^="habitacion-"]');

        habitaciones.forEach(function(habitacion) {
            var idHabitacion = habitacion.id.replace('habitacion-', '');
            calcularOcupacionHabitacion(idHabitacion);
        });
    }

    function calcularOcupacionHabitacion(idHabitacion) {

        // Obtener la habitación
        var habitacion = document.getElementById("habitacion-"+idHabitacion);

        // Obtener la cantidad de camas
        var camas = habitacion.querySelector('.camas').children;

        // Calcular la cantidad total de camas
        var totalCamas = 0;
        for (var i = 0; i < camas.length; i++) {
            var cama = camas[i];
            if (cama.classList.contains('doble')) {
                totalCamas += 2;
            } else {
                totalCamas += 1;
            }
        }

        // Calcular la cantidad de usuarios
        var usuarios = 0;
        for (var i = 0; i < camas.length; i++) {
            var cama = camas[i];
            usuarios += cama.querySelectorAll('.viajero').length;
        }

        // Calcular el porcentaje de ocupación
        var porcentajeOcupacion = (usuarios / totalCamas) * 100;

        // Actualizar la información en la tarjeta
        habitacion.querySelector('.usuarios-habitacion').innerHTML = usuarios;
        habitacion.querySelector('.porcentaje-ocupacion').innerHTML = porcentajeOcupacion.toFixed(0) + '%';

       // Cambiar fondo del header según ocupación
        var header = habitacion.querySelector('.card-header');
        var icono = header.querySelector('.icono_habitacion');

        header.classList.remove('bg-gradient-secondary');
        header.classList.remove('bg-gradient-primary');
        header.classList.remove('bg-gradient-success');

        // Cambiar icono según ocupación
        if (porcentajeOcupacion === 100) {
            header.classList.add('bg-gradient-success');
            icono.className = 'icono_habitacion fa fa-star';
        } else if (usuarios === 0) {
            header.classList.add('bg-gradient-secondary');
            icono.className = 'icono_habitacion fa fa-star-o';
        } else {
            header.classList.add('bg-gradient-primary');
            icono.className = 'icono_habitacion fa fa-star-half-o';
        }
    }

    // Manejar formulario para crear habitación
    function validarFormCrearHabitacion(){
        //event.preventDefault();

        // Obtener datos del formulario
        var hospedajeTarifaId = $('#hospedajeTarifaId').val();
        var camasDobles = $('#camasDobles').val();
        var camasSimples = $('#camasSimples').val();
        var comentario = $('#comentario').val();
        var codigo_reserva = $('#codigo_reserva').val();
        var reserva_nombre = $('#reserva_nombre').val();

        var seleccionado = $('#hospedajeTarifaId').find('option:selected');
        // Obtiene el JSON en data-tarifa
        var tarifaJson = seleccionado.data('tarifa');
        // Parsea el JSON a objeto

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
                camasSimples: camasSimples,
                codigo_reserva: codigo_reserva,
                reserva_nombre: reserva_nombre,
                comentario:comentario
            },
            success: function(response) {

                var viajesHospedajesHabitacionId = response.viajesHospedajesHabitacionId;
                
                var objViajeHospedajeHabitaciones = {
                    camas_dobles: camasDobles,
                    camas_simples: camasSimples,
                    hospedajeTarifaId: hospedajeTarifaId,
                    tarifa: tarifaJson,
                    viajesHospedajesHabitacionId: viajesHospedajesHabitacionId,
                    viajesHospedajesId: <?php echo $_GET[$idNombre]; ?>,
                    viajesHospedajesHabitacionUsuarios:{
                        usuarios: []
                    },
                };

                crearHabitacion(objViajeHospedajeHabitaciones);
                resetForm();
                $('#modal-crear-habitacion').modal('hide');
            }
        });
    }

    function eliminarHabitacion(viajesHospedajesHabitacionId){
        $.ajax({
            type: 'POST',
            url: '',
            dataType:"text",
            data: {
                viajesHospedajesId: <?php echo $_GET['viajesHospedajesId'] ?>, 
                action:"eliminarViajesHospedajesHabitacion",
                viajesHospedajesId: <?php echo $_GET[$idNombre]; ?>,
                viajesHospedajesHabitacionId: viajesHospedajesHabitacionId,
            },
            success: function(response) {
                if(response == "ok"){
                    $("#habitacion-" + viajesHospedajesHabitacionId).fadeOut(400, function() {
                      $(this).remove();
                    });    
                    location.reload();
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

        //activarListeners();

         // Código adicional
        $('#hospedajeTarifaId').change(function() {
            var hospedajeTarifaId = $(this).val();
            var tarifa = habitacionesTarifas.find(tarifa => tarifa.hospedajeTarifaId == hospedajeTarifaId);
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

    function eliminarViajeroCama(viajesUsuariosId){
        $.ajax({
            type: 'POST',
            url: '', // URL del endpoint del servidor
            data: { 
                viajesHospedajesId: <?php echo $_GET['viajesHospedajesId'] ?>, 
                viajesUsuariosId: viajesUsuariosId, 
                action: "eliminarViajeroCama" 
            },
            success: function(response) {
            },
            error: function(){
                location.reload();
            }
        });
    }

    let toast = null;
    let timeout = null;

    function mostrarToast(texto) {
        // Eliminar toast anterior si existe
        if (toast) 
            toast.hide();
        if (timeout) 
            clearTimeout(timeout);

        // Mostrar nuevo toast
        document.getElementById("toast-body").style.backgroundColor = "red";
        document.getElementById("toast-text").innerText = texto;
        document.getElementById("toast-icon").className = "fa fa-warning";

        toast = new bootstrap.Toast(document.getElementById("toast"));
        toast.show();

        // Guardar referencia al timeout para cancelarlo luego
        timeout = setTimeout(function() {
            toast.hide();
            toast = null;
            timeout = null;
        }, 1500);
    }

    function activarListeners(){
        // Permitir que el viajero vuelva a la lista original al hacer clic
        $(".cama").off("click", ".viajero").on("click", ".viajero", function() {

            event.stopPropagation();

            $(this).appendTo($("#viajeros ul"));
            $(this).removeClass("viajero-en-cama");

            var viajesHospedajesHabitacion = $(this).data("viajero");

            // Asegurar que sigan siendo arrastrables después de devolverlos
            $(".viajero").draggable({
                containment: "window",
                cursor: "move",
                revert: true,
                helper: "clone",
                appendTo: "body",
                zIndex: 1000,
            });


            $.ajax({
                type: 'POST',
                url: '', // URL del endpoint del servidor
                dataType:"text",
                data: { 
                    viajesHospedajesId: <?php echo $_GET['viajesHospedajesId'] ?>, 
                    viajesUsuariosId: viajesHospedajesHabitacion.viajesUsuariosId, 
                    action:"eliminarViajeroCama",
                },
                success: function(response) {
                    calcularOcupacionHabitacion(response);
                }
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

                var viajesHospedajesHabitacionId = $(this).attr("viajesHospedajesHabitacionId");

                ui.draggable.removeClass("dragging-viajero");
                ui.draggable.addClass("viajero-en-cama");

                var viajesUsuariosId = ui.draggable.attr("id").split("-")[1];
                var camaId = $(this).attr("id");

                var cama = $(this); // Guarda el contexto de this
                var viajero = ui.draggable;

                // Verificar la cantidad máxima de viajeros por cama
                // Verificar la cantidad máxima de viajeros por cama
                var tipoCama = $(this).hasClass("doble") ? "doble" : "simple";
                var viajerosAsignados = $(this).find('.viajero').length;

                if ((tipoCama === "doble" && viajerosAsignados >= 2) || 
                    (tipoCama === "simple" && viajerosAsignados >= 1)) {
                    mostrarToast('La cama no tiene mas espacio.', "fa fa-warning", "danger");
                    return;
                }

                // Asignar el viajero a la cama
                $(this).append(ui.draggable);

                // Actualizar el estado en la base de datos
                $.ajax({
                    type: 'POST',
                    url: '', // URL del endpoint del servidor
                    dataType:"text",
                    data: { 
                        viajesHospedajesId: <?php echo $_GET['viajesHospedajesId'] ?>, 
                        viajesUsuariosId: viajesUsuariosId, 
                        viajesHospedajesHabitacionId: viajesHospedajesHabitacionId,
                        action:"altaViajesHospedajesHabitacionesUsuarios",
                        tipoCama:tipoCama,
                    },
                    success: function(response) {
                        if(response != "ok"){

                            
                            mostrarToast(response, "fa fa-warning", "asd");
                            revertirCambio(viajero, cama);
                        }else
                            actualizarTodasLasHabitaciones();
                    }
                });
            }
        });


        function revertirCambio(viajero, cama) {
            viajero.appendTo($("#viajeros ul"));
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
    }
  </script>
</body>

</html>