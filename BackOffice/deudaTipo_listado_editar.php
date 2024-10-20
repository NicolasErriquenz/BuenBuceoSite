<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "deuda_tipo";
  $idNombre = "deudaTipoId";

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
    updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "editar" ) {
    editarTipoDeuda($_POST, $_GET);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "alta" ) {
    altaTipoDeuda($_POST);
  }

  if( isset($_GET[$idNombre]) ){
    $title = "Editar tipo de deuda";
    $subtitle = "Podés editar el tipo de deuda desde aquí";
    $action = "editar";
    $tipoDeuda = getItem($tabla, $idNombre, $_GET[$idNombre]);
  }else{
    $title = "Alta tipo de deuda";
    $subtitle = "Podés dar de alta un tipo de deuda desde aquí";
    $action = "alta";
  }

  $goBackLink = "deudaTipo_listado.php";
  
  // if(isset($_GET["ref"])){
  //   $goBackLink = "pagos_subrubros.php";
  // }
?>
<!DOCTYPE html>
<html lang="es">
   
   <?php include("includes/head.php"); ?>

   <body>
      
      <?php include("includes/navbar.php"); ?>

      <?php include("includes/menu.php"); ?>

      <section class="content-wrap">


         <!-- Breadcrumb -->
         <div class="page-title">
            <div class="row">
               <div class="col s12 m9 l10">
                  <h1>Editar Tipo de deuda</h1>
                  <ul>
                     <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a> /</li>
                     <li><a href="deudaTipo_listado.php">Tipo de deuda listado</a> /</li>
                     <li><a href="#"><?php echo  $title ?></a></li>
                  </ul>
               </div>
               <!-- <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a></div> -->
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="card-panel">
            <?php echo $subtitle ?>
         </div>
         <br>
          <form action="" method="POST">
            <div class="row">
              <div class="col s12">
                <div class="card-panel custom-card-panel">
                  <h5 class="center-align custom-title"><?php echo $title ?></h5>
                  
                  <?php if(isset($tipoDeuda[$idNombre])){ ?>
                  <div class="input-field custom-input-field">
                    <label for="<?php echo $idNombre ?>" class="custom-label">Pagos Rubro ID</label>
                    <input id="<?php echo $idNombre ?>" name="<?php echo $idNombre ?>" type="text" 
                           value="<?php echo isset($tipoDeuda[$idNombre]) ? $tipoDeuda[$idNombre] : ''; ?>" 
                           disabled>
                  </div>
                  <?php } ?>
                  
                  <div class="input-field custom-input-field">
                    <label for="deuda" class="custom-label">Descripción</label>
                    <input id="deuda" name="deuda" type="text" 
                           value="<?php echo isset($tipoDeuda['deuda']) ? $tipoDeuda['deuda'] : ''; ?>">
                  </div>
                  
                  <div class="input-field custom-input-field">
                    <label for="comentario" class="custom-label">Comentario</label>
                    <textarea id="comentario" name="comentario"><?php echo isset($tipoDeuda['comentario']) ? $tipoDeuda['comentario'] : ''; ?></textarea>
                  </div>
                  
                  <div class="switch custom-switch">
                    <label class="custom-label">
                      Deshabilitado
                      <input type="checkbox" 
                             <?php echo isset($tipoDeuda[$idNombre]) ? $tipoDeuda[$idNombre] : 'disabled checked'; ?>
                             class="habilitado-checkbox"
                             name="habilitado_sys"
                             data-id="<?php echo isset($tipoDeuda[$idNombre]) ? $tipoDeuda[$idNombre] : ''; ?>"
                             <?php echo $tipoDeuda["habilitado_sys"] == 1 ? "checked" : "" ?>>
                      <span class="lever"></span>
                      Habilitado
                    </label>
                  </div>
                  
                  <div class="custom-footer">
                    <input type="hidden" name="action" value="<?php echo $action ?>">
                    <a href="<?php echo $goBackLink ?>" class="btn red lighten-1 custom-cancel-btn">Cancelar</a>
                    <button type="submit" class="btn custom-save-btn">Guardar</button>
                  </div>
                  
                </div>
              </div>
            </div>
          </form>

      </section>
      
      <?php include("includes/footer.php") ?>

      <?php include("includes/scripts.php") ?>

      <script>
        $(document).ready(function() {
            $('.habilitado-checkbox').change(function() {
                var id = $(this).data('id');
                var habilitado = $(this).is(':checked') ? 1 : 0;
                console.log(id, habilitado);
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
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        form.submit();
                    }
                });
            });
        });

      </script>

      <style type="text/css">
        .custom-card-panel {
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
          padding: 20px;
          border-radius: 4px;
        }

        .custom-title {
          margin-bottom: 30px;
          font-weight: 500;
        }

        .custom-input-field {
          margin-bottom: 20px;
        }

        .custom-label {
          font-size: 1.1em;
          display: block;
          margin-bottom: 5px;
        }

        .custom-input-field input, 
        .custom-input-field textarea {
          border: 1px solid #ccc;
          border-radius: 4px;
          padding: 10px;
          width: 100%;
          box-sizing: border-box;
        }

        .custom-switch {
          margin-bottom: 30px;
        }

        .custom-footer {
          background-color: #f5f5f5;
          padding: 15px;
          border-top: 1px solid #ddd;
          display: flex;
          justify-content: flex-end;
          margin-top: 20px;
        }

        .custom-cancel-btn {
          margin-right: 10px;
        }

        .custom-save-btn {
          background-color: #4A90E2;
          color: white;
        }
      </style>
      
      
   </body>
</html>