<?php

	error_reporting(E_ERROR | E_PARSE);
	date_default_timezone_set('America/Argentina/Buenos_Aires');
	
	$dateFormat = "d-m-Y";
	$sessionDateFormat = "Y-m-d";
	$timeFormat = "H:i:s";
	$dateTimeFormat = $dateFormat.' '.$timeFormat;
	
	// GCM Server
	$GCMApiKey = "AIzaSyDo_mNa_skr5qOakPPL8jAy0hi4jhmMEuw";
	$diasNotificarInactividad = 3;
	$diasNotificarSinMovimientos = 2;

	if ($_SERVER['HTTP_HOST'] === 'localhost') {
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

	$FAVICON_32 = "images/icon/bb_favicon_32x32.png";
	$FAVICON_192 = "images/icon/bb_favicon_192x192.png";
	$FAVICON_180 = "images/icon/bb_favicon_180x180.png";
	$redirect_uri = 'index.php';
	
	$TOKEN_BCRA = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE2MDg0ODQsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJuZXJyaXF1ZW56QGdtYWlsLmNvbSJ9.TSyyPz0oicx_RAi_6NQp8058TA6ZIbN5e_9R6rrO1VqeYPgdeTW9r9TwN-xonrAMmJxanKBqDTPY3JTqW_nUXQ";
	
	$AUTH_BEARER = "Authorization: BEARER eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE2MDg0ODQsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJuZXJyaXF1ZW56QGdtYWlsLmNvbSJ9.TSyyPz0oicx_RAi_6NQp8058TA6ZIbN5e_9R6rrO1VqeYPgdeTW9r9TwN-xonrAMmJxanKBqDTPY3JTqW_nUXQ";