<?php
require_once __DIR__ . '/../config/config.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loginprocess'])) {
    // Check if email and password are set in the POST request
    if (isset($_POST['email'], $_POST['password'])) {
        // Check if "remember" checkbox is checked and set the session accordingly
        if (isset($_POST['remember'])) {
            Session::set('remember', '1');
        }

        // Get email and password from the POST data
        if (User::isValidEmail($_POST['email'])) {
            $email = User::sanitizeInput($_POST['email']);
        } else {
            Session::set('error', 'Enter Valid Email');
            header("Location: ../app/login.php");
            exit();
        }
        if (User::isValidPassword($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            Session::set('error', 'Enter Valid Password');
            header("Location: ../app/login.php");
            exit();
        }

        // Authenticate user based on provided email and password
        if (Usersession::authenticate($email, $password)) {
            // Redirect to the homepage if authentication is successful
            header("Location: ../");
            exit();
        } else {
            // If authentication fails, set an error message and redirect to the login page
            Session::set('error', "Incorrect Password");
            header("Location: ../app/login.php");
            exit();
        }
    } else {
        // If email or password is not provided, set an error message and redirect to the login page
        Session::set('error', "Please provide both email and password");
        header("Location: ../app/login.php");
        exit();
    }
} else {
    header('Location: /');
    exit();
}
