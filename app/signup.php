<?php
// Including necessary configuration files
require_once __DIR__ . '/../config/config.php';
if (!isset($_SESSION['login'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Sign Up</title>
        <link rel="icon" href="../ninjafavicon.png" type="image/x-icon">
        <link rel="stylesheet" href="signup.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .error-message {
                color: red;
                text-align: center;
                margin-bottom: 15px;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="signup-box">
                <!-- Signup form -->
                <form action="../process/signup.process.php" class="needs-validation" method="POST" novalidate>
                    <h2>Sign Up</h2>
                    <!-- Display error message if exists -->
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>

                    <!-- Name input field -->
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                        <div class="invalid-feedback">Please enter your name.</div>
                    </div>

                    <!-- Username input field -->
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                        <div id="username-feedback"></div>
                    </div>

                    <!-- Email input field -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>

                    <!-- Password input field with validation -->
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" title="Password must contain at least one number, one uppercase, one lowercase letter, one special character, and be at least 8 characters long">
                            <!-- Toggle password visibility button -->
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-lock"></i></button>
                            </div>
                        </div>
                        <!-- Password validation feedback messages -->
                        <div class="valid-feedback">Password meets criteria.</div>
                        <div class="invalid-feedback">Password must contain at least one number, one uppercase, one lowercase letter, one special character, and be at least 8 characters long.</div>
                        <div class="password-condition"></div>
                    </div>
                    <input type="hidden" name="signupprocess" value="1">
                    <!-- Submit button -->
                    <input type="submit" value="Sign Up" class="btn btn-primary btn-block">
                </form>
                <!-- Link to the login page -->
                <p class="login-link text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>

        <!-- Bootstrap JS and jQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Custom JavaScript -->
        <script src="signup.js"></script>
    </body>

    </html>

<?
} else {
    header("Location: /");
    exit();
}
?>