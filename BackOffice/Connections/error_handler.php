<?php
// error_handler.php

// Asegurarnos que la carpeta de logs existe
$logDir = __DIR__ . '/_logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0755, true);
}

// Handler para errores de PHP
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $fecha = date('Y-m-d H:i:s');
    $mensaje = "[$fecha] Error $errno: $errstr en $errfile:$errline";
    
    // Guardar en archivo de log
    error_log($mensaje . PHP_EOL, 3, '_logs/php_errors.log');
    
    // Si estamos en desarrollo, mostrar el error
    if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'buenbuceo') {
        echo "<pre>$mensaje</pre>";
    }
    
    return true;
});

// Handler para excepciones no capturadas
set_exception_handler(function($e) {
    $fecha = date('Y-m-d H:i:s');
    $mensaje = "[$fecha] Excepción no capturada: " . $e->getMessage() . 
               " en " . $e->getFile() . ":" . $e->getLine() . 
               "\nStack trace: " . $e->getTraceAsString();
    
    // Guardar en archivo de log
    error_log($mensaje . PHP_EOL, 3, '_logs/php_errors.log');
    
    // Si estamos en desarrollo, mostrar el error
    if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'buenbuceo') {
        echo "<pre>$mensaje</pre>";
    }
});

// Handler para errores fatales
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $fecha = date('Y-m-d H:i:s');
        $mensaje = "[$fecha] Error Fatal: {$error['message']} en {$error['file']}:{$error['line']}";
        error_log($mensaje . PHP_EOL, 3, '_logs/php_errors.log');
    }
});