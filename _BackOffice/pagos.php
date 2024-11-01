<?php 

    require_once ("Connections/ssi_seguridad.php");

    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

    require_once ("servicios/servicio.php");

    $tabla = "pagos";
    $idNombre = "pagoId";
    $subrubros = getPagos();
    $title = "PAGOS";

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
                  <h1>Pagos</h1>
                  <ul>
                     <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a> /</li>
                     <li><a href="#">Pagos</a></li>
                  </ul>
               </div>
               <!-- <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a></div> -->
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="card-panel">
          Podés administrar los pagos desde aquí
         </div>
         <br>
        <form>
            <div class="row">
                <div class="col s12">
                    <!-- Card-panel con botón y tabla -->
                    <div class="card-panel custom-card-panel">
                        
                        <h5 class="center-align custom-title"><?php echo $title ?></h5>

                        <!-- Botón para agregar subrubro y limpiar consulta (alineado a la derecha) -->
                        <div class="right-align mb-4">
                            <?php if (isset($_GET['pagosRubrosId'])): ?>
                            <a href="pagos_subrubros.php" class="btn grey darken-1 custom-button">
                                <i class="fa fa-trash custom-icon"></i> Limpiar filtro de pago
                            </a>
                            <?php endif; ?>
                            <a href="pagos_editar.php<?php echo isset($_GET['pagosRubrosId']) ? '?pagosRubrosId=' . $_GET['pagosRubrosId'] : ''; ?>" class="btn red lighten-1 custom-button">
                                <i class="fa fa-plus custom-icon"></i> Agregar Pago
                            </a>
                            
                        </div>

                        <!-- Espacio entre botón y tabla -->
                        <div class="mb-3"></div>

                        <!-- Tabla estilo Bootstrap -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Subrubro</th>
                                    <th>Transacción Tipo</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Medio Pago</th>
                                    <th>Usuario</th>
                                    <th>Deuda</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagos as $pago): ?>
                                <tr>
                                    <td class="text-center text-underline"><?php echo $pago["pagoId"] ?></td>
                                    <td><strong><?php echo $pago["subrubro"] ?></strong></td>
                                    <td><?php echo $pago["transaccion_tipo"] ?></td>
                                    <td><?php echo date("d/m/Y H:i", strtotime($pago["fecha"])) ?></td>
                                    <td><?php echo number_format($pago["monto"], 2) ?> <?php echo $pago["moneda"] ?></td>
                                    <td><?php echo $pago["medio_pago"] ?></td>
                                    <td><?php echo isset($pago["usuario_nombre"]) ? $pago["usuario_nombre"] : '-' ?></td>
                                    <td><?php echo isset($pago["deuda_descripcion"]) ? $pago["deuda_descripcion"] : '-' ?></td>
                                    <td>
                                        <a href="pago_editar.php?pagoId=<?php echo $pago["pagoId"] ?>" class="btn btn-danger custom-edit-button">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Card footer con botón "Ir a rubros" -->
                        <!-- <div class="card-footer" style="background-color: #f5f5f5; padding: 0.5rem; border-top: 1px solid #ddd; text-align: right;">
                            <a href="pagos_rubros.php" class="btn btn-primary">
                                Ir a rubros
                            </a>
                        </div> -->
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

        .card-footer {
            background-color: #f5f5f5;
            padding: 15px;
            border-top: 1px solid #ddd;
            text-align: right;
        }
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