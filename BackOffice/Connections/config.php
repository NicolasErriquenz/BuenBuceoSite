<?php

	// Control de entorno y logging
	define('IS_LOCAL', $_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'buenbuceo');
	define('LOGGING_ENABLED', true);
	define('DISPLAY_ERRORS', true);  // Variable global para control de errores
	define('SHOW_ERRORS_IN_PROD', true);  // Nueva variable para control en producción

	// Configuración de errores según entorno
	if (IS_LOCAL || SHOW_ERRORS_IN_PROD) {
	    ini_set('display_errors', 1);
	    error_reporting(E_ALL);
	} else {
	    ini_set('display_errors', 0);
	    error_reporting(0);
	}

	// Configurar ruta de logs
	if (IS_LOCAL) {
	    define("RUTA_LOG", $_SERVER['DOCUMENT_ROOT'] . '/_logs/php_errors.log');
	} else {
	    define("RUTA_LOG", $_SERVER['DOCUMENT_ROOT'] . '/_AdminBuenBuceo_/_logs/php_errors.log');
	}

	// Incluir manejador de errores
	require_once __DIR__ . '/error_handler.php';

	// Asegurar directorio y archivo de logs
	$logDir = dirname(RUTA_LOG);
	if (!file_exists($logDir)) {
	    @mkdir($logDir, 0777, true);
	    @chmod($logDir, 0777);
	}
	if (!file_exists(RUTA_LOG)) {
	    @touch(RUTA_LOG);
	    @chmod(RUTA_LOG, 0666);
	}

	// 4. CONFIGURACIÓN DE BASE DE DATOS
	if (IS_LOCAL) {
	    $dbhost = 'localhost';
	    $dbusername = 'root';
	    $dbpasswd = '';
	    $database_name = 'BuenBuceo';
	} else {
	    $dbhost = '193.203.175.53';
	    $dbusername = 'u229759960_buceo';
	    $dbpasswd = 'Rosario440';
	    $database_name = 'u229759960_buenbuceo';
	}

	// 5. CONFIGURACIÓN DE LA APLICACIÓN
	define("SITE_TITLE", "BuenBuceo - Admin");
	define("MARCA", "BuenBuceo");
	define("RUTA_FILE_VIAJES", "_recursos/viajes_pdf/");

	// 6. ASSETS Y RECURSOS
	$FAVICON_32 = "images/icon/bb_favicon_32x32.png";
	$FAVICON_192 = "images/icon/bb_favicon_192x192.png";
	$FAVICON_180 = "images/icon/bb_favicon_180x180.png";
	$redirect_uri = 'index.php';

	// 7. CONFIGURACIÓN DE NOTIFICACIONES
	$GCMApiKey = "AIzaSyDo_mNa_skr5qOakPPL8jAy0hi4jhmMEuw";
	$diasNotificarInactividad = 3;
	$diasNotificarSinMovimientos = 2;

	// 8. TOKENS Y AUTENTICACIÓN
	$TOKEN_BCRA = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3NjE2MDg0ODQsInR5cGUiOiJleHRlcm5hbCIsInVzZXIiOiJuZXJyaXF1ZW56QGdtYWlsLmNvbSJ9.TSyyPz0oicx_RAi_6NQp8058TA6ZIbN5e_9R6rrO1VqeYPgdeTW9r9TwN-xonrAMmJxanKBqDTPY3JTqW_nUXQ";
	$AUTH_BEARER = "Authorization: BEARER " . $TOKEN_BCRA;

	// 9. CONFIGURACIÓN DE FORMATO DE FECHAS
	$dateFormat = "d-m-Y";
	$sessionDateFormat = "Y-m-d";
	$timeFormat = "H:i:s";
	$dateTimeFormat = $dateFormat.' '.$timeFormat;
	$lang = "es";

	// 10. CONFIGURACIÓN DE IMÁGENES DE FONDO
	$num_imagenes = 68;
	$imagenes = array_map(function($i) { return "bg$i.JPG"; }, range(1, $num_imagenes));
	$imagen = $imagenes[array_rand($imagenes)];
	$HEADER_IMAGEN = '<div class="position-absolute w-100 min-height-300 top-0" style="background-image: url(\'images/' . $imagen . '\'); background-position-y: 50%;"><span class="mask bg-primary opacity-6"></span></div>';
	$HEADER_PLANO = '<div class="min-height-300 bg-dark position-absolute w-100"></div>';

	// 11. UTILIDADES
	$archivoActual = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

	define("SUBRUBRO_ID_ALQUILER_EQUIPOS", 12);
	define("SUBRUBRO_ID_PAQUETE_TURISTICO", 19);
	define("XLS_FILE_PREFIX", "");

	// 13. Log inicial (solo una vez por sesión)
	if (LOGGING_ENABLED && (!isset($_SESSION['log_initialized']) || $_SESSION['log_initialized'] != date('Y-m-d'))) {
	    error_log("[" . date('Y-m-d H:i:s') . "] INFO: Sistema iniciado - Nueva sesión\n", 3, RUTA_LOG);
	    $_SESSION['log_initialized'] = date('Y-m-d');
	}