<?php
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};



require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
require '../phpmailer/src/Exception.php';



$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug =  SMTP::DEBUG_OFF; //SMTP::DEBUG_SERVER;
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.hostinger.com';                
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'evimport@evimport.shop';                    
    $mail->Password   = "21235022Rha.";                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('evimport@evimport.shop', 'EVimport');
    $mail->addAddress('srhafaelle@gmail.com', 'Sergio Belisario');   


    //Content
    $mail->isHTML(true);                          
    $mail->Subject = 'Detalles de Compra';
    $cuerpo = '<h4>Gracias por su compra</h4>';
    $cuerpo .= '<p>El ID de su compra es <b>' .  $id_transaccion . '</b></p>';

    $mail->Body = utf8_decode($cuerpo);
    $mail->AltBody = 'Le enviamos los detalles de su compra';

    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

    $mail->send();
    
   
} catch (Exception $e) {
    echo "Error al enviar el correo de la compra: {$mail->ErrorInfo}";
    
   
}
?>