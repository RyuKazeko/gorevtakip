<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

function sendMail($from, $to, $subject, $body){
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "Smtp.gmail.com";
    $mail->Port = 587;
    $mail->Username   = "SmartTaskTest08@gmail.com";
    $mail->Password   = "pqcz zdol zqyc mjat";
    $mail->setFrom($from, name: "Smart Beylikdüzü");
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //$mail->AltBody = $body;

    if (gettype($to) == "array") {
        foreach ($to as $adress) {
            if (PHPMailer::validateAddress($adress)) {
                $mail->addAddress($adress, 'Sayın Kullanıcı');
            }
        }
    } else {
        $mail->addAddress($to, 'Sayın Kullanıcı');
    }
    $mail->isHTML(true);
    $mail->MsgHTML($body);
   try{
    $mail->send();
    echo "Mesaj Gönderimi başarılı.";
   }catch(Exception $e){
    echo $e->getMessage();
}
}

sendMail("SmartTaskTest08@gmail.com", $to, $subject, $body);

?>