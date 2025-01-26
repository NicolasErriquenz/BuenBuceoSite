

<script type="text/javascript">
  function altaViajeHospedaje(){
    var hospedajesId = $("#hospedajesId").val();

    if(!hospedajesId || hospedajesId == undefined){
      var error = 'Hay que seleccionar un hospedaje';
    }

    if (error) {
      $('#error_div_hospedaje').removeClass('fade').addClass('show');
      $('#error-text-hospedaje').text(error);
      return;
    } else {
      $('#error_div_hospedaje').removeClass('show').addClass('fade');
    }

    $.ajax({
      type: 'POST',
      url: '',
      data: {
        hospedajesId: hospedajesId, 
        action:"altaViajeHospedaje",
        viajesId: "<?php echo $_GET[$idNombre] ?>",
      },
      dataType: 'text',
      success: function(data) {
        if(data == "ok")
          redirectConParametro("sub_seccion", "hospedajes");
        else{
          $('#error_div_hospedaje').removeClass('fade').addClass('show');
          $('#error-text-hospedaje').text(data);
        }
      }
    });
  }

  var hospedajeSeleccionado = null;

  $(document).on('click', '.celda-clickeable', function() {
    var baseId = $(this).attr('data-base');
    hospedajeSeleccionado = $(this).attr('data-hospedajesid');
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

  function eliminarTarifa() {
    
    var baseId = coordenadas.base;
    var tipoId = coordenadas.tipo;

    $.ajax({
      type: 'POST',
      url: '',
      data: {
        baseHospedajeId: baseId,
        tipoHospedajeId: tipoId,
        action:"eliminarTarifa",
        hospedajesId: hospedajeSeleccionado
      },
      success: function(data) {
        if (data == 'ok') {
          $(`.celda-clickeable[data-base="${baseId}"][data-tipo="${tipoId}"]`).html(`
            <div class="nombre"></div>
            <div class="precio"></div>
          `);

          $('#modal-agregar').modal('hide');
          redirectConParametro("sub_seccion", "hospedajes");
        } else {
          console.log('Error al eliminar la tarifa');
        }
      }
    });
  };

  function guardarTarifa(){
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
        hospedajesId: hospedajeSeleccionado // Reemplaza con el ID real del hospedaje
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
        redirectConParametro("sub_seccion", "hospedajes");
      },
      error: function(xhr, status, error) {
        mostrarError('Error al guardar tarifa: ' + error);
      }
    });
    
  };

  function mostrarError(mensaje) {
    var errorDiv = $('#modal-agregar .error');
    if (errorDiv.length === 0) {
      errorDiv = $('<div class="error alert alert-danger"><i class="fas fa-exclamation-triangle"></i></div>');
      $('#modal-agregar .modal-body').append(errorDiv);
    }
    errorDiv.html(`<i class="fas fa-exclamation-triangle"></i> ${mensaje}`);
  }

</script>