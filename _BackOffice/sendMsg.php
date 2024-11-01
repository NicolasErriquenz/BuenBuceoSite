<?php 
    echo $_SERVER["REQUEST_METHOD"];
    var_dump($_POST);

    if(!isset($_POST["msg"]) || !isset($_POST["name"]) || !isset($_POST["email"])){
        
        die();
    }
    // Permitir peticiones desde cualquier origen
    header("Access-Control-Allow-Origin: *");

    // Permitir los métodos GET, POST, PUT, DELETE, OPTIONS
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

    // Permitir los encabezados Content-Type y Authorization
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    // Permitir cookies en solicitudes cruzadas
    header("Access-Control-Allow-Credentials: true");

    $para = 'info@buenbuceo.ar';
    //$para = 'nerriquenz@gmail.com';
    $para = 'facundo.mior@gmail.com';
    $asunto = 'BuenBuceo - Contacto desde sitio web - ('.$_POST["name"].")";
    $mensaje = $_POST["msg"];

    // Construct email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: BuenBuceoSite <info@buenbuceo.ar>" . "\r\n";
    //$headers .= "Cc: cc@example.com" . "\r\n"; // Add Cc if needed
    //$headers .= "Bcc: bcc@example.com" . "\r\n"; // Add Bcc if needed

    $message = "
    <html>
    <head>
        <title>$asunto</title>
    </head>
    <body>
        <h3>Correo de contacto recibido desde sitio web</h3>
        <p>Nombre: <b>".$_POST['name']."</b></p>
        <p>Email: <b>".$_POST['email']."</b></p>
        <p>Mensaje: <b>".$_POST['msg']."</b></p>
    </body>
    </html>
    ";

    // Envío del correo
    if (mail($para, $asunto, $message, $headers)) {
        echo 'El correo se ha enviado correctamente.';
    } else {
        echo 'Error al enviar el correo.';
    }

?>