
<!-- Header con botón de agregar -->
<div class="row mb-4">
   <div class="col-12">
       <div class="d-flex justify-content-between align-items-center">
           <h6 class="mb-0"></h6>
           <button class="btn btn-sm btn-primary" onclick="javascript:cargarDocumentacion()">
               <i class="fas fa-plus me-2"></i>Agregar Documento
           </button>
       </div>
   </div>
</div>

<div class="nav-wrapper position-relative mb-3" id="documentacionContainer">
   <!-- Documentación del Viaje -->
   <div class="border rounded mb-3">
       <div class="d-flex align-items-center p-3 bg-gray-100" data-bs-toggle="collapse" data-bs-target="#collapseViaje" style="cursor: pointer">
           <h6 class="mb-0">Documentación General del Viaje</h6>
           <i class="fas fa-chevron-down ms-auto"></i>
       </div>
       <div class="collapse show" id="collapseViaje" data-bs-parent="#documentacionContainer">

           <div class="p-3">
               <div class="table-responsive">

                    <table class="table align-items-center mb-0">
                       <thead>
                           <tr>
                               <th class="text-xs" style="width: 40px"></th>
                               <th class="text-xs">Documento</th>
                               <th class="text-xs">Tipo</th> 
                               <th class="text-xs">Comentario</th>
                               <th class="text-xs text-center" style="width: 100px">Acciones</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php if(empty($documentacionViaje)): ?>
                           <tr>
                               <td colspan="5" class="text-center text-muted py-4">
                                   <i class="fas fa-folder-open mb-3" style="font-size: 2rem;"></i>
                                   <p class="mb-0">No hay documentos cargados</p>
                               </td>
                           </tr>
                           <?php else: foreach($documentacionViaje as $doc): ?>
                           <tr>
                               <td class="ps-3">
                                   <?php 
                                   $extension = strtolower(pathinfo($doc['documento'], PATHINFO_EXTENSION));
                                   $icon = match($extension) {
                                       'pdf' => 'fa-file-pdf text-danger',
                                       'doc','docx' => 'fa-file-word text-primary', 
                                       'xls','xlsx' => 'fa-file-excel text-success',
                                       'jpg','jpeg','png' => 'fa-file-image text-warning',
                                       default => 'fa-file text-secondary'
                                   };
                                   ?>
                                   <i class="fas <?php echo $icon; ?>"></i>
                               </td>
                               <td class="text-sm py-2"><?php echo $doc['documento']; ?></td>
                               <td class="text-sm py-2"><?php echo $doc['tipo']; ?></td>
                               <td class="text-sm py-2"><?php echo $doc['comentario']; ?></td>
                               <td class="text-center">
                                   <a href="_recursos/documentacion_viajes/<?php echo $doc['documento']; ?>" 
                                      target="_blank" 
                                      class="btn btn-sm btn-link text-dark px-1">
                                       <i class="fas fa-eye"></i>
                                   </a>
                                   <button class="btn btn-sm btn-link text-danger px-1" 
                                           onclick="eliminarDocumento(<?php echo $doc['documentacionId']; ?>)">
                                       <i class="fas fa-trash"></i>
                                   </button>
                               </td>
                           </tr>
                           <?php endforeach; endif; ?>
                       </tbody>
                    </table>
               </div>
           </div>
       </div>
   </div>

    <!-- Documentación de Usuarios -->
   <div class="border rounded mb-3">
       <div class="d-flex align-items-center p-3 bg-gray-100" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios" style="cursor: pointer">
           <h6 class="mb-0">Documentación de Usuarios</h6>
           <i class="fas fa-chevron-down ms-auto"></i>
       </div>
       <div class="collapse" id="collapseUsuarios"  data-bs-parent="#documentacionContainer">
           <div class="p-3">
               <div class="input-group mb-3">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="search" 
                           class="form-control" 
                           id="buscarUsuario" 
                           placeholder="Buscar por nombre, apodo o apellido..."
                           onkeyup="filtrarUsuarios(this.value)">
                </div>
               <!-- Contenido principal -->
                <?php if(empty($documentacionUsuarios)): ?>
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
                       <?php foreach($documentacionUsuarios as $usuario): ?>
                       <div class="col-md-4" data-nombre="<?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?>">
                           <div class="card">
                               <!-- Header con foto y nombre -->

                                <div class="card-header p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-lg rounded-circle me-3" style="width: 48px; height: 48px; overflow: hidden;">
                                                <img src="_recursos/profile_pics/<?php echo !empty($usuario['imagen']) ? $usuario['imagen'] : 'generic_user.png'; ?>" 
                                                     alt="Perfil" 
                                                     data-bs-toggle="tooltip" 
                                                     title="<?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?>"
                                                     class="w-100 h-100 object-fit-cover">
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?php echo $usuario['apodo']; ?></h6>
                                                <p class="text-sm text-muted mb-0"><?php echo $usuario['viajero_tipo']; ?></p>
                                            </div>
                                        </div>
                                        <button class="btn btn-xs btn-primary-outlined" 
                                                onclick="cargarDocumentacion(<?php echo $usuario['usuarioId']; ?>)" 
                                                data-bs-toggle="tooltip" 
                                                title="Agregar documento">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                               <!-- Cuerpo con los documentos -->
                               <div class="card-body p-3">
                                   <div class="mb-3">
                                   <h6 class="text-sm mb-2">Documentos Personales (<?php echo count($usuario['documentos']['USUARIO']) ?>)</h6>
                                   <div class="list-group list-group-flush">
                                       <?php if(empty($usuario['documentos']['USUARIO'])): ?>
                                           <p class="text-sm text-muted mb-0">No hay documentos cargados</p>
                                       <?php else: foreach($usuario['documentos']['USUARIO'] as $doc): ?>
                                           <div class="list-group-item border-0 px-0 py-2">
                                               <div class="d-flex align-items-center justify-content-between">
                                                   <div class="d-flex align-items-center">
                                                       <?php 
                                                       $extension = strtolower(pathinfo($doc['documento'], PATHINFO_EXTENSION));
                                                       $icon = match($extension) {
                                                           'pdf' => 'fa-file-pdf text-danger',
                                                           'doc','docx' => 'fa-file-word text-primary', 
                                                           'xls','xlsx' => 'fa-file-excel text-success',
                                                           'jpg','jpeg','png' => 'fa-file-image text-warning',
                                                           default => 'fa-file text-secondary'
                                                       };
                                                       ?>
                                                       <i class="fas <?php echo $icon; ?> me-2"></i>
                                                       <div>
                                                           <h6 class="mb-0 text-sm"><?php echo $doc['tipo']; ?></h6>
                                                           <span class="text-xs text-muted"><?php echo $doc['comentario']; ?></span>
                                                       </div>
                                                   </div>
                                                   <div>
                                                       <a href="_recursos/documentacion_usuarios/<?php echo $doc['documento']; ?>" 
                                                          target="_blank" 
                                                          class="btn btn-link btn-sm p-1">
                                                           <i class="fas fa-eye"></i>
                                                       </a>
                                                       <button class="btn btn-link btn-sm text-danger p-1" 
                                                               onclick="eliminarDocumento(<?php echo $doc['documentacionId']; ?>)">
                                                           <i class="fas fa-trash"></i>
                                                       </button>
                                                   </div>
                                               </div>
                                           </div>
                                       <?php endforeach; endif; ?>
                                   </div>
                               </div>

                                   <!-- Documentos de Viajero -->
                                   <div>
                                       <h6 class="text-sm mb-2">Documentos del Viaje (<?php echo count($usuario['documentos']['VIAJERO']) ?>)</h6>
                                       <div class="list-group list-group-flush">
                                           <?php if(empty($usuario['documentos']['VIAJERO'])): ?>
                                               <p class="text-sm text-muted mb-0">No hay documentos cargados</p>
                                           <?php else: foreach($usuario['documentos']['VIAJERO'] as $doc): ?>
                                               <div class="list-group-item border-0 px-0 py-2">
                                               <div class="d-flex align-items-center justify-content-between">
                                                   <div class="d-flex align-items-center">
                                                       <?php 
                                                       $extension = strtolower(pathinfo($doc['documento'], PATHINFO_EXTENSION));
                                                       $icon = match($extension) {
                                                           'pdf' => 'fa-file-pdf text-danger',
                                                           'doc','docx' => 'fa-file-word text-primary', 
                                                           'xls','xlsx' => 'fa-file-excel text-success',
                                                           'jpg','jpeg','png' => 'fa-file-image text-warning',
                                                           default => 'fa-file text-secondary'
                                                       };
                                                       ?>
                                                       <i class="fas <?php echo $icon; ?> me-2"></i>
                                                       <div>
                                                           <h6 class="mb-0 text-sm"><?php echo $doc['tipo']; ?></h6>
                                                           <span class="text-xs text-muted"><?php echo $doc['comentario']; ?></span>
                                                       </div>
                                                   </div>
                                                   <div>
                                                       <a href="_recursos/documentacion_viajes/<?php echo $doc['documento']; ?>" 
                                                          target="_blank" 
                                                          class="btn btn-link btn-sm p-1">
                                                           <i class="fas fa-eye"></i>
                                                       </a>
                                                       <button class="btn btn-link btn-sm text-danger p-1" 
                                                               onclick="eliminarDocumento(<?php echo $doc['documentacionId']; ?>)">
                                                           <i class="fas fa-trash"></i>
                                                       </button>
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
           </div>
       </div>
   </div>
</div>



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
                            <?php foreach($documentacionUsuarios as $usuario): ?>
                                <option value="<?php echo $usuario['usuarioId']; ?>">
                                    <?php echo $usuario['apodo'] ." (". $usuario['nombre'] . ' ' . $usuario['apellido'].")"; ?>
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

                   <div class="form-group mb-3">
                       <label class="form-control-label">Documento</label>
                       <input type="file" class="form-control" id="documento" name="documento" required>
                   </div>

                   <div class="form-group">
                       <label class="form-control-label">Comentario</label>
                       <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                   </div>

                   
                    <div class="alert alert-danger fade mt-3" id="error_div_doc" style="display: none;">
                       <span class="alert-icon text-white"><i class="fas fa-exclamation-triangle"></i></span>
                       <span id="error-text-doc" class="text-white text-center w-100"></span>
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

<!-- Modal Confirmación Eliminar -->
<div class="modal fade" id="modalEliminarDoc" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Confirmar eliminación</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
           </div>
           <div class="modal-body text-center">
               <!-- <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i> -->
               <p>¿Está seguro que desea eliminar este documento?</p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
               <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">Eliminar</button>
           </div>
       </div>
   </div>
</div>

<!-- Modal Error -->
<div class="modal fade" id="modalError" tabindex="-1">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title">Error</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
           </div>
           <div class="modal-body text-center">
               <!-- <i class="fas fa-times-circle text-danger mb-3" style="font-size: 3rem;"></i> -->
               <p id="errorMessage"></p>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
           </div>
       </div>
   </div>
</div>
