<?php
require_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['remember']) && !isset($_COOKIE['Token'])) {
    Session::logout();
    header("Location: /");
    exit();
}

// Check if the request method is POST and the 'changepassword' parameter is set
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['changepassword'])) {
    // Check if the entered new password matches the confirm password
    if ($_POST['newPassword'] === $_POST['confirmPassword']) {
        // Validate the new 
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        if (User::isValidPassword($newPassword)) {
            // If the password is valid, update the user's password
            Usersession::newpassverify($oldPassword, $newPassword);
        } else {
            // If the new password is invalid, set an error message and redirect
            Session::set('error', 'Enter a valid new password. Password must meet certain criteria.');
            header("Location: ../change-password/");
            exit();
        }
    } else {
        // If new and confirm passwords don't match, set an error message and redirect
        Session::set('error', 'New and confirm passwords should match.');
        header("Location: ../change-password/");
        exit();
    }
} else {
    // If not a POST request with 'changepassword' parameter, redirect to the change password page
    header("Location: /");
    exit();
}
