<script>
    $('#documentacionTipoId').change(function() {
       var tipoId = $(this).val();
       var alcance = $(this).find('option:selected').parent('optgroup').attr('label');
       
       // Mostrar/ocultar selector de usuario según el tipo de documento
       if (alcance == 'Documentos Generales') {
           $('#usuarioContainer').hide();
           $('#usuarioId').prop('required', false);
       } else {
           $('#usuarioContainer').show();
           $('#usuarioId').prop('required', true);
       }
    });

    function cargarDocumentacion(usuarioId = null) {
       // Limpiar form
       document.getElementById('formDocumentacion').reset();
       document.getElementById('error_div_doc').style.display = 'none';
       
       // Si viene usuarioId, seleccionarlo
       if(usuarioId) {
           document.getElementById('usuarioId').value = usuarioId;
           document.getElementById('usuarioContainer').style.display = '';
       } else {
           document.getElementById('usuarioContainer').style.display = 'none';
       }

       new bootstrap.Modal(document.getElementById('modalDocumentacion')).show();
    }

    // Añadir evento para limpiar al cerrar
    document.getElementById('modalDocumentacion').addEventListener('hidden.bs.modal', function () {
       document.getElementById('formDocumentacion').reset();
       document.getElementById('error_div_doc').style.display = 'none';
    });

    function filtrarUsuarios(busqueda) {
       const cards = document.querySelectorAll('#gridUsuarios .col-md-4');
       busqueda = busqueda.toLowerCase();
       
       cards.forEach(card => {
           const nombre = card.querySelector('h6').textContent.toLowerCase();
           const tipo = card.querySelector('.text-muted').textContent.toLowerCase();
           
           if (nombre.includes(busqueda) || tipo.includes(busqueda)) {
               card.style.display = '';
           } else {
               card.style.display = 'none';
           }
       });
    }

    function filtrarUsuarios(texto) {
       // Obtener el input
       const input = document.getElementById('buscarUsuario');
       
       // Agregar evento a la x nativa del input search
       input.addEventListener('search', function() {
           filtrarUsuarios('');
       });

       texto = texto.toLowerCase().trim();
       const cards = document.querySelectorAll('.col-md-4');
       
       cards.forEach(card => {
           if (!card.dataset.nombre) return;
           const apodo = card.querySelector('h6')?.textContent.toLowerCase() || '';
           const tipo = card.querySelector('.text-muted')?.textContent.toLowerCase() || '';
           const nombreCompleto = card.dataset.nombre.toLowerCase();
           
           if (apodo.includes(texto) || tipo.includes(texto) || nombreCompleto.includes(texto)) {
               card.style.display = '';
           } else {
               card.style.display = 'none';
           }
       });
    }

    function limpiarBusqueda() {
       document.getElementById('buscarUsuario').value = '';
       filtrarUsuarios('');
    }

   function guardarDocumentacion() {
        const formData = new FormData($('#formDocumentacion')[0]);
        
        if (!document.getElementById('documento').files[0]) {
            mostrarError("Debe seleccionar un archivo");
            return;
        }

        $.ajax({
            type: 'POST',
            url: '',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'text',
            success: function(data) {
                if(data == "OK") {
                    redirectConParametro("sub_seccion", "documentacion");
                } else {
                    mostrarError(data);
                }
            },
            error: function(e) {
                mostrarError("Error al procesar la solicitud");
            }
        });
    }

    function mostrarError(mensaje) {
       const errorDiv = document.getElementById('error_div_doc');
       errorDiv.style.opacity = '1';
       errorDiv.style.display = 'block';
       document.getElementById('error-text-doc').innerHTML = mensaje;
    }

    let docIdEliminar;

    function eliminarDocumento(id) {
        docIdEliminar = id;
        new bootstrap.Modal(document.getElementById('modalEliminarDoc')).show();
    }

    function confirmarEliminar() {
        $.ajax({
            type: 'POST',
            url: '',
            data: {
                documentacionId: docIdEliminar,
                action: 'eliminarDocumento'
            },
            success: function(response) {
                const data = JSON.parse(response);
                if(data.status === 'success') {
                    redirectConParametro("sub_seccion", "documentacion");
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                    new bootstrap.Modal(document.getElementById('modalError')).show();
                }
            }
        });
    }
</script>