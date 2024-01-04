<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_SESSION['login'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
        <link rel="icon" href="../ninjafavicon.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .error-message {
                color: red;
                text-align: center;
                margin-bottom: 15px;
            }

            .success {
                color: green;
                text-align: center;
                margin-bottom: 15px;
            }

            .login-box {
                width: 350px;
                padding: 20px;
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .input-field {
                position: relative;
                margin-bottom: 20px;
            }

            .input-field i {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                left: 10px;
                color: #aaa;
            }

            .input-field input {
                width: calc(100% - 50px);
                padding-left: 10px;
                border-radius: 5px;
                height: 40px;
                border: 1px solid #ccc;
            }

            .btn {
                width: 100%;
                padding: 10px;
                border: none;
                border-radius: 5px;
                background-color: #007bff;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn:hover {
                background-color: #0056b3;
            }

            .signup-link {
                text-align: center;
                margin-top: 20px;
            }

            .signup-link a {
                color: #007bff;
            }

            .input-field input[type="checkbox"] {
                width: 20px;
                height: 20px;
                margin-right: 10px;
                vertical-align: middle;
            }

            .input-field label {
                font-size: 16px;
                vertical-align: middle;
            }

            .alert {
                color: red;
                text-align: center;
                margin-bottom: 15px;
            }

            .forgetpass {
                text-align: center;
            }
        </style>
    </head>

    <body>
        <div class="login-box">
            <!-- Login form -->
            <form action="../process/login.process.php" class="form" method="post">
                <h2>Login</h2>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="error-message" role="alert">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    echo '<div class="success" role="alert">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }
                ?> <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                <div class="input-field">
                    <i class="fas fa-envelope" style="margin-right: 10px;"></i>
                    <input type="text" placeholder="Email" name="email" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock" style="margin-right: 10px;"></i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-field">
                    <input type="checkbox" id="remember-me" name="remember">
                    <label for="remember-me">Remember Me</label>
                </div>
                <input type="hidden" name="loginprocess" value="1">
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
            <div class="input-field forgetpass">
                <a href="../forgot-password/">Forgot Password?</a>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    </body>

    </html>
<?
} else {
    header("Location: /");
    exit();
}
