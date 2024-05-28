<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    post_gmail(); // Llama a la función post_gmail() cuando se envía el formulario
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Correo Electrónico</title>
</head>
<body>
    <h2>Enviar Correo Electrónico</h2>
    <form method="post">
        <label for="asunto">Asunto:</label><br>
        <input type="text" id="asunto" name="asunto"><br>
        <label for="contenido">Contenido:</label><br>
        <textarea id="contenido" name="contenido"></textarea><br>
        <label for="para">Para:</label><br>
        <input type="email" id="para" name="para"><br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function gmail()
  {
    $data =
    [
      'title' => 'Recuperación Contraseña'
    ];
 
    //View::render('gmail', $data);
  }
 
  function post_gmail()
  {
    try {
      // Contenido del correo
      $asunto    = ($_POST["asunto"]);
      $contenido = ($_POST["contenido"]);
      $para      = ($_POST["para"]);
 
      if (!filter_var($para, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Dirección de correo electrónico no válida.');
      }
 
      // Intancia de PHPMailer
      $mail                = new PHPMailer();
   
      // Es necesario para poder usar un servidor SMTP como gmail
      $mail->isSMTP();
   
      // Si estamos en desarrollo podemos utilizar esta propiedad para ver mensajes de error
      //SMTP::DEBUG_OFF    = off (for production use) 0
      //SMTP::DEBUG_CLIENT = client messages 1 
      //SMTP::DEBUG_SERVER = client and server messages 2
      $mail->SMTPDebug     = SMTP::DEBUG_SERVER;
   
      //Set the hostname of the mail server
      $mail->Host          = 'smtp.gmail.com';
      $mail->Port          = 587; // o 587
   
      // Propiedad para establecer la seguridad de encripción de la comunicación
      $mail->SMTPSecure    = PHPMailer::ENCRYPTION_SMTPS; // tls o ssl para gmail obligado
   
      // Para activar la autenticación smtp del servidor
      $mail->SMTPAuth      = true;
 
      // Credenciales de la cuenta
      $email              = 'phophypxndx@gmail.com';
      $mail->Username     = $email;
      $mail->Password     = 'xztoewxljnyvqdpi';
   
      // Quien envía este mensaje
      $mail->setFrom($email, 'COTIPRO');
 
      // Si queremos una dirección de respuesta
      $mail->addReplyTo('NOreplyto@panchos.com', 'No Conteste este Mensaje');
   
      // Destinatario
      $mail->addAddress($para, 'John Doe');
   
      // Asunto del correo
      $mail->Subject = $asunto;
 
      // Contenido
      $mail->IsHTML(true);
      $mail->CharSet = 'UTF-8';
      $mail->Body    = sprintf('<h1>El mensaje es:</h1><br><p>%s</p>', $contenido);
   
 
      // Agregar algún adjunto
      //$mail->addAttachment(IMAGES_PATH.'logo.png');
   
      // Enviar el correo
      if (!$mail->send()) {
        throw new Exception($mail->ErrorInfo);
      }
 
      //Flasher::success(sprintf('Mensaje enviado con éxito a %s', $para));
      //Redirect::back();
 
    } catch (Exception $e) {
      //Flasher::error($e->getMessage());
      //Redirect::back();
    }
  }
  
  ?>