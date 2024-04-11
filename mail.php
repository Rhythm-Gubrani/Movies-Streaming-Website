<?php
session_start();
?>

<?php

require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/Exception.php'; 
require_once 'PHPMailer/class.phpmailer.php';
require_once 'PHPMailer/class.smtp.php';
$mail = new PHPMailer();

//SMTP Settings
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'seriesaddict5000@gmail.com';
$mail->Password = 'addict5000';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
//Email Settings
$mail->setFrom('nicolastassin598@gmail.com');
$mail->addAddress('nicolastassin598@gmail.com');
$mail->Subject = 'Recovery lost password';
$mail->Body = 'Bonjour';
if($mail->Send()){
    echo 'Email sent! Check your inbox :)';
}else{
    echo 'Something went wrong, the email was not sent !';
}
?>
<?php include('footer.php'); ?>