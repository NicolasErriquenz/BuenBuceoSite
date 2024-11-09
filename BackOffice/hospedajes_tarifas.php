<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "hospedaje_habitaciones_tarifas";
  $idNombre = "hospedajesId";
  $goBackLink = "hospedajes.php";
  $item = getItem("hospedajes", $idNombre, $_GET[$idNombre]);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "guardarTarifa" ) {
    echo guardarHospedajeHabitacionesTarifas($_POST);
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarTarifa" ) {
    echo eliminarHospedajeHabitacionesTarifas($_POST);
    die();
  }

  $pais = getPais($item["paisId"]);
  $title = "Editar tarifas";
  $subtitle = "Tarifas ".strtoupper($item["nombre"])." (".$pais.")";
  $action = "editar";
  $tarifas = getHospedajeHabitacionesTarifas($_GET["hospedajesId"]);
  
  

  $bases = getHospedajeHabitacionesBases();
  $tipos = getHospedajeHabitacionesTipos();
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
                <h6 class="float-start"><?php echo $subtitle ?></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <form action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-body">
                        
                        <div class="table-responsive">
                          <table class="table align-items-center mb-0">
                            <thead>
                              <tr>
                                <th></th>
                                <?php foreach ($tipos as $tipo) { ?>
                                  <th><?= $tipo['nombre'] ?></th>
                                <?php } ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($bases as $base) { ?>
                                <tr>
                                  <th><?= $base['nombre'] ?></th>
                                  <?php foreach ($tipos as $tipo) { ?>
                                    <?php 
                                      $tarifa = array_filter($tarifas, function($t) use ($base, $tipo) {
                                        return $t['base'] == $base['nombre'] && $t['tipo'] == $tipo['nombre'];
                                      });
                                      $tarifa = reset($tarifa);
                                    ?>
                                    <td>
                                      <div class='celda-clickeable' 
                                           data-base='<?= $base['baseHospedajeId'] ?>' 
                                           data-tipo='<?= $tipo['tipoHospedajeId'] ?>' 
                                           data-base-nombre='<?= $base['nombre'] ?>' 
                                           data-tipo-nombre='<?= $tipo['nombre'] ?>'>
                                        <?php if (isset($tarifa['precio'])): ?>
                                          <div class="nombre"><?= $tarifa['alias'] ?></div>
                                          <div class="precio">$<?= $tarifa['precio'] ?></div>
                                        <?php else: ?>
                                          <div class="nombre"></div>
                                          <div class="precio"></div>
                                        <?php endif; ?>
                                      </div>
                                    </td>
                                  <?php } ?>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="card-footer d-flex justify-content-between">
                        <input type="hidden" name="action" value="<?php echo $action ?>">
                        <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                          <i class="ni ni-bold-left"></i> Volver
                        </a>
                        <!-- <button type="submit" class="btn btn-sm bg-gradient-primary">
                          <i class="ni ni-check-bold"></i> Guardar
                        </button> -->
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

      <div class="modal fade" id="modal-agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Valores de la tarifa - </h5>
      </div>
      <div class="modal-body">
        <form id="form-agregar">
          <div class="form-group">
            <label>Precio:</label>
            <input type="number" id="precio" name="precio" class="form-control">
          </div>
          <div class="form-group">
            <label>Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Por ej. Estudio Single">
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <div>
          <button id="btn-eliminar" class="btn btn-danger">Eliminar</button>
          <button id="btn-guardar" class="btn btn-primary ms-auto">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>
      

    </div>
  </main>
  
  <?php include("includes/scripts.php") ?>

  <script>

    

    $(document).on('click', '.celda-clickeable', function() {
      var baseId = $(this).attr('data-base');
      var tipoId = $(this).attr('data-tipo');
      var baseNombre = $(this).attr('data-base-nombre');
      var tipoNombre = $(this).attr('data-tipo-nombre');
      var precio = $(this).find('.precio').text().replace(/[^\d.,]/g, '');
      var nombre = $(this).find('.nombre').text(); // Obtener nombre
      
      // Establecer título del modal
      $('#modal-agregar .modal-title').text('Valores de la tarifa (' + baseNombre + ' - ' + tipoNombre + ")");
      
      // Precompletar campos del modal
      $('#modal-agregar #precio').val(precio);
      $('#modal-agregar #nombre').val(nombre);
      
      if(precio != "" && nombre != "")
        $("#btn-eliminar").show();
      else
        $("#btn-eliminar").hide();

      // Mostrar modal
      $('#modal-agregar').modal('show');
      
      // Guardar coordenadas de la celda
      coordenadas = {
        base: baseId,
        tipo: tipoId
      };
    });

    $('#btn-eliminar').off('click').on('click', function() {
      
      var baseId = coordenadas.base;
      var tipoId = coordenadas.tipo;

      $.ajax({
        type: 'POST',
        url: '',
        data: {
          baseHospedajeId: baseId,
          tipoHospedajeId: tipoId,
          action:"eliminarTarifa",
          hospedajesId: <?php echo $_GET["hospedajesId"] ?>
        },
        success: function(data) {
          if (data == 'ok') {
            $(`.celda-clickeable[data-base="${baseId}"][data-tipo="${tipoId}"]`).html(`
              <div class="nombre"></div>
              <div class="precio"></div>
            `);

            $('#modal-agregar').modal('hide');
          } else {
            console.log('Error al eliminar la tarifa');
          }
        }
      });
    });

    $(document).on('click', '#btn-guardar', function() {
      var precio = $('#precio').val();
      var nombre = $('#nombre').val();
      var baseId = coordenadas.base;
      var tipoId = coordenadas.tipo;
      
       // Validar precio
      if (precio === '') {
        mostrarError('Precio', 'El precio no puede estar vacío');
        return;
      }
      if (!/^[\d]+(\.[\d]+)?$/.test(precio)) {
        mostrarError('Precio', 'El precio debe ser un número');
        return;
      }
      
      // Validar nombre
      if (nombre === '') {
        mostrarError('Nombre', 'El nombre no puede estar vacío');
        return;
      }
      
      // Enviar datos mediante AJAX
      $.ajax({
        type: 'POST',
        url: '',
        dataType: "text",
        data: {
          action:"guardarTarifa",
          baseHospedajeId: baseId,
          tipoHospedajeId: tipoId,
          precio: precio,
          alias: nombre,
          hospedajesId: <?php echo $_GET["hospedajesId"] ?> // Reemplaza con el ID real del hospedaje
        },
        success: function(data) {

          // Actualizar celda con valores
          $(`.celda-clickeable[data-base="${baseId}"][data-tipo="${tipoId}"]`).html(`
            <div class="nombre">${nombre}</div>
            <div class="precio">$${precio}</div>
          `);
          $('#form-agregar')[0].reset();
          // Ocultar modal
          $('#modal-agregar').modal('hide');
        },
        error: function(xhr, status, error) {
          mostrarError('Error al guardar tarifa: ' + error);
        }
      });
      
    });

    function mostrarError(mensaje) {
      var errorDiv = $('#modal-agregar .error');
      if (errorDiv.length === 0) {
        errorDiv = $('<div class="error alert alert-danger"><i class="fas fa-exclamation-triangle"></i></div>');
        $('#modal-agregar .modal-body').append(errorDiv);
      }
      errorDiv.html(`<i class="fas fa-exclamation-triangle"></i> ${mensaje}`);
    }

    $(document).ready(function() {
        
      
    });

  </script>
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    table tr:last-child {
      border-bottom: 1px solid #ddd;
    }

    .celda-clickeable {
      width: 100%;
      height: 40px; /* altura fija */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      box-sizing: border-box;
    }

    .celda-clickeable .nombre {
      font-weight: bold;
    }

    .celda-clickeable .precio {
      color: #666;
    }

    .celda-clickeable:hover {
      background-color: #e5e5e5;
    }

    .error {
      margin-top: 10px;
      padding: 5px 10px;
      border-radius: 5px;
      background-color: #f8d7da;
      color: #842029;
      font-size: 12px;
      text-align: center;
      display: flex;
      align-items: center;
      color:white;
      justify-content: center;
    }

    .error i {
      font-size: 16px;
      margin-right: 5px;

    }
  </style>
</body>

</html>