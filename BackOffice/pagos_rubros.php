<?php 

  require_once ("Connections/ssi_seguridad.php");
  
  require_once ("Connections/config.php");
  require_once ("Connections/connect.php");

  require_once ("servicios/servicio.php");

  $tabla = "pagos_rubros";
  $idNombre = "pagosRubroId";
  $rubros = getRubrosPagos($mysqli);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    updateHabilitado($mysqli, $_POST["id"], $_POST["habilitado"], $tabla, $idNombre);
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
                  <h1>Rubros de pagos</h1>
                  <ul>
                     <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a> /</li>
                     <li><a href="#">Rubros</a></li>
                  </ul>
               </div>
               <!-- <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a></div> -->
            </div>
         </div>
         <!-- /Breadcrumb -->
         <div class="card-panel">
          Podés administrar los rubros de pagos desde aquí
         </div>
         <br>
         <form>
        <div <form>
  <div class="row">
    <div class="col s12">
      <!-- Card-panel con botón y tabla -->
      <div class="card-panel">
        
        <!-- Botón para ir al formulario de agregar rubro (alineado a la derecha) -->
        <div class="right-align" style="margin-bottom: 20px;">
          <a href="#agregarRubro" class="btn" style="background-color: #4A90E2; color: white; padding: 8px 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9em; border: none; border-radius: 4px; text-decoration: none;">
            <i class="fa fa-plus" style="font-size: 0.7em; margin-right: 5px;"></i> Agregar Rubro
          </a>
        </div>
        
        <!-- Tabla -->
        <table class="highlight">
          <thead>
            <tr>
              <th>ID</th>
              <th>Rubro</th>
              <th>Comentario</th>
              <th>Habilitado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rubros as $rubro): ?>
            <tr>
              <td><?php echo $rubro["pagosRubroId"] ?></td>
              <td><?php echo $rubro["rubro"] ?></td>
              <td><?php echo $rubro["comentario"] ?></td>
              <td>
                <div class="switch" style="display: flex; align-items: center;">
                  <label>
                    <input type="checkbox" class="habilitado-checkbox" <?php echo $rubro["habilitado_sys"] == 1 ? "checked" : "" ?> data-id="<?php echo $rubro['pagosRubroId']; ?>">
                    <span class="lever"></span>
                  </label>
                </div>
              </td>
              <!-- Acciones (Botones de Editar y Borrar) -->
              <td style="white-space: nowrap;">
                <a class="btn" style="background-color: #4A90E2; color: white; padding: 8px 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9em; border: none; border-radius: 4px; text-decoration: none;">
                  <i class="fas fa-pencil-alt" style="font-size: 0.7em; margin-right: 5px;"></i> Editar
                </a>
                <a class="btn" style="background-color: #E94E77; color: white; padding: 8px 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9em; border: none; border-radius: 4px; text-decoration: none; margin-left: 5px;">
                  <i class="fas fa-trash-alt" style="font-size: 0.7em; margin-right: 5px;"></i> Borrar
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

      
      
      
   </body>
</html>