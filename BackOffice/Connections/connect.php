<?php

	$mysqli = new mysqli("$dbhost","$dbusername","$dbpasswd","$database_name");
	if (mysqli_connect_errno()) {
	    die("Error al conectar: ".mysqli_connect_error());
	}
	
	// SETEAMOS EL IDIOMA EN ESPAÑOL
	$query = "SET lc_time_names = 'es_AR';";
	$result = $mysqli->query($query);
	// SETEAMOS EL TIMEZONE DE ARGENTINA
	$queryTZ = "SET time_zone = '-03:00';";
	$resultTZ = $mysqli->query($queryTZ);
	$mysqli->set_charset("utf8");
	
	require_once ("error_handler.php");
?>