<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../PHPMAILER/Exception.php';
require __DIR__ . '/../PHPMAILER/PHPMailer.php';
require __DIR__ . '/../PHPMAILER/SMTP.php';

class email
{
    public static function mailer()
    {
        if (isset($_SESSION['forgotpassword'])) {

            Session::unset('forgotpassword');

            // Load configuration from JSON file
            $config = json_decode(file_get_contents('../config/config.json'), true);

            $mail = new PHPMailer(true);

            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $config['gmail_username']; // Read username from config file
            $mail->Password = $config['gmail_app_password']; // Read app-specific password from config file
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;


            $mail->isHtml(true);

            return $mail;
        } else {
            // If not a POST request with 'changepassword' parameter, redirect to the change password page
            header("Location: /");
            exit();
        }
    }
}
