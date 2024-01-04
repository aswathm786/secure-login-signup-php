<?php
require_once __DIR__ . '/../config/config.php';
if (isset($_SESSION['remember']) && !isset($_COOKIE['Token'])) {
    Session::logout();
    header("Location: /");
    exit();
}
if (isset($_SESSION['login'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Change Password</title>
        <link rel="icon" href="../ninjafavicon.png" type="image/x-icon">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f7f7f7;
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

            .change-box {
                width: 350px;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }
        </style>
    </head>

    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 change-box">
                    <h2 class="text-center mb-4">Change Password</h2>
                    <form action="../process/changepassword.process.php" method="post">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<div class="error-message" role="alert">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<div class="success" role="alert">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <div class="form-group">
                            <label for="oldPassword">Old Password:</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password:</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password:</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <input type="hidden" name="changepassword" value="1">
                        <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                    </form>
                    <a href="/" class="btn btn-secondary btn-block mt-3">Home</a>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location: ../");
    exit();
}
?>