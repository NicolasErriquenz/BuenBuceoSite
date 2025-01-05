

<div class="card mt-4 shadow-none">
  <div class="card-header pb-0">
    <div class="row">
      <div class="col">
        <h6 class="float-start"></h6>
        <div class="float-end">
          <button class="btn btn-sm btn-icon bg-gradient-primary float-end mb-0" onclick="javascript:abrirModalCostos('altaViajeCosto')">
              <i class="ni ni-fat-add"></i> COSTO
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="card-body pt-0">
    <div class="row">
      <div class="col">
        <div class="custom-scroll-container">
          <div class="table-responsive custom-pagination" style="margin: 0px !important;">
            <?php if (empty($costos)): ?>
              <div class="alert text-center">
                <i class="fas fa-info-circle fa-2x"></i>
                <p>No hay registros para mostrar.</p>
                <p>Puedes agregar un nuevo costo haciendo clic en el botón 
                  <button class="btn btn-xs btn-icon bg-gradient-primary" onclick="javascript:abrirModalCostos('altaViajeCosto')" style="margin-top:13px;">
                      <i class="ni ni-fat-add"></i> COSTO
                  </button>
                </p>
              </div>
            <?php else: ?>
              <table class="table mb-0 dataTable">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subrubro</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comentario</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alcance</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Viajeros</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Costo total</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($costos as $item): ?>
                  <tr>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["viajeCostoId"] ?>
                      </p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["subrubro"] ?>
                      </p>
                    </td>
                    <td>
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["comentario"] ?>
                      </p>
                    </td>
                    <td class="text-center">
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["simbolo"] ?> <?php echo $item["monto"] ?>
                      </p>
                    </td>
                    <td class="text-center">
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["soloBuzos"] == "1" ? "Buzos" : "Todos" ?>
                      </p>
                    </td>
                    <td class="text-center">
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["cantidad_personas"]?>
                      </p>
                    </td>
                    <td class="text-center">
                      <p class="text-sm font-weight-bold mb-0">
                      <?php echo $item["simbolo"] ?> <?php echo $item["monto"] * $item["cantidad_personas"] ?>
                      </p>
                    </td>
                    <td class="align-middle text-center">
                        <a href="javascript:confirmarRefrescarCosto(<?php echo $item["viajeCostoId"] ?>)"
                           class="btn btn-icon btn-primary btn-xs mb-0"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh a todos los usuarios">
                          <span class="btn-inner--icon"><i class="fa fa-refresh"></i></span>
                        </a>
                        <a href="javascript:abrirModalCostos('editarViajeCosto', <?php echo $item["viajeCostoId"] ?>)"
                           class="btn btn-icon btn-secondary btn-xs mb-0"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                          <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                        </a>
                        <a href="javascript:confirmarEliminarCosto(<?php echo $item["viajeCostoId"] ?>)"
                           class="btn btn-icon btn-outline-danger btn-xs mb-0"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                          <span class="btn-inner--icon"><i class="fa fa-times"></i></span>
                        </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-costo" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCostoTitle">Agregar costo</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:black">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="card card-plain">
          <div class="card-body">
            <form role="form text-left" method="post" action"" id="formNuevoCosto">
              <input type="hidden" value="agregarCosto" name="actionCosto" id="actionCosto">
              <input type="hidden" value="" name="viajeCostoId" name="viajeCostoId">
              <p class="text-uppercase text-sm">Categorías del costo</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="rubro" class="form-control-label">Rubro</label>
                    <select id="pagosRubroId" name="pagosRubroId" class="form-control custom-select" disabled>
                      <option value="2" selected>Viajes</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="subrubro" class="form-control-label">Subrubro</label>
                    <select id="pagosSubrubroId" name="pagosSubrubroId" class="form-control">
                      <option value="" selected disabled>Seleccione un subrubro</option>
                        <?php foreach ($subrubros as $sub): ?>
                          <option value="<?php echo $sub['pagosSubrubroId']; ?>">
                          <?php echo $sub['subrubro']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Datos del costo</p>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-control-label" style="display: block;">Moneda</label>
                  <div class="btn-group btn-group-toggle w-100" data-bs-toggle="buttons">
                    <?php foreach ($monedas as $moneda): ?>
                    <label class="btn w-100 <?php echo $moneda['monedaId'] == 1 ? "active" : ""; ?>">
                      <input type="radio" name="monedaId" value="<?php echo $moneda['monedaId']; ?>" <?php echo $moneda['monedaId'] == 1 ? "selected" : ""; ?>">
                      <?php echo $moneda['moneda']; ?>
                    </label>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-control-label">Monto</label>
                    <div class="input-group mb-4">
                      <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                      <input type="number" step="any" 
                            id="monto" name="monto" 
                            placeholder="00.00"
                            value="" 
                            class="form-control" style="text-align: right;">
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
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
              </div>

              <div class="form-group my-auto">
                  <label class="form-control-label">Alcance</label>
                  <input name="soloBuzos" id="soloBuzos" value="0" type="hidden">
                  <div class="d-grid">
                      <button id="toggleButton" 
                              type="button" 
                              class="btn btn-secondary w-100" 
                              style="min-height: 42px;">
                          Todos
                      </button>
                  </div>
              </div>


              <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea id="comentario" name="comentario" class="form-control"></textarea>
              </div>

              <div class="form-check form-switch">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" 
                      class="habilitado-checkbox"
                      name="aplicarCostoViajeros"
                      id="aplicarCostoViajeros"
                      checked>
                  Aplicar costo a los viajeros actuales
                </label>
              </div>
              
              <div class="row">
                <div class="text-center alert alert-danger fade mb-0 mt-2" id="error_div_costos">
                  <span class="alert-icon"><i class="fa fa-warning"></i></span>
                  <span id="error-text-costos"></span>
                </div>
              </div>
              <div class="text-center">
                <button type="button" onclick="javascript:guardarCosto()" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">GUARDAR</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script type="text/javascript">
  var costos =(<?php echo json_encode($costos)?>);
  console.log(costos);
  var viajeCostoId;
  
  function confirmarEliminarCosto(id){
    $("#modal_promt").modal("show");
    viajeCostoId = id;
  }

  function confirmarRefrescarCosto(id){
    $("#modal_promt_refresh_costo_usuarios").modal("show");
    viajeCostoId = id;
  }

  function aplicarViajeCostoaTodosViajeros(){
    $.ajax({
      type: 'POST',
      url: '',
      data: {
        viajeCostoId: viajeCostoId, 
        action:"aplicarViajeCostoaTodosViajeros",
        viajesId:<?= $viaje[$idNombre] ?>,
      },
      dataType: 'text',
      success: function(data) {
        if(data == "ok")
          redirectConParametro("sub_seccion", "costos_listado");
        else{
          $('#error_div_costos').removeClass('fade').addClass('show');
          $('#error-text-costos').text(data);
        }
      },
      error: function(e, i){
        
      }
    })
  };

  function eliminarViajeCostos(){
    $.ajax({
      type: 'POST',
      url: '',
      data: {
        viajeCostoId: viajeCostoId, 
        action:"eliminarViajeCostos",
        viajesId:<?= $viaje[$idNombre] ?>,
      },
      dataType: 'text',
      success: function(data) {
        if(data == "ok")
          redirectConParametro("sub_seccion", "costos_listado");
        else{
          $('#error_div_costos').removeClass('fade').addClass('show');
          $('#error-text-costos').text(data);
        }
      },
      error: function(e, i){
        
      }
    })
  };

  
  var viajeCostoId;
  var accion = accion;

  function abrirModalCostos(accion, vcId){
    
    $("#actionCosto").val(accion);

    if(accion == "altaViajeCosto"){
      $("#modalCostoTitle").html("Agregar costo");

      viajeCostoId = null;
      $("#pagosSubrubroId").val(null);
      $("#monto").val(null);
      $("#cotizacion").val(null);

    }else{
      
      viajeCostoId = (vcId);
      $("#modalCostoTitle").html("Editar costo");
      var costo = buscarPorViajeCostoId(costos, vcId);
      
      $("#pagosSubrubroId").val(costo.pagosSubrubroId);
      $("#monto").val(costo.monto);
      $("#cotizacion").val(costo.cotizacion);
      $("#comentario").val(costo.comentario);

      $("#soloBuzos").val(costo.soloBuzos);
      setToggleState();
    }

    $("#modal-costo").modal("show");
  }

  function buscarPorViajeCostoId(data, viajeCostoId) {
      return data.find((element) => element.viajeCostoId == viajeCostoId);
  }

  function guardarCosto(){

    var id = viajeCostoId;
    var pagosSubrubroId = $("#pagosSubrubroId").val();
    var monedaId = $('input[name="monedaId"]:checked').val();
    var monto = $("#monto").val();
    var cotizacion = $("#cotizacion").val();
    var soloBuzos = $('#soloBuzos').val();
    var comentario = $("#comentario").val();
    var aplicarCostoViajeros = $('input[name="aplicarCostoViajeros"]:checked').val();
    
    if(!pagosSubrubroId || pagosSubrubroId == undefined)
      var error = 'Hay que seleccionar un subrubro';

    if(!monedaId || monedaId == undefined)
      var error = 'Hay que seleccionar el tipo de moneda"';

    if(!monto || monto == "")
      var error = 'Ingresa monto';

    if(!monto || monto == "")
      var error = 'Ingresa monto';

    if (error) {
      $('#error_div_costos').removeClass('fade').addClass('show');
      $('#error-text-costos').text(error);
      return;
    } else {
      $('#error_div_costos').removeClass('show').addClass('fade');
    }

    $.ajax({
      type: 'POST',
      url: '',
      data: {
        viajeCostoId: id,
        pagosSubrubroId: pagosSubrubroId, 
        action:$("#actionCosto").val(),
        viajesId:<?= $viaje[$idNombre] ?>,
        monedaId:monedaId,
        monto:monto,
        cotizacion:cotizacion,
        soloBuzos:soloBuzos,
        comentario:comentario,
        aplicarCostoViajeros:aplicarCostoViajeros,
      },
      dataType: 'text',
      success: function(data) {
        if(data == "ok")
          redirectConParametro("sub_seccion", "costos_listado");
        else{
          $('#error_div_costos').removeClass('fade').addClass('show');
          $('#error-text-costos').text(data);
        }
      },
      error: function(e, i){
        
      }
    });
  }

  var soloBuzos;
  const toggleButton = document.getElementById('toggleButton');
  const hiddenInput = document.getElementById('soloBuzos'); // Seleccionamos el input hidden

  document.addEventListener('DOMContentLoaded', function () {

    toggleButton.addEventListener('click', function () {
        hiddenInput.value = hiddenInput.value == "1" ? "0" : "1";
        setToggleState();
    });

    
  });

  // Función para actualizar el estado visual y funcional
  function setToggleState() {
    if (hiddenInput.value == "1") {
        toggleButton.classList.remove('btn-secondary');
        toggleButton.classList.add('btn-info');
        toggleButton.textContent = 'Sólo buzos';
    } else {
        toggleButton.classList.remove('btn-info');
        toggleButton.classList.add('btn-secondary');
        toggleButton.textContent = 'Todos';
    }
  }

</script>

