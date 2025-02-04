<?php

	require_once ("../Connections/ssi_seguridad.php");
  require_once ("../Connections/config.php");
  require_once ("../Connections/connect.php");
  require_once ("../servicios/funcs.php");
  require_once ("../servicios/servicio.php");

  $tabla = "viajes";
	$idNombre = "viajesId";

  $viajesId = $_GET[$idNombre];

  $equipos = getAlquilerEquipos();
  $tarifas = obtenerTarifasAlquilerEquipo($_GET[$idNombre]);
  $equiposSeleccionados = obtenerEquiposSeleccionados($_GET[$idNombre]);
  $viajeros = getTodosViajesUsuarios($viajesId);
	$viaje = getItem($tabla, $idNombre, $_GET[$idNombre]);

	$XLS_TITLE = 'Alquiler de equipos al ';
	$file = XLS_FILE_PREFIX.$viaje["nombre"]."_".$viaje["anio"].'_alquiler_de_equipos_';

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
     <td colspan="<?php echo count($equipos) + 5; ?>" align="center"><?php echo SITE_TITLE ?></td>
   </tr>
   <tr class="titulo_tablas">
     <td><strong>Viajero</strong></td>
     <td><strong>Tipo</strong></td>
     <td><strong>Peso</strong></td>
     <td><strong>Altura</strong></td>
     <td><strong>Talle</strong></td>
     <?php foreach($equipos as $equipo): ?>
       <td><strong><?php echo $equipo['equipo']; ?></strong></td>
     <?php endforeach; ?>
   </tr>
   <?php foreach($viajeros as $v): ?>
   <tr class="linkSeSubraya">
     <td><?php echo $v['usuario']['apodo'] ?: $v['usuario']['nombre'] . ' ' . $v['usuario']['apellido']; ?></td>
     <td><?php echo $v['viajeroTipo']['viajero_tipo']; ?></td>
     <td align="center"><?php echo $v['usuario']['peso'] ? $v['usuario']['peso'].'kg' : '-'; ?></td>
		<td align="center"><?php echo $v['usuario']['altura'] ? str_replace([',','.'], '', $v['usuario']['altura']).'cm' : '-'; ?></td>
		<td align="center"><?php echo $v['usuario']['talle'] ?: '-'; ?></td>
     <?php foreach($equipos as $equipo): ?>
       <td><?php 
				 echo $v['viajeroTipo']['viajeroTipoId'] == 3 ? '-' : 
				   (isset($equiposSeleccionados[$v['viajesUsuariosId']]) && 
				   in_array($equipo['alquilerEquiposId'], $equiposSeleccionados[$v['viajesUsuariosId']]) ? 'SI' : 'NO'); 
				?></td>
     <?php endforeach; ?>
   </tr>
   <?php endforeach; ?>
 </table>

 <br><br>
<table border="1" cellpadding="3" cellspacing="0" style="width: 200px;">
 <tr class="titulo_tablas_mayor">
   <td colspan="2" align="center"><strong>Resumen de #Equipos</strong></td>
 </tr>
 <?php 
 foreach($equipos as $equipo): 
   // Saltear el equipo completo (FULL)
   if ($equipo['acronimo'] == 'FULL') continue;
   
   $count = 0;
   foreach($viajeros as $v) {
     if ($v['viajeroTipo']['viajeroTipoId'] != 3 && 
         isset($equiposSeleccionados[$v['viajesUsuariosId']]) && 
         in_array($equipo['alquilerEquiposId'], $equiposSeleccionados[$v['viajesUsuariosId']])) {
       $count++;
     }
   }
 ?>
   <tr>
     <td width="70%"><strong><?php echo $equipo['equipo']; ?></strong></td>
     <td align="center" width="30%"><?php echo $count; ?></td>
   </tr>
 <?php endforeach; ?>
</table>
</body>