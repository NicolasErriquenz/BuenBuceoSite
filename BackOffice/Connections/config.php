<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	
	// Configurar logging
	ini_set('log_errors', 1);
	ini_set('error_log', '_logs/php_errors.log');

	$dateFormat = "d-m-Y";
	$sessionDateFormat = "Y-m-d";
	$timeFormat = "H:i:s";
	$dateTimeFormat = $dateFormat.' '.$timeFormat;
	$lang = "es";

	// GCM Server
	$GCMApiKey = "AIzaSyDo_mNa_skr5qOakPPL8jAy0hi4jhmMEuw";
	$diasNotificarInactividad = 3;
	$diasNotificarSinMovimientos = 2;
	
	if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'buenbuceo') {
		$dbhost = 'localhost';
		$dbusername = 'root';
		$dbpasswd = '';
		$database_name = 'BuenBuceo';
	} else {
		// PRODUCTION!!!
		$dbhost = '193.203.175.53';
		$dbusername = 'u229759960_buceo';
		$dbpasswd = 'Rosario440';
		$database_name = 'u229759960_buenbuceo';
	}

	define("SITE_TITLE", "BuenBuceo - Admin");
	define("MARCA", "BuenBuceo");

	$FAVICON_32 = "images/icon/bb_favicon_32x32.png";
	$FAVICON_192 = "images/icon/bb_favicon_192x192.png";
	$FAVICON_180 = "images/icon/bb_favicon_180x180.png";
	$redirect_uri = 'index.php';
	
	$TOKEN_BCRA = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE2MDg0ODQsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJuZXJyaXF1ZW56QGdtYWlsLmNvbSJ9.TSyyPz0oicx_RAi_6NQp8058TA6ZIbN5e_9R6rrO1VqeYPgdeTW9r9TwN-xonrAMmJxanKBqDTPY3JTqW_nUXQ";
	
	$AUTH_BEARER = "Authorization: BEARER eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE2MDg0ODQsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJuZXJyaXF1ZW56QGdtYWlsLmNvbSJ9.TSyyPz0oicx_RAi_6NQp8058TA6ZIbN5e_9R6rrO1VqeYPgdeTW9r9TwN-xonrAMmJxanKBqDTPY3JTqW_nUXQ";

	$num_imagenes = 68; // Número total de imágenes disponibles
	$imagenes = [];

	// Generar automáticamente el array de nombres de imágenes
	for ($i = 1; $i <= $num_imagenes; $i++) {
	    $imagenes[] = "bg$i.JPG";
	}

	// Seleccionar una imagen al azar
	$imagen = $imagenes[array_rand($imagenes)];

	// Generar el HTML con la imagen seleccionada
	$HEADER_IMAGEN = '<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url(\'images/' . $imagen . '\'); background-position-y: 50%;"> 
	    <span class="mask bg-primary opacity-6"></span> 
	  </div>';

  	$HEADER_PLANO = '<div class="min-height-300 bg-dark position-absolute w-100" ></div>';

  	$archivoActual = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

  	define("RUTA_FILE_VIAJES", "_recursos/viajes_pdf/");