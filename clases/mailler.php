<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class Mailer{

    function envairEmail($email, $asunto,$cuerpo){
        require_once __DIR__.'/../config/config.php';
        require __DIR__.'/../phpmailer/src/PHPMailer.php';
        require __DIR__.'/../phpmailer/src/SMTP.php';
        require __DIR__.'/../phpmailer/src/Exception.php';


        $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF; //SMTP::DEBUG_OFF; si no se quiere mostrar los debug
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.hostinger.com';   //para gmail                
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'evimport@evimport.shop';                    
    $mail->Password   = "21235022Rha.";                               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('evimport@evimport.shop', 'EVimport');
    $mail->addAddress( $email);   


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;
   
 

    $mail->Body = utf8_decode($cuerpo);
    $mail->AltBody = $cuerpo;
    $mail->setLanguage('es', '../phpmailer/language/phpmailer.lang-es.php');

   if($mail->send()) {
    return true;
   }else{
    return false;
   }
    
   
} catch (Exception $e) {
    echo "Error al enviar el correo de la compra: {$mail->ErrorInfo}";
    return false;
   
}
    }

}






?>