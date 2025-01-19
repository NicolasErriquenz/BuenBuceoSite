<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "usuarios";
  $idNombre = "usuarioId";
  $errores = array();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] == "editar" || $_POST['action'] == "alta")) {
     // Validaciones básicas
     if (empty($_POST['nombre']))  $errores[] = 'Nombre es requerido';
     if (empty($_POST['email']))  $errores[] = 'Email es requerido';
     if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))  $errores[] = 'Email inválido';
     
     // Validar duplicados
     $usuarioId = isset($_POST['usuarioId']) ? $_POST['usuarioId'] : 0;
     
     if ($_POST['action'] == "alta") {
         // Para alta, verificar si ya existen
         $email = $mysqli->real_escape_string($_POST['email']);
         $sql = "SELECT * FROM usuarios WHERE email = '$email'";
     } else {
         // Para editar, verificar que no lo tenga otro usuario
         $email = $mysqli->real_escape_string($_POST['email']);
         $dni = $mysqli->real_escape_string($_POST['dni']);
         //$apodo = $mysqli->real_escape_string($_POST['apodo']);
         $usuario = $mysqli->real_escape_string($_POST['usuario']);
         $sql = "SELECT * FROM usuarios WHERE 
                 (email = '$email' OR 
                  dni = '$dni' OR 
                  usuario = '$usuario') 
                 AND usuarioId != $usuarioId";
     }
     
     $result = $mysqli->query($sql);
     
     if($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
             if($row['email'] == $_POST['email']) $errores[] = 'Email ya registrado para el usuarioId '.$row['usuarioId'];
             if($row['dni'] == $_POST['dni']) $errores[] = 'DNI ya registrado para el usuarioId '.$row['usuarioId'];
             //if($row['apodo'] == $_POST['apodo']) $errores[] = 'Apodo ya registrado para el usuarioId '.$row['usuarioId'];
             if($row['usuario'] == $_POST['usuario']) $errores[] = 'Usuario ya registrado para el usuarioId '.$row['usuarioId'];
         }
     }
     
     if (count($errores) > 0) {
         $respuesta = array('estado' => 'error_validacion', 'errores' => $errores);
         echo json_encode($respuesta);
     } else {
         if(isset($_POST["usuarioId"]) && !empty($_POST["usuarioId"]))
             echo editarUsuario($_POST);
         else
             echo altaUsuario($_POST);
     }
     die();
}


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "eliminarRedSocial" ) {
    eliminarRedSocial($_POST["usuarioRedSocialId"]);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "agregarRedSocial" ) {
    echo guardarRedSocial($_POST);
    die();
  }

  
  $usuario = [];
  $usuario["habilitado_sys"] = 0;
  $usuario["usuarioTipoId"] = 3;
  $usuario["viajeroTipoId"] = 0;
  
  $pagos = [];
  $deudas = [];
  $viajes = [];

  if( isset($_GET[$idNombre]) ){
    $title = "Editar usuario";
    $subtitle = "Podés editar el usuario desde aquí";
    $action = "editar";
    $usuario = getItem($tabla, $idNombre, $_GET[$idNombre]);
    $usuarioRedes = getUsuarioRedes($usuario[$idNombre]);
    $pagos = getPagos($usuario[$idNombre]);
    $deudas = getDeudas($usuario[$idNombre]);
  }else{
    $title = "Alta usuario";
    $subtitle = "Podés dar de alta un usuario desde aquí";
    $action = "alta";
  }

  $redirect = "usuarios_editar.php";
  $goBackLink = "usuarios.php";
  $paises = getPaises();
  $sexos = getSexos();
  $redes = getRedes();

  $viajerosTipos = getViajesViajeroTipo();
  //eco($usuario);
  //eco($viajerosTipos);
  $usuariosTipo = getUsuariosTipo();
  // eco($usuariosTipo);
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
    <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="action" value="<?php echo $action ?>">
      <input type="hidden" name="habilitado_sys" id="habilitado_sys" value="<?php echo $usuario["habilitado_sys"]?>">
      <input type="hidden" name="<?php echo $idNombre ?>" id="<?php echo $idNombre ?>" value="<?php echo $usuario[$idNombre] ?? null ?>">
      <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
          <div class="row gx-4">
            <div class="col-auto">
              <div class="avatar avatar-xl position-relative">
                <img src="_recursos/profile_pics/<?php echo isset($usuario["imagen"]) ? $usuario["imagen"] : "generic_user.png" ?>" alt="Perfil" class="w-100 border-radius-lg shadow-sm">
              </div>
            </div>
            <div class="col-auto my-auto">
              <div class="h-100">
                <h5 class="mb-1">
                  <?php echo $action == "editar" ? $usuario["nombre"]." ".$usuario["apellido"] : "Nuevo usuario" ?>
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                  <?php echo $action == "editar" ? $usuario["email"] : "" ?>
                </p>
              </div>
            </div>
            <?php if(isset($usuario["nombre"])): ?>
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
              <span id="badge-<?php echo $usuario[$idNombre]; ?>" class="badge badge-lg  badge-pill habilitado-checkbox 
                  <?php echo ($usuario["habilitado_sys"] == 1) ? 'bg-success' : 'bg-secondary'; ?>">
                  <?php echo ($usuario["habilitado_sys"] == 1) ? 'HABILITADO' : 'DESACTIVADO'; ?>
              </span>
            </div>
          <?php endif ?>
          </div>
        </div>
      </div>

      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-md-8">
            
              <div class="card">
                <div class="card-header pb-0">
                  <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0"><?php echo ucfirst($action); ?> Perfil</p>
                    <div class="d-flex align-items-center">
                      <a href="javascript:history.back()" class="btn bg-gradient-outline-danger btn-sm">
                        <i class="ni ni-bold-left"></i> Volver
                      </a>
                      <button class="btn bg-gradient-primary btn-sm ms-2" type="submit" id="btn_guardar">Guardar</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <p class="text-uppercase text-sm">Información del usuario</p>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nombre" class="form-control-label">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo isset($usuario["nombre"]) ? $usuario["nombre"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="apellido" class="form-control-label">Apellido</label>
                        <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo isset($usuario["apellido"]) ? $usuario["apellido"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="apodo" class="form-control-label">Apodo</label>
                        <input class="form-control" type="text" name="apodo" id="apodo" value="<?php echo isset($usuario["apodo"]) ? $usuario["apodo"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="dni" class="form-control-label">Documento</label>
                        <input class="form-control" type="number" name="dni" id="dni" value="<?php echo isset($usuario["dni"]) ? $usuario["dni"] : "" ?>">
                      </div>
                    </div>
                  </div>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Información de logueo</p>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="usuario" class="form-control-label">Username</label>
                        <input class="form-control" type="text" name="usuario" id="usuario" value="<?php echo isset($usuario["usuario"]) ? $usuario["usuario"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="password" class="form-control-label">Password</label>
                        <input class="form-control" type="text" name="password" id="password" value="<?php echo isset($usuario["password"]) ? $usuario["password"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="paisId" class="form-control-label">Tipo usuario</label>
                        <select id="usuarioTipoId" name="usuarioTipoId" class="form-control">
                            <option value="" selected disabled>Elegí un tipo de usuario</option>
                            <?php foreach ($usuariosTipo as $item): ?>
                            <option value="<?php echo $item['usuarioTipoId']; ?>" 
                                    <?php echo $item['usuarioTipoId'] == $usuario["usuarioTipoId"] ? 'selected' : ''; ?>>
                                <?php echo $item['tipo']; ?> 
                            </option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    
                  </div>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Información de contacto</p>
                  <div class="row">
                    <div class="col-md-6">
                     <div class="form-group">
                       <label for="email" class="form-control-label">Email</label>
                       <input class="form-control" type="email" name="email" id="email" value="<?php echo isset($usuario["email"]) ? $usuario["email"] : "" ?>">
                     </div>
                    </div>
                    <div class="col-md-6">
                     <div class="form-group">
                       <label for="telefono" class="form-control-label">Teléfono</label>
                       <input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo isset($usuario["telefono"]) ? $usuario["telefono"] : "" ?>">
                     </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="direccion" class="form-control-label">Dirección</label>
                        <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo isset($usuario["direccion"]) ? $usuario["direccion"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="ciudad" class="form-control-label">Ciudad</label>
                        <input class="form-control" type="text" name="ciudad" id="ciudad" value="<?php echo isset($usuario["ciudad"]) ? $usuario["ciudad"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="paisId" class="form-control-label">Pais</label>
                        <select id="paisId" name="paisId" class="form-control">
                          <option value="" selected disabled>Seleccione un país</option>
                          <?php foreach ($paises as $pais): ?>
                          <option value="<?php echo $pais['paisId']; ?>" 
                                  <?php 
                                    if ($action == "alta" && $pais['paisId'] == 1) {
                                      echo "selected";
                                    } elseif (isset($usuario['paisId']) && $usuario['paisId'] == $pais['paisId']) {
                                      echo "selected";
                                    } 
                                  ?>>
                            <?php echo $pais['pais']; ?>
                          </option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    
                  </div>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">About me</p>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="comentario" class="form-control-label">Comentario</label>
                        <textarea class="form-control" name="comentario" id="comentario"><?php echo isset($usuario["comentario"]) ? $usuario["comentario"] : "" ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Fecha de nacimiento</label>
                        <div class="input-group">
                          <input class="form-control" 
                                 type="date" 
                                 value="<?php echo isset($usuario['fecha_nacimiento']) ? date("Y-m-d", strtotime($usuario['fecha_nacimiento'])) : ""; ?>" 
                                 id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                      </div>
                    </div>

                     <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-control-label">Seleccionar imagen de perfil</label>
                        <div class="input-group">
                          <input type="file" 
                                 class="form-control" 
                                 id="imagen" 
                                 name="imagen" 
                                 accept="image/*">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="sexoId" class="form-control-label">Sexo</label>
                        <select id="sexoId" name="sexoId" class="form-control">
                          <option value="" selected disabled>Seleccione un sexo</option>
                          <?php foreach ($sexos as $sexo): ?>
                          <option value="<?php echo $sexo['sexoId']; ?>" 
                                  <?php echo (isset($usuario['sexoId']) && $usuario['sexoId'] == $sexo['sexoId']) ? "selected" : ""; ?>>
                            <?php echo $sexo['sexo']; ?>
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="altura" class="form-control-label">Altura</label>
                        <input class="form-control" type="text" name="altura" id="altura" value="<?php echo isset($usuario["altura"]) ? $usuario["altura"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="peso" class="form-control-label">Peso</label>
                        <input class="form-control" type="text" name="peso" id="peso" value="<?php echo isset($usuario["peso"]) ? $usuario["peso"] : "" ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="talle" class="form-control-label">Talle calzado</label>
                        <input class="form-control" type="text" name="talle" id="talle" value="<?php echo isset($usuario["talle"]) ? $usuario["talle"] : "" ?>">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="talle" class="form-control-label">Tipo viajero</label>
                        <select id="viajeroTipoId" name="viajeroTipoId" class="form-control">
                            <option value="" selected disabled>Elegí un tipo de viajero</option>
                            <?php foreach ($viajerosTipos as $item): ?>
                            <option value="<?php echo $item['viajeroTipoId']; ?>"
                                    <?php echo $item['viajeroTipoId'] == $usuario["viajeroTipoId"] ? 'selected' : ''; ?>>
                                <?php echo $item['viajero_tipo']; ?> 
                            </option>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  
                  <?php if(isset($usuarioRedes)): ?>
                  <hr class="horizontal dark">
                  <p class="text-uppercase text-sm">Redes sociales</p>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="redId">Red social</label>
                        <select id="redId" name="redId" class="form-control">
                          <option value="">Seleccione una red social</option>
                          <?php foreach ($redes as $red_social): ?>
                          <option value="<?php echo $red_social['redSocialId']; ?>"><?php echo $red_social['red']; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text" id="nickname" name="nickname" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" id="url" name="url" class="form-control">
                      </div>

                      
                      <button type="button" id="agregar_red_social" class="btn btn-primary">Agregar red social</button>

                      <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                          <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                              <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Red Social</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre de Usuario</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">URL</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla_redes_sociales">
                              <?php foreach ($usuarioRedes as $redSocial): ?>
                                <tr>
                                  <td class="text-center">
                                      <span class="fa fa-<?= strtolower($redSocial['red']) ?> ">
                                  </td>
                                  <td>
                                    <p class="text-sm font-weight-bold mb-0"><?= $redSocial['username'] ?></p>
                                  </td>
                                 <td>
                                     <button type="button" class="btn btn-link mb-0" onclick="window.open('<?= $redSocial['link'] ?>', '_blank')">
                                         <i class="fas fa-external-link-alt"></i>
                                     </button>
                                  </td>
                                  <td>
                                    <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0" 
                                            onclick="eliminarRedSocial(<?= $redSocial['usuariosRedSocialId'] ?>)">
                                        <i class="far fa-trash-alt me-2"></i>
                                    </button>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      

                    </div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            
          </div>
          <div class="col-md-4">
            <div class="card card-profile">
              <img src="_recursos/profile_pics/<?php echo isset($usuario["imagen"]) ? str_replace('_small', '', $usuario['imagen']) : "imagen_canvas.jpg" ?>" alt="Perfil" class="card-img-top">
              <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                <!-- <div class="d-flex justify-content-between">
                  <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                  <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i class="ni ni-collection"></i></a>
                  <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                  <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i class="ni ni-email-83"></i></a>
                </div> -->
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col">
                    <div class="d-flex justify-content-center">
                      <div class="d-grid text-center">
                        <span class="text-lg font-weight-bolder"><?php echo  count($viajes) ?></span>
                        <span class="text-sm opacity-8">Viajes</span>
                      </div>
                      <div class="d-grid text-center mx-4">
                        <span class="text-lg font-weight-bolder"><?php echo count($pagos) ?></span>
                        <span class="text-sm opacity-8">Pagos</span>
                      </div>
                      <div class="d-grid text-center">
                        <span class="text-lg font-weight-bolder"><?php echo count($deudas) ?></span>
                        <span class="text-sm opacity-8">Deudas</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <!-- <h5>
                    Mark Davis<span class="font-weight-light">, 35</span>
                  </h5> -->
                  <div class="h6 font-weight-300">
                    <i class="ni location_pin mr-2"></i>EN CONSTRUCCIÓN
                  </div>
                  <!-- <div class="h6 mt-4">
                    <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                  </div>
                  <div>
                    <i class="ni education_hat mr-2"></i>University of Computer Science
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <?php include("includes/footer.php") ?>

      </div>
    </form>
  </div>

  <?php include("includes/scripts.php") ?>

  <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <i class="fa fa-warning text-warning"></i>&nbsp;
              <h6 class="modal-title" id="modal-title-default">Errores de validación</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <ul class="list-group list-group-flush" id="ul_errores" style="padding-left: 20px;">
                <!-- Errores se mostrarán aquí -->
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn bg-gradient-primary ml-auto" data-bs-dismiss="modal">ENTENDIDO</button>
            </div>
          </div>
        </div>
      </div>

      <button type="button" id="btn-modal-errores" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-default" style="display:none;">Default</button>

      <div id="toast" class="toast align-items-center text-white <?php echo ($_GET["action"] == "alta") ? "bg-success" : "bg-info"; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body" style="font-size: 18px;">
            <i class="fa fa-check" style="font-size: 24px; margin-right: 10px;"></i> <?php echo $_GET["action"] == "alta" ? "Usuario creado!" : "Usuario actualizado!"; ?>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>

      <!-- Modal de confirmación para eliminar -->
      <div class="modal fade" id="modal-eliminar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <i class="fa fa-warning text-warning"></i>&nbsp;
              <h6 class="modal-title">Confirmar eliminación</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              ¿Está seguro que desea eliminar esta red social?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn bg-gradient-danger" id="btn-confirmar-eliminar">Eliminar</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modal-campos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <i class="fa fa-warning text-warning"></i>&nbsp;
              <h6 class="modal-title">Campos incompletos</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- El mensaje se insertará aquí dinámicamente -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Entendido</button>
            </div>
          </div>
        </div>
      </div>
  <script>
    function habilitadoCheckboxChange(checkbox) {
        var id = $(checkbox).data('id');
        var habilitado = $(checkbox).is(':checked') ? 1 : 0;
        
        $.ajax({
            url: '', // URL del mismo archivo PHP
            type: 'POST',
            data: {
                action: "actualizar",
                id: id,
                habilitado: habilitado,
                tabla: "<?php echo $tabla ?>"
            },
            success: function(response) {

            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar:', error);
            }
        });
    };

    let redSocialIdAEliminar;

    function eliminarRedSocial(id) {
        redSocialIdAEliminar = id;
        var myModal = new bootstrap.Modal(document.getElementById('modal-eliminar'));
        myModal.show();
    }

    document.getElementById('btn-confirmar-eliminar').addEventListener('click', function() {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'eliminarRedSocial',
                usuarioRedSocialId: redSocialIdAEliminar
            },
            success: function(response) {
                if(response.estado === 'ok') {
                    location.reload();
                }
            }
        });
        bootstrap.Modal.getInstance(document.getElementById('modal-eliminar')).hide();
    });

    $(document).ready(function() {
        
      $('.habilitado-checkbox').click(function() {
          var id = $(this).attr('id').split('-')[1]; // Obtenemos el ID desde el atributo ID del span
          var habilitado = $(this).hasClass('bg-success') ? 0 : 1; // Toggle habilitado/deshabilitado

          $.ajax({
              url: '', 
              type: 'POST',
              data: {
                  action: "actualizar",
                  id: id,
                  habilitado: habilitado,
                  tabla: "<?php echo $tabla ?>"
              },
              success: function(response) {
                  $(`#badge-${id}`).removeClass('bg-success bg-secondary')
                                   .addClass(habilitado == 1 ? 'bg-success' : 'bg-secondary')
                                   .text(habilitado == 1 ? 'HABILITADO' : 'DESACTIVADO');
                                   $("#habilitado_sys").val(habilitado);
              },
              error: function(xhr, status, error) {
                  console.error('Error al actualizar:', error);
              }
          });
      });

      $("#agregar_red_social").click(function() {
        var redId = $("#redId").val();
        var username = $("#nickname").val();
        var link = $("#url").val();
        
        // Crear lista de campos faltantes
        var camposFaltantes = [];
        if (redId === "") camposFaltantes.push("Red social");
        if (username === "") camposFaltantes.push("Nickname");
        if (link === "") camposFaltantes.push("URL");
        
        if (camposFaltantes.length > 0) {
            // Actualizar el contenido del modal
            let mensaje = "Por favor, complete los siguientes campos:<ul>";
            camposFaltantes.forEach(campo => {
                mensaje += `<li>${campo}</li>`;
            });
            mensaje += "</ul>";
            
            document.querySelector("#modal-campos .modal-body").innerHTML = mensaje;
            var modalCampos = new bootstrap.Modal(document.getElementById('modal-campos'));
            modalCampos.show();
            return;
        }
        
        if (redId != "" && nickname != "" && url != "") {
          $.ajax({
            type: "POST",
            url: "",
            data: {
              action: "agregarRedSocial",
              usuarioId: $("#usuarioId").val(),
              redId: redId,
              username: username,
              link: link
            },
            dataType: "json",
            success: function(response) {
              if (response.estado == "ok") {
               // Limpiar tabla
                 $("#tabla_redes_sociales").empty();
                 // Recorrer redes sociales y agregar filas a la tabla
                 $.each(response.redes, function(index, red_social) {
                     var fila = `
                     <tr>
                         <td>
                             <div class="d-flex px-2">
                                 <span class="fa fa-${(red_social.red).toLowerCase()}">
                             </div>
                         </td>
                         <td>
                             <p class="text-sm font-weight-bold mb-0">${red_social.username}</p>
                         </td>
                         <td>
                             <button type="button" class="btn btn-link mb-0" onclick="window.open('${red_social.link}', '_blank')">
                                 <i class="fas fa-external-link-alt"></i>
                             </button>
                         </td>
                         <td>
                             <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0" 
                                     onclick="eliminarRedSocial(${red_social.usuarioRedSocialId})">
                                 <i class="far fa-trash-alt me-2"></i>
                             </button>
                         </td>
                     </tr>
                     `;
                     $("#tabla_redes_sociales").append(fila);
                 });
                 limpiarCampos();
              } else {
                alert("Error al agregar red social");
              }
            }
          });
        } else {
          var modalCampos = new bootstrap.Modal(document.getElementById('modal-campos'));
          modalCampos.show();
        }
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var datos = new FormData(form);

        // Obtener la extensión del archivo
        var archivo = datos.get('imagen');
        var extension = archivo.name.split('.').pop().toLowerCase();
        
        // Validar extensión
        if (extension !== 'jpg' && extension !== 'jpeg' && extension !== "") {
          $('#ul_errores').html('Sólo se permiten imágenes .JPG y .JPEG');
          $('#btn-modal-errores').click();
          return false;
        }

        $.ajax({
          type: 'POST',
          url: 'usuarios_editar.php',
          data: datos,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(respuesta) {
            
            if(respuesta.estado == "ok"){
              window.location.href = "<?php echo $redirect; ?>?action=<?php echo $action ?>&success=true&usuarioId="+respuesta.usuarioId;
              
            }else if(respuesta.estado == "error"){
              $('#ul_errores').html(respuesta.mensaje);
              $('#btn-modal-errores').click();
            }else{
              // Formulario inválido, muestra errores en modal
              var errores = respuesta.errores;
              $('#ul_errores').empty();
              $.each(errores, function(index, error) {
                $('#ul_errores').append('<li>' + error + '</li>');
              });
              $('#btn-modal-errores').click();  
            }
            
          },
          error: function(error){
            alert(error)
            if(error == "Error"){
              $('#ul_errores').html('Error al insertar usuario');
              $('#btn-modal-errores').click();
            }
          }
        });
      });

      <?php if(isset($_GET["success"]) && $_GET["success"]  == "true"): ?>
        crearToast();
      <?php endif ?>


    });


    // Función para limpiar campos
    function limpiarCampos() {
      $("#red_social").val("");
      $("#nickname").val("");
      $("#url").val("");
    }

    function crearToast(){
      const toast = new bootstrap.Toast(document.getElementById('toast'), {
        animation: true,
        autohide: true,
        delay: 2000,
      });

      // Muestra el toast
      toast.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Evita el envío predeterminado del formulario
                    $("#btn_guardar").trigger("click");
                }
            });
        });
    });


  </script>
  <style type="text/css">
    .habilitado-checkbox {
        cursor: pointer;
    }
  </style>
</body>

</html>