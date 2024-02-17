<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include './main/function.php';
include './main/conn.php';
$id = $obj->selectfieldwhere("users", "id", "email = '" . $_POST['email'] . "'");
if (empty($id)) {
    echo "<div  class='bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md' role='alert'>Email Not Registered!</div>";
    die;
}
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = "$sendmailfrom";
$mail->Password = "$sendemailpassword";
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom("$sendmailfrom", 'Gati Tour Team');;
$mail->addAddress($_POST['email']);
$mail->isHTML(true);
$mail->Subject = "Password Reset";
$mail->AddEmbeddedImage('main/images/indstock.png', 'logo', 'main/images/indstock.png ');
$mail->AddEmbeddedImage('main/images/envelope.png', 'envelope', 'main/images/envelope.png ');
$mail->Body = "<div style='text-align:center'><img alt='PHPMailer' style='height:80px;width:150px' src='cid:logo'> </div>
    <div style='border:1px solid darkblue;width:90%;margin:auto'></div><br>
    <div style='text-align:center;margin: auto;width:100%'>
        <img src='cid:envelope' style='height:130px;width:130px' alt='logo'>
        <h3>Hii! 'Mohammed' </h3>
        <div style='font-weight: 600;'>Click below to reset your password. </div>
        <div style='font-weight: 600;'><a href='http://localhost/gatitour/resetpassword?hakuna=$id'>Password Reset</a></div>
    </div>";
$mail->send();
