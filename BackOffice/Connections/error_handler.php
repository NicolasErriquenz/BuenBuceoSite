<?php
// 1. Verificar que las constantes necesarias estén definidas
if (!defined('LOGGING_ENABLED')) {
    define('LOGGING_ENABLED', true);
}
if (!defined('RUTA_LOG')) {
    if (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === 'buenbuceo'))
        define("RUTA_LOG", $_SERVER['DOCUMENT_ROOT'] . '/_logs/php_errors.log');
    else
        define("RUTA_LOG", $_SERVER['DOCUMENT_ROOT'] . '/_AdminBuenBuceo_/logs/php_errors.log');
}

// 2. Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Definir función de logging
function custom_error_log($message, $level = 'ERROR') {
    if (LOGGING_ENABLED) {
        $date = date('Y-m-d H:i:s');
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        
        // Obtener el origen real del error
        $errorFile = isset($trace[0]['file']) ? $trace[0]['file'] : 'unknown';
        $errorLine = isset($trace[0]['line']) ? $trace[0]['line'] : 0;
        
        $log_message = sprintf(
            "[%s] %s: %s\nArchivo: %s\nLínea: %d\nStack trace:\n",
            $date,
            strtoupper($level),
            $message,
            $errorFile,
            $errorLine
        );

        // Agregar stack trace
        foreach ($trace as $i => $t) {
            $log_message .= sprintf(
                "#%d %s(%d): %s%s%s()\n",
                $i,
                isset($t['file']) ? $t['file'] : 'unknown',
                isset($t['line']) ? $t['line'] : 0,
                isset($t['class']) ? $t['class'] : '',
                isset($t['type']) ? $t['type'] : '',
                $t['function']
            );
        }
        
        $log_message .= "--------------------------------\n";
        
        error_log($log_message, 3, RUTA_LOG);
    }
}

// Y en el error handler:
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    $fullMessage = sprintf(
        "%s\nArchivo: %s\nLínea: %d",
        $errstr,
        $errfile,
        $errline
    );
    custom_error_log($fullMessage, 'ERROR');
    
    if (IS_LOCAL) {
        echo "<div style='background-color: #ffe6e6; border: 1px solid #ff8080; padding: 10px; margin: 10px;'>";
        echo "<strong>Error:</strong> $errstr<br>";
        echo "<strong>Archivo:</strong> $errfile<br>";
        echo "<strong>Línea:</strong> $errline<br>";
        echo "</div>";
    }
    
    return false;
});
set_exception_handler(function($e) {
    custom_error_log($e->getMessage() . "\nStack trace: " . $e->getTraceAsString(), 'EXCEPTION');
    
    if (IS_LOCAL) {
        echo "<div style='background-color: #ffe6e6; border: 1px solid #ff8080; padding: 10px; margin: 10px;'>";
        echo "<strong>Excepción:</strong> " . $e->getMessage() . "<br>";
        echo "<strong>Archivo:</strong> " . $e->getFile() . "<br>";
        echo "<strong>Línea:</strong> " . $e->getLine() . "<br>";
        echo "<strong>Stack trace:</strong><pre>" . $e->getTraceAsString() . "</pre>";
        echo "</div>";
    }
});

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        custom_error_log($error['message'], 'FATAL');
        
        if (IS_LOCAL) {
            echo "<div style='background-color: #ffe6e6; border: 1px solid #ff8080; padding: 10px; margin: 10px;'>";
            echo "<strong>Error Fatal:</strong> " . $error['message'] . "<br>";
            echo "<strong>Archivo:</strong> " . $error['file'] . "<br>";
            echo "<strong>Línea:</strong> " . $error['line'];
            echo "</div>";
        }
    }
});

// 5. Log inicial del sistema (solo una vez por día)
if (!isset($_SESSION['log_initialized']) || $_SESSION['log_initialized'] !== date('Y-m-d')) {
    custom_error_log("Sistema iniciado", 'INFO');
    $_SESSION['log_initialized'] = date('Y-m-d');
}