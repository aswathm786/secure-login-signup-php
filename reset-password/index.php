<?php
require_once __DIR__ . '/../config/config.php';
if (isset($_SESSION['token_invalid'])) {
    Session::unset('token_invalid');

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Token Expired</title>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .token-expired-container {
                max-width: 400px;
                margin: 100px auto;
                background: #fff;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <div class="token-expired-container">
                <h2>Token Expired</h2>
                <p>The password reset link has expired or is invalid.</p>
                <p>Please request a new link to reset your password.</p>
                <a href="../forgot-password/" class="btn btn-primary">Request Again</a>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>

    </html>

<?
} else {
    header("Location: /");
    exit();
}

?>