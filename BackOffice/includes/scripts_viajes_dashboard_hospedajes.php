

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
          redirectConParametro("seccion", "hospedajes");
        else{
          $('#error_div_hospedaje').removeClass('fade').addClass('show');
          $('#error-text-hospedaje').text(data);
        }
      }
    });
  }
</script>