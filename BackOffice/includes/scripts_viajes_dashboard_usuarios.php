

<script type="text/javascript">

  var viajeroEliminarId;

  function confirmarEliminarViajero(id){
    $("#modal_eliminar_viajero").modal("show");
    viajeroEliminarId = id;
  }

  function validarFormNuevoViajero(){

    console.log($("#viajesUsuariosId").val());

    var altaEditar = isEmpty($("#viajesUsuariosId").val()) ? "altaViajero" : "editarViajero";
    
    if(altaEditar == "altaViajero" && (!usuarioId || usuarioId == undefined)){
      var error = 'Hay que seleccionar un viajero'; // reemplaza con el mensaje de error real
    }
    
    var viajeroTipoId = $("#viajeroTipoId").val();
    var venta_paquete = $("#venta_paquete").val();
    
    if(!viajeroTipoId || viajeroTipoId == undefined){
      var error = 'Hay que seleccionar el tipo de viajero'; // reemplaza con el mensaje de error real
    }

    // if(!venta_paquete || venta_paquete == 0 || venta_paquete == ""){
    //   var error = 'Ingresá el costo del paquete para este viajero'; // reemplaza con el mensaje de error real
    // }

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

    var viajesUsuariosId = $("#viajesUsuariosId").val();
    $.ajax({
      type: 'POST',
      url: '',
      data: {
        viajesUsuariosId: viajesUsuariosId, 
        usuarioId: usuarioId, 
        action:altaEditar,
        viajesId:<?= $viaje[$idNombre] ?>,
        viajeroTipoId:viajeroTipoId,
        venta_paquete:venta_paquete,
        habilitado_sys:1
      },
      dataType: 'text',
      success: function(data) {
        
        if(data == "ok")
          redirectConParametro("seccion", "viajeros");
        else{
          $('#error_div').removeClass('fade').addClass('show');
          $('#error-text').text(data);
        }
      },
      error: function(e, i){
        
      }
    });

  }


  function editarViajero(viajesUsuariosId, viajeroTipoId, venta_paquete, nombre){
    $("#viajesUsuariosId").val(viajesUsuariosId);
    $("#modal-form-viajeros").modal("show");
    $("#formNuevoViajero input[name='viajesUsuariosId']").val(viajesUsuariosId);
    $("#viajeroTipoId").val(viajeroTipoId).change();
    $("#venta_paquete").val(venta_paquete);

    $("#titulo_editar_viajero").html("Editar viajero");

    $("#buscar").val(nombre);

    $('#buscar').prop("disabled", true);

    $('#error_div').removeClass('show').addClass('fade');
  }

  function altaViajero(viajesUsuariosId, viajeroTipoId, venta_paquete){

    $('#error_div').removeClass('show').addClass('fade');

    usuarioId = null;

    $('#buscar').prop("disabled", false);

    $("#viajesUsuariosId").val(null);
    $("#modal-form-viajeros").modal("show");
    $("#formNuevoViajero input[name='viajesUsuariosId']").val(null);

    $("#venta_paquete").val(null);
    $("#titulo_editar_viajero").html("Alta viajero");
    $("#buscar").val(null);

    $("#viajeroTipoId").val(null);
  }

  $('#deseleccionar').click(function(){
    $('#error_div').removeClass('show').addClass('fade');
    $('#buscar').prop("disabled", false);
    $('#deseleccionar').prop("disabled", true);
    $('#buscar').val("");
    usuarioId = null;
    $("#viajeroTipoId").val("");
    $('#deudaId').empty();
  });

  function eliminarViajero(){

    $.ajax({
      type: 'POST',
      url: '',
      data: {
        usuarioId: viajeroEliminarId, 
        action:"eliminarViajero",
        viajesId:<?= $viaje[$idNombre] ?>,
      },
      dataType: 'text',
      success: function(data) {
        if(data == "ok")
          redirectConParametro("seccion", "viajeros");
      },
      error: function(e, i){
        
      }
    });

  }

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
    
  });
</script>