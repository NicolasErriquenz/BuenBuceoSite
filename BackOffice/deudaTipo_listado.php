<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "deuda_tipo";
    $idNombre = "deudaTipoId";
    $deudasTipos = getDeudaTipos();
    $title = "TIPOS DE DEUDA";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "actualizar" ) {
        updateHabilitado($_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
    }

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
                  <h1>Tipos de deuda</h1>
                  <ul>
                     <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a> /</li>
                     <li><a href="#">Tipos de deuda</a></li>
                  </ul>
               </div>
               <!-- <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a></div> -->
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="card-panel">
          Podés administrar los tipos de deuda desde aquí
         </div>
         <br>
        <form>
            <div class="row">
                <div class="col s12">
                    <!-- Card-panel con botón y tabla -->
                    <div class="card-panel custom-card-panel">
                        
                        <h5 class="center-align custom-title"><?php echo $title ?></h5>

                        <!-- Botón para agregar rubro (alineado a la derecha) -->
                        <div class="right-align mb-4">
                            <a href="deudaTipo_listado_editar.php" class="btn red lighten-1 custom-button">
                                <i class="fa fa-plus custom-icon"></i> Agregar tipo de deuda
                            </a>
                        </div>

                        <!-- Tabla estilo Bootstrap -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Tipo deuda</th>
                                    <th>Comentario</th>
                                    <th>Habilitado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deudasTipos as $deudasTipo): ?>
                                <tr>
                                    <td class="text-center text-underline"><?php echo $deudasTipo[$idNombre] ?></td>
                                    <td><strong><?php echo $deudasTipo["deuda"] ?></strong></td>
                                    <td>
                                        <!-- Comentario con ancho fijo y tooltip -->
                                        <span class="comment-tooltip" title="<?php echo $deudasTipo["comentario"] ?>">
                                            <?php echo strlen($deudasTipo["comentario"]) > 20 ? substr($deudasTipo["comentario"], 0, 20) . '...' : $deudasTipo["comentario"]; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Switch de habilitado (MaterializeCSS) -->
                                        <div class="switch">
                                            <label>
                                                <input type="checkbox" class="habilitado-checkbox" <?php echo $deudasTipo["habilitado_sys"] == 1 ? "checked" : "" ?> data-id="<?php echo $deudasTipo[$idNombre]; ?>">
                                                <span class="lever"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="deudaTipo_listado_editar.php?<?php echo $idNombre ?>=<?php echo $deudasTipo[$idNombre] ?>" class="btn btn-danger custom-edit-button">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
                console.log(id);
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

            .custom-button {
                padding: 10px 16px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 10px;
            }

            .custom-icon {
                font-size: 1em;
                margin-right: 8px;
            }

            .text-center {
                text-align: center;
            }

            .text-underline {
                text-decoration: underline;
            }

            .comment-tooltip {
                max-width: 150px;
                display: inline-block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .custom-edit-button {
                border-radius: 8px;
            }

      </style>
   </body>
</html>