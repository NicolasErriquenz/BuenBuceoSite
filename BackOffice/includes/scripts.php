


<!--   Core JS Files   -->
<script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="assets/js/buttons.js"></script>
<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/argon-dashboard.min.js?v=2.1.0"></script>
<script src="assets/js/plugins/chartjs.min.js"></script>

<script src="assets/js/bootstrap5-toggle.ecmas.min.js"></script>

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>

<script type="text/javascript">

  var lang = {
      "decimal": "",
      "emptyTable": "No hay información",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
      "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
      "infoFiltered": "(Filtrado de _MAX_ total entradas)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar _MENU_ Entradas",
      "loadingRecords": "Cargando...",
      "processing": "Procesando...",
      "search": "Buscar:",
      "zeroRecords": "Sin resultados encontrados",
      "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      }
  };
  $(document).ready(function() {

    $('#tableDataTables').DataTable({
      language: lang,
      order: [[0, 'desc']]
    });

  });

  function redirectConParametro(parametro, valor) {
     let urlActual = window.location.href;
     let regex = new RegExp(`[?&]${parametro}=([^&]*)`);
     
     if (urlActual.includes('?')) {
         if (urlActual.match(regex)) {
             urlActual = urlActual.replace(regex, `$&=${valor}`);
         } else {
             urlActual += `&${parametro}=${valor}`;
         }
     } else {
         urlActual += `?${parametro}=${valor}`;
     }
     
     window.location.href = urlActual;
  }

  function isEmpty(valor) {
    return (
      valor === undefined ||
      valor === null ||
      valor === "" ||
      valor === NaN ||
      (typeof valor === "object" && Object.keys(valor).length === 0) ||
      (Array.isArray(valor) && valor.length === 0)
    );
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
      new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>