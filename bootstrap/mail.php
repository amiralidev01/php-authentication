<?php

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = $mail_config->host;
$mail->SMTPAuth = $mail_config->smtp_auth;
$mail->Port = $mail_config->port;
$mail->Username = $mail_config->username;
$mail->Password = $mail_config->password;
