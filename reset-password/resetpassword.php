<?php
require_once __DIR__ . '/../config/config.php';
$token = '';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token = hash("sha256", $token);
    $conn = Database::getconnection();
    $sql = "SELECT * FROM userdb WHERE resettoken = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $expiry = $row['resettoken_expiry'];
        $username = $row['Username'];
        $time = time();
        if ($expiry > $time) {
?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Password Reset</title>
                <!-- Bootstrap CSS -->
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        background-color: #f7f7f7;
                    }

                    .reset-form {
                        max-width: 400px;
                        margin: 50px auto;
                        background: #fff;
                        padding: 20px;
                        border-radius: 5px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }

                    .error-message {
                        color: red;
                        margin-bottom: 10px;
                    }
                </style>
            </head>

            <body>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 reset-form">
                            <h2 class="text-center mb-4">Reset Password</h2>
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                                unset($_SESSION['error']);
                            }
                            ?>
                            <form id="resetPasswordForm" method="POST" action="../process/reset.process.php">
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                </div>
                                <input type="hidden" name="username" value="<?= $username ?>">
                                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap JS and dependencies -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <script>
                    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
                        var password = document.getElementById('newPassword').value;
                        var confirmPassword = document.getElementById('confirmPassword').value;

                        if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password) || /\s/.test(password)) {
                            alert('Password must have at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 special character, and no whitespace.');
                            event.preventDefault();
                        } else if (password !== confirmPassword) {
                            alert('Passwords do not match.');
                            event.preventDefault();
                        }
                    });
                </script>

            </body>

            </html>

<?php
        } else {
            $stmt->close();
            Session::set('token_invalid', 1);
            header("Location: ./index.php");
            exit();
        }
    } else {
        $stmt->close();
        Session::set('token_invalid', 1);
        header("Location: ./index.php");
        exit();
    }
} else {
    header("Location: /");
    exit();
}
?>