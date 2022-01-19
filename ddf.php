<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
try
{
$mail->SMTPDebug = 2;                   // Enable verbose debug output
$mail->isSMTP();                        // Set mailer to use SMTP
$mail->Host       = 'smtp.gmail.com';    // Specify main SMTP server
$mail->SMTPAuth   = true;               // Enable SMTP authentication
$mail->Username   = 'projectcms05@gmail.com';     // SMTP username
$mail->Password   = 'teaching@123';         // SMTP password
$mail->SMTPSecure = 'tls';              // Enable TLS encryption, 'ssl' also accepted
$mail->Port       = 587;    
$mail->setFrom('projectcms05@gmail.com', 'Name');           // Set sender of the mail
$mail->addAddress('harshkandpal774@gmail.com');           // Add a recipient
$mail->addAddress('harshkandpal774@gmail.com', 'Name');
$mail->isHTML(true);                                  
$mail->Subject = 'Subject';
$mail->Body    = 'HTML message body in <b>bold</b> ';
$mail->AltBody = 'Body in plain text for non-HTML mail clients';
$mail->send();
echo "Mail has been sent successfully!";
} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"