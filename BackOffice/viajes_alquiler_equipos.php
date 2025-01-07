<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "viajes";
  $idNombre = "viajesId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarTarifas" ) {
    guardarViajeTarifas($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "obtenerIngresosAlquileres" ) {
    $resultado = obtenerIngresosAlquileres($_POST);
    echo json_encode($resultado);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarAlquilerEquipo" ) {
    guardarAlquilerEquipo($_POST);
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
  $viajeros = getTodosViajesUsuarios($viaje[$idNombre]);
  $viajesHospedajes = getViajesHospedajes($viaje[$idNombre]);
  $redirect = "viajes.php";
  $paises = getPaises();

  $viajerosTipos = getViajesViajeroTipo();
  $paisNombre = getPais($viaje['paisId']);

  $equipos = getAlquilerEquipos();

  $tarifas = obtenerTarifasAlquilerEquipo($_GET[$idNombre]);

  //para precompletar los checkbox
  $equiposSeleccionados = obtenerEquiposSeleccionados($_GET[$idNombre]);

  $tieneTarifas = count($tarifas) != 0; 
//    echo json_encode($tarifas);
//    die();
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
    <div class="card shadow-lg mx-4" style="margin-top: 1rem !important; opacity:1;">
      <div id="status-tab" style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background-color: white; color: #007bff; font-size: 0.9rem; font-weight: bold; padding: 5px 15px; border-radius: 10px; border: 2px solid #007bff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <!-- Contenido dinámico del tiempo restante -->
        <span id="time-remaining">Calculando...</span>
      </div>
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
              <!-- Fechas del viaje -->
              <p class="text-muted mb-0" style="font-size: 0.85rem;">
                <i class="ni ni-calendar-grid-58 me-1"></i> 
                <?php echo date("d M Y", strtotime($viaje["fecha_inicio"])); ?> 
                - 
                <?php echo date("d M Y", strtotime($viaje["fecha_fin"])); ?>
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

      <div class="row pb-3">

        <div class="col">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Tarifas de Equipos</h6>
                    <button class="btn btn-info btn-sm" id="editarTarifas">
                        <i class="fas fa-edit me-2"></i>Editar Tarifas
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                       <table class="table table-sm align-middle">
                            <thead>
                                <tr class="bg-info bg-opacity-75 text-white">
                                    <th class="text-xs px-2">Equipo</th>
                                    <th class="text-center text-xs px-2">Valor Venta</th>
                                    <th class="text-center text-xs px-2">Costo Unit.</th>
                                    <th class="text-center text-xs px-2">Cantidad</th>
                                    <th class="text-center text-xs px-2">Costo Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <?php foreach($equipos as $equipo): ?>
                                    <tr>
                                        <td class="px-2">
                                            <?php echo htmlspecialchars($equipo['equipo']); ?>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text py-0 px-1">$</span>
                                                <input type="number" 
                                                    class="form-control form-control-sm text-end venta-input py-0"
                                                    data-equipo-id="<?php echo $equipo['alquilerEquiposId']; ?>"
                                                    step="0.01"
                                                    disabled
                                                    value="<?php echo isset($tarifas[$equipo['alquilerEquiposId']]['valor_venta']) ? 
                                                            sprintf('%.2f', $tarifas[$equipo['alquilerEquiposId']]['valor_venta']) : 
                                                            '0.00'; ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text py-0 px-1">$</span>
                                                <input type="number" 
                                                    class="form-control form-control-sm text-end costo-input py-0"
                                                    data-equipo-id="<?php echo $equipo['alquilerEquiposId']; ?>"
                                                    step="0.01"
                                                    disabled
                                                    value="<?php echo isset($tarifas[$equipo['alquilerEquiposId']]['costo']) ? 
                                                            sprintf('%.2f', $tarifas[$equipo['alquilerEquiposId']]['costo']) : 
                                                            '0.00'; ?>">
                                            </div>
                                        </td>
                                        <td class="text-center cantidad-display px-2">
                                            <?php //echo isset($tarifas[$equipo['alquilerEquiposId']]['cantidad']) ? 
                                                    //$tarifas[$equipo['alquilerEquiposId']]['cantidad'] : '0'; ?>
                                        </td>
                                        <td class="text-end costo-total-display px-2">
                                            <?php // Tu código PHP existente ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="fw-bold">
                                <tr class="text-xs">
                                    <td colspan="4" class="text-end pe-3">Costo Total Alquileres:</td>
                                    <td class="text-end px-2" id="granTotal">$0.00</td>
                                </tr>
                                <tr class="text-xs">
                                    <td colspan="4" class="text-end pe-3">Ingreso Total:</td>
                                    <td class="text-end px-2" id="ingresoTotal">$0.00</td>
                                </tr>
                                <tr class="text-xs bg-info bg-opacity-10">
                                    <td colspan="4" class="text-end pe-3">Ganancia Estimada:</td>
                                    <td class="text-end px-2" id="gananciaTotal">$0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-3 d-none" id="botonesEdicion">
                        <button class="btn btn-danger btn-sm me-2" id="cancelarEdicion">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button class="btn btn-primary btn-sm" id="guardarTarifas">
                            <i class="fas fa-save me-2"></i>Guardar Tarifas
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if($tieneTarifas): ?>
        <div class="col d-flex">
          <div class="card flex-fill">
            <div class="card-header">
                <h6>Alquiler/Venta de equipos</h6>
            </div>
            <div class="card-body">
                <!-- Tabla responsiva con scroll horizontal -->
                <div class="table-responsive">
                    <table class="table table-sm align-middle" id="tablaEquipos">
                        <thead>
                            <tr class="bg-info bg-opacity-75 text-white text-xs">
                                <!-- Columnas fijas -->
                                <th class="align-middle py-2">Viajero</th>
                                <th class="align-middle py-2">Tipo</th>
                                <th class="align-middle py-2">Peso</th>
                                <th class="align-middle py-2">Altura</th>
                                <th class="align-middle py-2">Talle</th>
                                <!-- Columnas dinámicas de equipos -->
                                <?php foreach($equipos as $equipo): ?>
                                <th class="text-center align-middle py-2" 
                                    data-equipo-id="<?php echo $equipo['alquilerEquiposId']; ?>"
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="<?php echo ($equipo['equipo']); ?>">
                                    <?php echo $equipo['acronimo']; ?>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <?php foreach($viajeros as $v): ?>
                            <tr class="<?php echo ($v['viajeroTipo']['viajeroTipoId'] == 3) ? 'bg-gray-100' : ''; ?> border-bottom">
                                <!-- Datos del viajero -->
                                <td class="py-1">
                                    <?php if($v['usuario']['apodo']): ?>
                                        <?php echo htmlspecialchars($v['usuario']['apodo']); ?>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($v['usuario']['nombre'] . ' ' . $v['usuario']['apellido']); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="py-1"><?php echo htmlspecialchars($v['viajeroTipo']['viajero_tipo']); ?></td>
                                <td class="py-1"><?php echo htmlspecialchars($v['usuario']['peso'] ?: '-'); ?></td>
                                <td class="py-1"><?php echo htmlspecialchars($v['usuario']['altura'] ?: '-'); ?></td>
                                <td class="py-1"><?php echo htmlspecialchars($v['usuario']['talle'] ?: '-'); ?></td>
                            
                                <?php foreach($equipos as $equipo): ?>
                                <td class="text-center py-1">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="form-check form-switch p-0 m-0">
                                            <input class="form-check-input equipo-switch" 
                                                type="checkbox" 
                                                role="switch"
                                                id="switch-<?php echo $v['viajesUsuariosId']; ?>-<?php echo $equipo['alquilerEquiposId']; ?>"
                                                data-viajero-id="<?php echo $v['viajesUsuariosId']; ?>" 
                                                data-equipo-id="<?php echo $equipo['alquilerEquiposId']; ?>"
                                                <?php echo ($v['viajeroTipo']['viajeroTipoId'] == 3) ? 'disabled' : ''; ?>
                                                <?php echo (isset($equiposSeleccionados[$v['viajesUsuariosId']]) && 
                                                    in_array($equipo['alquilerEquiposId'], $equiposSeleccionados[$v['viajesUsuariosId']])) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
              
            </div>
            <div class="card-footer">
                <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                    <i class="ni ni-bold-left"></i> Volver
                </a>
            </div>
          </div>
        </div>
        <?php endif ?>
      </div>

      <?php include("includes/footer.php") ?>

    </div>

    <?php include("includes/scripts.php") ?>

  </div>


    <script>
        $(document).ready(function() {

            // Variables para guardar los valores originales
            let valoresOriginales = {};
            
            // Función para guardar los valores actuales
            function guardarValoresActuales() {
                valoresOriginales = {};
                $('.costo-input, .venta-input').each(function() {
                    const id = $(this).data('equipo-id');
                    const clase = $(this).hasClass('costo-input') ? 'costo' : 'venta';
                    if (!valoresOriginales[id]) valoresOriginales[id] = {};
                    valoresOriginales[id][clase] = $(this).val();
                });
            }

            // Función para restaurar valores originales
            function restaurarValores() {
                Object.keys(valoresOriginales).forEach(id => {
                    $(`input[data-equipo-id="${id}"].costo-input`).val(valoresOriginales[id].costo);
                    $(`input[data-equipo-id="${id}"].venta-input`).val(valoresOriginales[id].venta);
                });
            }

            // Habilitar modo edición
            $('#editarTarifas').click(function() {
                // Guardar valores actuales antes de habilitar edición
                guardarValoresActuales();
                
                // Habilitar inputs
                $('.costo-input, .venta-input').prop('disabled', false);
                
                // Mostrar botones de guardar/cancelar
                $('#botonesEdicion').removeClass('d-none');
                
                // Ocultar botón de editar
                $(this).addClass('d-none');
            });

            // Cancelar edición
            $('#cancelarEdicion').click(function() {
                // Restaurar valores originales
                restaurarValores();
                
                // Deshabilitar inputs
                $('.costo-input, .venta-input').prop('disabled', true);
                
                // Ocultar botones de guardar/cancelar
                $('#botonesEdicion').addClass('d-none');
                
                // Mostrar botón de editar
                $('#editarTarifas').removeClass('d-none');
                
                // Actualizar totales
                actualizarCantidades();
            });

            // Guardar tarifas
            $('#guardarTarifas').click(function() {
                const tarifas = [];
                
                $('.costo-input').each(function() {
                    const equipoId = $(this).data('equipo-id');
                    const costo = parseFloat($(this).val()) || 0;
                    const venta = parseFloat($(this).closest('tr').find('.venta-input').val()) || 0;
                    
                    tarifas.push({
                        alquilerEquiposId: equipoId,
                        costo: costo,
                        valor_venta: venta
                    });
                });

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: { 
                        viajesId: <?= $_GET[$idNombre] ?>,
                        action: "guardarTarifas",
                        tarifas: JSON.stringify(tarifas) 
                    },
                    success: function(response) {
                        // Guardar los nuevos valores como originales
                        guardarValoresActuales();
                        
                        // Deshabilitar inputs
                        $('.costo-input, .venta-input').prop('disabled', true);
                        
                        // Ocultar botones de guardar/cancelar
                        $('#botonesEdicion').addClass('d-none');
                        
                        // Mostrar botón de editar
                        $('#editarTarifas').removeClass('d-none');
                        
                        // Actualizar totales
                        actualizarCantidades();

                        location.reload(true);
                    },
                    error: function() {
                        toastr.error('Error al guardar las tarifas');
                    }
                });
            });
            
            // Función para contar switches activos por equipo y actualizar cantidades
            function actualizarCantidades() {
    // Primero contamos cuántos equipos completos hay
    const equiposCompletos = $('.equipo-switch[data-equipo-id="8"]:checked').length;

    // Para cada equipo
    $('.costo-input').each(function() {
        const equipoId = $(this).data('equipo-id');
        const row = $(this).closest('tr');
        
        // Si es equipo completo
        if(equipoId === 8) {
            row.find('.cantidad-display').text(equiposCompletos);
            row.find('.costo-total-display').text('-');
            return;
        }
        
        // Para elementos individuales
        // Solo contamos los individuales de las filas que NO tienen equipo completo
        const cantidadIndividual = $('.equipo-switch[data-equipo-id="' + equipoId + '"]:checked').closest('tr')
            .filter(function() {
                return !$(this).find('.equipo-switch[data-equipo-id="8"]').prop('checked');
            }).length;
        
        // La cantidad total es la suma de individuales más los que vienen de equipo completo
        const cantidad = cantidadIndividual + equiposCompletos;
        
        // Actualizar displays
        row.find('.cantidad-display').text(cantidad);
        
        // Calcular costo
        const costo = parseFloat($(this).val()) || 0;
        const costoTotal = cantidad * costo;
        row.find('.costo-total-display').text('$' + costoTotal.toFixed(2));
    });
    
    actualizarTotalesFinancieros();
}

            function actualizarTotalesFinancieros() {
                // Calcular costo total (excluyendo equipo completo)
                let costoTotal = 0;
                $('.costo-total-display').each(function() {
                    const valor = $(this).text();
                    if(valor !== '-') {
                        costoTotal += parseFloat(valor.replace('$', '')) || 0;
                    }
                });
                
                $('#granTotal').text('$' + costoTotal.toFixed(2));
                
                // Obtener ingresos y calcular ganancia vía AJAX
                $.ajax({
                    url: '',
                    method: 'POST',
                    dataType: "json",
                    data: {
                        action: "obtenerIngresosAlquileres",
                        viajesId: <?= $_GET[$idNombre] ?>
                    },
                    success: function(response) {
                        console.log(response);
                        const ingresoTotal = parseFloat(response.ingresoTotal) || 0;
                        const ganancia = ingresoTotal - costoTotal;
                        
                        $('#ingresoTotal').text('$' + ingresoTotal.toFixed(2));
                        $('#gananciaTotal').text('$' + ganancia.toFixed(2));
                    }
                });
            }

            // Evento para inputs de costo y venta
            $('.costo-input, .venta-input').on('input', function() {
                actualizarTotalesFinancieros();
            });

            // Manejar clicks en los switches
            $('.equipo-switch').change(function() {
                const viajeroId = $(this).data('viajero-id');
                const equipoId = $(this).data('equipo-id');
                const isChecked = $(this).prop('checked');
                
                // Si es el switch de "Equipo Completo" (ID 8)
                if(equipoId === 8) {
                    // Marcar o desmarcar todos los switches de esa fila según corresponda
                    $(this).closest('tr').find('.equipo-switch').not(this).prop('checked', isChecked);
                } else {
                    // Si NO es el equipo completo, verificar si todos los individuales están marcados
                    const $row = $(this).closest('tr');
                    const todosChecked = $row.find('.equipo-switch').not('[data-equipo-id="8"]').toArray().every(checkbox => checkbox.checked);
                    
                    // Marcar o desmarcar el switch de equipo completo según corresponda
                    $row.find('.equipo-switch[data-equipo-id="8"]').prop('checked', todosChecked);
                }
                
                // Guardar el estado en la base de datos
                $.ajax({
                    url: '',
                    method: 'POST',
                    data: {
                        action: "guardarAlquilerEquipo",
                        viajesId: <?= $_GET[$idNombre] ?>, 
                        viajesUsuariosId: viajeroId,
                        alquilerEquiposId: equipoId,
                        estado: isChecked ? 1 : 0
                    },
                    success: function(response) {
                        //toastr.success('Guardado correctamente');
                        actualizarCantidades();
                    },
                    error: function() {
                        //toastr.error('Error al guardar');
                        $(this).prop('checked', !isChecked);
                        actualizarCantidades();
                    }
                });
            });

            // Actualizar cantidades al cargar la página
            actualizarCantidades();
        });
    </script>

  <script>
    // Fecha de partida desde PHP
    var fechaPartida = "<?php echo date('Y-m-d H:i:s', strtotime($viaje['fecha_inicio'])); ?>";


    function updateStatusTab() {
      var partida = new Date(fechaPartida);
      var ahora = new Date();
      var diferencia = partida - ahora;

      var statusTab = document.getElementById("time-remaining");

      if (diferencia <= 0) {
        statusTab.innerHTML = "Finalizado";
      } else {
        var dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
        var horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
        var segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

        statusTab.innerHTML = dias + "d " + horas + "h " + minutos + "m " + segundos + "s restantes";
      }
    }

    // Actualiza la solapa cada segundo
    setInterval(updateStatusTab, 1000);
    updateStatusTab();


  </script>

<style>
.input-group-sm > .form-control {
    min-height: 24px;
    height: 24px;
    font-size: 0.75rem;
}

.input-group-sm > .input-group-text {
    min-height: 24px;
    height: 24px;
    font-size: 0.75rem;
}
.table-bordered tbody tr:last-child td {
    border-bottom: 1px solid #dee2e6 !important;
}

.table-bordered td,
.table-bordered th {
    border-right: 1px solid #dee2e6 !important;
    border-left: 1px solid #dee2e6 !important;
}

.table-bordered tbody tr td:last-child {
    border-right: 1px solid #dee2e6 !important;
}
/* Estilos personalizados para los switches */
.form-switch {
    padding-left: 0; /* Elimina el padding predeterminado */
}

.form-switch .form-check-input {
    margin: 0 !important; /* Elimina márgenes */
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.form-switch .form-check-input:checked {
    background-color:rgb(30, 113, 223);
    border-color: rgb(30, 113, 223);
}

.form-switch .form-check-input:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Efecto hover */
.form-switch .form-check-input:not(:disabled):hover {
    cursor: pointer;
    box-shadow: 0 0 0 0.2rem rgba(45, 206, 137, 0.25);
}

/* Asegura que el contenedor tenga altura completa */
.table td {
    vertical-align: middle;
}
</style>
</body>

</html>