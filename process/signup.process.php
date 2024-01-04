<?php
// Include necessary files

require_once '../config/config.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['signupprocess'])) {
    $conn = Database::getconnection();
    // Retrieve form data
    if (User::isValidName($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        Session::set('error', 'Enter Valid Name');
        header("Location: ../app/signup.php");
        exit();
    }
    if (User::isValidEmail($_POST['email'])) {
        $email = User::sanitizeInput($_POST['email']);
    } else {
        Session::set('error', 'Enter Valid Email');
        header("Location: ../app/signup.php");
        exit();
    }

    $username = $_POST['username'];
    if (User::IsValidUsername($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        Session::set('error', 'Enter Valid Username');
        header("Location: ../app/signup.php");
        exit();
    }

    if (User::isValidPassword($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        Session::set('error', 'Enter Valid Password');
        header("Location: ../app/signup.php");
        exit();
    }

    // Check if the username or email already exists in the database
    $sql1 = "SELECT * FROM userdb WHERE username=? OR email=? LIMIT 1";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ss", $username, $email); // Bind parameters
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        // Username or email already exists, set error message and redirect to signup page
        $_SESSION['error'] = "Username or email already exists";
        $stmt1->close();
        header('Location: ../app/signup.php');
        exit();
    } else {
        // Hash the password using User::hash_pass() method
        $hashed_password = User::hash_pass($password);

        // Insert new user data into the database using prepared statement
        $sql = "INSERT INTO userdb (`Name`, `Username`, `Email`, `Password`) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $username, $email, $hashed_password); // Bind parameters
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Signup successful, redirect to login page
            $stmt->close();
            header("Location: ../app/login.php");
            exit();
        } else {
            // Signup failed, set error message and redirect to signup page
            $stmt->close();
            $_SESSION['error'] = "Signup Failed..!";
            header('Location: ../app/signup.php');
            exit();
        }
    }
} else {
    header("Location: /");
    exit();
}
