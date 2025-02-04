<!-- Header con botón de agregar -->
<div class="row mb-4">
   <div class="col-12">
       <div class="d-flex justify-content-between align-items-center">
           <h6 class="mb-0">Documentación del Viaje</h6>
           <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDocumentacion">
               <i class="fas fa-plus me-2"></i>Agregar Documento
           </button>
       </div>
   </div>
</div>

<!-- Contenido principal -->
<?php if(empty($usuarios)): ?>
    <div class="row">
       <div class="col-12">
           <div class="card">
               <div class="card-body text-center py-5">
                   <div class="icon icon-shape icon-lg bg-light text-dark rounded-circle mb-3">
                       <i class="ni ni-folder-17"></i>
                   </div>
                   <h5>No hay documentación cargada</h5>
                   <p class="text-muted">Comienza agregando documentos para los viajeros.</p>
                   <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDocumentacion">
                       <i class="fas fa-plus me-2"></i>Agregar Primer Documento
                   </button>
               </div>
           </div>
       </div>
    </div>
<?php else: ?>
    <div class="row g-3">
       <?php foreach($usuarios as $usuario): 
           $docsUsuario = array_filter($documentacion, function($doc) use ($usuario) {
               return $doc['usuarioId'] == $usuario['usuarioId'] && $doc['alcance'] == 'USUARIO';
           });
           
           $docsViajero = array_filter($documentacion, function($doc) use ($usuario) {
               return $doc['usuarioId'] == $usuario['usuarioId'] && $doc['alcance'] == 'VIAJERO';
           });
       ?>
       <div class="col-md-4">
           <div class="card">
               <!-- Header con foto y nombre -->
               <div class="card-header p-3">
                   <div class="d-flex align-items-center">
                       <div class="avatar avatar-lg rounded-circle me-3">
                           <img src="_recursos/profile_pics/<?php echo !empty($usuario['imagen']) ? $usuario['imagen'] : 'generic_user.png'; ?>" 
                                alt="Perfil" 
                                class="w-100 border-radius-lg shadow-sm">
                       </div>
                       <div>
                           <h6 class="mb-0" data-bs-toggle="tooltip" 
                               title="<?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?>">
                               <?php echo $usuario['apodo']; ?>
                           </h6>
                           <p class="text-sm text-muted mb-0"><?php echo $usuario['viajero_tipo']; ?></p>
                       </div>
                   </div>
               </div>

               <!-- Cuerpo con los documentos -->
               <div class="card-body p-3">
                   <!-- Documentos de Usuario -->
                   <div class="mb-3">
                       <h6 class="text-sm mb-2">Documentos Personales</h6>
                       <div class="list-group list-group-flush">
                           <?php if(empty($docsUsuario)): ?>
                               <p class="text-sm text-muted mb-0">No hay documentos cargados</p>
                           <?php else: foreach($docsUsuario as $doc): ?>
                               <div class="list-group-item border-0 px-0 py-2">
                                   <div class="d-flex align-items-center">
                                       <div class="icon icon-shape bg-info text-white rounded-circle shadow me-3">
                                           <i class="ni ni-single-copy-04"></i>
                                       </div>
                                       <div class="d-flex flex-column">
                                           <h6 class="mb-1 text-sm"><?php echo $doc['tipo']; ?></h6>
                                           <span class="text-xs text-muted"><?php echo $doc['comentario']; ?></span>
                                       </div>
                                   </div>
                               </div>
                           <?php endforeach; endif; ?>
                       </div>
                   </div>

                   <!-- Documentos de Viajero -->
                   <div>
                       <h6 class="text-sm mb-2">Documentos del Viaje</h6>
                       <div class="list-group list-group-flush">
                           <?php if(empty($docsViajero)): ?>
                               <p class="text-sm text-muted mb-0">No hay documentos cargados</p>
                           <?php else: foreach($docsViajero as $doc): ?>
                               <div class="list-group-item border-0 px-0 py-2">
                                   <div class="d-flex align-items-center">
                                       <div class="icon icon-shape bg-primary text-white rounded-circle shadow me-3">
                                           <i class="ni ni-collection"></i>
                                       </div>
                                       <div class="d-flex flex-column">
                                           <h6 class="mb-1 text-sm"><?php echo $doc['tipo']; ?></h6>
                                           <span class="text-xs text-muted"><?php echo $doc['comentario']; ?></span>
                                       </div>
                                   </div>
                               </div>
                           <?php endforeach; endif; ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <?php endforeach; ?>
    </div>
<?php endif; ?>


<!-- Modal de Carga -->
<div class="modal fade" id="modalDocumentacion" tabindex="-1" role="dialog" aria-labelledby="modalDocumentacionLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="modalDocumentacionLabel">Agregar Documento</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <form id="formDocumentacion">
                   <input type="hidden" name="action" value="altaDocumentacion">
                   <input type="hidden" name="viajesId" value="<?php echo $_GET[$idNombre]; ?>">
                   
                   <div class="form-group mb-3">
                        <label class="form-control-label">Viaje</label>
                        <select class="form-control" id="viajesId" name="viajesId" disabled>
                            <option value="<?php echo $_GET[$idNombre]; ?>">
                                <?php echo $viaje['nombre'] . ' ' . $viaje['anio']; ?>
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="usuarioContainer">
                        <label class="form-control-label">Usuario</label>
                        <select class="form-control" id="usuarioId" name="usuarioId">
                            <option value="" selected disabled>Seleccione un usuario</option>
                            <?php foreach($viajeros as $viajero): ?>
                                <option value="<?php echo $viajero['usuarioId']; ?>">
                                    <?php echo $viajero['apodo'] ?: $viajero['nombre'] . ' ' . $viajero['apellido']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                   <div class="form-group mb-3">
                       <label class="form-control-label">Tipo de Documento</label>
                       <select class="form-control" id="documentacionTipoId" name="documentacionTipoId" required>
                           <option value="" selected disabled>Seleccione un tipo de documento</option>
                           <optgroup label="Documentos Personales">
                               <?php foreach($documentacionesTipos['USUARIO'] as $tipo): ?>
                                   <option value="<?php echo $tipo['documentacionTipoId']; ?>"><?php echo $tipo['tipo']; ?></option>
                               <?php endforeach; ?>
                           </optgroup>
                           <optgroup label="Documentos del Viaje">
                               <?php foreach($documentacionesTipos['VIAJERO'] as $tipo): ?>
                                   <option value="<?php echo $tipo['documentacionTipoId']; ?>"><?php echo $tipo['tipo']; ?></option>
                               <?php endforeach; ?>
                           </optgroup>
                           <optgroup label="Documentos Generales">
                               <?php foreach($documentacionesTipos['VIAJE'] as $tipo): ?>
                                   <option value="<?php echo $tipo['documentacionTipoId']; ?>"><?php echo $tipo['tipo']; ?></option>
                               <?php endforeach; ?>
                           </optgroup>
                       </select>
                   </div>

                   <div class="form-group mb-3" id="usuarioContainer" style="display:none;">
                       <label class="form-control-label">Usuario</label>
                       <select class="form-control" id="usuarioId" name="usuarioId">
                           <option value="" selected disabled>Seleccione un usuario</option>
                           <?php foreach($viajeros as $viajero): ?>
                               <option value="<?php echo $viajero['usuarioId']; ?>">
                                   <?php echo $viajero['apodo'] ?: $viajero['nombre'] . ' ' . $viajero['apellido']; ?>
                               </option>
                           <?php endforeach; ?>
                       </select>
                   </div>

                   <div class="form-group mb-3">
                       <label class="form-control-label">Documento</label>
                       <input type="file" class="form-control" id="documento" name="documento" required>
                   </div>

                   <div class="form-group">
                       <label class="form-control-label">Comentario</label>
                       <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                   </div>

                   <div class="alert alert-danger fade mt-3" id="error_div" style="display: none;">
                       <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                       <span id="error-text"></span>
                   </div>
               </form>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               <button type="button" class="btn btn-primary" onclick="guardarDocumentacion()">Guardar</button>
           </div>
       </div>
   </div>
</div>

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
</script>