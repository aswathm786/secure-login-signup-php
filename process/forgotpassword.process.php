<?
require_once __DIR__ . '/../config/config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forgotpassword'])) {
    if (User::isValidEmail($_POST['email'])) {
        $email = User::sanitizeInput($_POST['email']);
    } else {
        Session::set('error', 'Enter Valid Email');
        header("Location: ../forgot-password/");
        exit();
    }
    Session::set('forgotpassword', 1);
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);
    $conn = Database::getconnection();
    $sql = "UPDATE userdb SET resettoken = ?, resettoken_expiry = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();
    if ($stmt->affected_rows) {

        $mail = email::mailer();
        $mail->setFrom('n16052242@gmail.com', 'Ninja Support');
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Password Reset</title>
            <style>
                /* Reset styles */
                body {
                    margin: 0;
                    padding: 0;
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                }
        
                /* Responsive styles */
                @media only screen and (max-width: 600px) {
                    .container {
                        width: 100% !important;
                    }
        
                    .reset-button {
                        width: 100% !important;
                        margin: 10px 0 !important;
                    }
                }
            </style>
        </head>
        
        <body style="margin: 0; padding: 0;">
        
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td align="center">
                        <table class="container" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 5px; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);">
                            <tr>
                                <td style="padding: 40px 20px; text-align: center;">
                                    <h1 style="margin-bottom: 30px; color: #333;">Reset Your Password</h1>
                                    <p style="font-size: 16px; line-height: 24px; color: #666;">To reset your password, click the button below:</p>
                                    <a href="http://aswath.selfmade.cool/reset-password/resetpassword.php?token=$token" style="display: inline-block; text-decoration: none; padding: 12px 30px; margin-top: 30px; background-color: #007bff; color: #ffffff; border-radius: 5px; font-size: 16px; line-height: 24px; text-align: center; transition: background-color 0.3s;">Reset Password</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        
        </body>
        
        </html>
        
        

    END;

        try {

            $mail->send();
        } catch (Exception $e) {

            Session::set('success', "Message could not be sent. Mailer error: {$mail->ErrorInfo}");
            header('Location: ../forgot-password');
            exit();
        }
    }

    Session::set('success', 'Message sent, please check your inbox.');
    header('Location: ../forgot-password');
    exit();
} else {
    header('Location: /');
    exit();
}
