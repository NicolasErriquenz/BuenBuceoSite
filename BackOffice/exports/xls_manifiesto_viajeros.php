<?php

	require_once ("../Connections/ssi_seguridad.php");
    require_once ("../Connections/config.php");
    require_once ("../Connections/connect.php");
    require_once ("../servicios/funcs.php");
    require_once ("../servicios/servicio.php");

    $tabla = "viajes";
  	$idNombre = "viajesId";

    $viajesId = $_GET[$idNombre];

	$resultados = getTodosViajesUsuarios($viajesId);
	$viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);

	$XLS_TITLE = 'Manifiesto de viajeros al ';
	$file = XLS_FILE_PREFIX.$viaje["nombre"]."_".$viaje["anio"].'_manifiesto_de_viaje_';

	header('Content-Type: application/vnd.ms-excel; charset=utf-8');
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Disposition: attachment; filename=".$file.date('y-m-d').".xls");

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
		.titulo_tablas{
			background:#44A4DD:
			color:#000;
			border:1px solid #000;
		}
		td, table, tr{
			border:1px solid #000;
		}
		.titulo_tablas_mayor{
			background:#F90:
			color:#000;
			border:1px solid #000;
			font-weight: bold;
			color: #FFF;
			background-color: #44A4DD;
		}
	</style>
</head>

<body>
  <h4><?php echo $XLS_TITLE . ' ' . date('d/m/Y');?></h4>
  <table border="1" cellpadding="3" cellspacing="0">
    <tr class="titulo_tablas_mayor">
      <td colspan="8" align="center"><?php echo SITE_TITLE ?></td>
    </tr>
    <tr class="titulo_tablas">
      <td><strong>Nombre</strong></td>
      <td><strong>Apellido</strong></td>
      <td><strong>DNI</strong></td>
      <td><strong>F.Nac.</strong></td>
      <td><strong>Email</strong></td>
      <td><strong>Dirección</strong></td>
      <td><strong>Teléfono</strong></td>
      <td><strong>Tipo viajero</strong></td>
    </tr>
    <?php foreach ($resultados as $viajero): ?>
    <tr class="linkSeSubraya">
      <td><?php echo ($viajero['usuario']['nombre']); ?></td>
      <td><?php echo ($viajero['usuario']['apellido']); ?></td>
      <td><?php echo ($viajero['usuario']['dni']); ?></td>
      <td><?php echo formatearFecha($viajero['usuario']['fecha_nacimiento']); ?></td>
      <td><?php echo ($viajero['usuario']['email']); ?></td>
      <td><?php echo ($viajero['usuario']['direccion']); ?></td>
      <td><?php echo ($viajero['usuario']['telefono']); ?></td>
      <td><?php echo ($viajero['viajeroTipo']['viajero_tipo']); ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</body>