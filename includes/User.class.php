<?php
require_once __DIR__ . '/../config/config.php';

class User
{
    public static function isValidName($userInput)
    {
        // Check for whitespace in the middle
        if (empty(trim($userInput))) {
            return false;
        }
        if (User::containsHtmlEntities($userInput)) {
            return false;
        }
        if (preg_match('/^[a-zA-Z]+$/', $userInput)) {
            return true;
        }
        return false;
    }
    public static function isValidEmail($email)
    {
        // Check for whitespace characters
        if (strpos($email, ' ') !== false) {
            return false;
        }

        // Validate email format using a regular expression
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function sanitizeInput($input)
    {
        // Remove potentially harmful characters for SQL queries
        $sanitizedInput = htmlspecialchars($input);
        return $sanitizedInput;
    }

    public static function isValidPassword($pass)
    {
        // Check for whitespace characters
        if (strpos($pass, ' ') !== false) {
            return false;
        }
        // Check for minimum password length (change 8 to your desired minimum length)
        if (strlen($pass) < 8) {
            return false;
        }
        // Check for at least one uppercase letter, one lowercase letter, and one digit
        if (!preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/[0-9]/', $pass)) {
            return false;
        }
        // Check for at least one special character (you can adjust the set of allowed special characters)
        if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $pass)) {
            return false;
        }
        // Password passed all validation criteria
        return true;
    }

    public static function isValidUsername($username)
    {
        // Check for maximum length of 10 characters
        // if (strlen($username) > 5) {
        //     return false;
        // }
        // Check for presence of whitespace
        if (strpos($username, ' ') !== false) {
            return false;
        }
        // Check for presence of at least one digit (0-9)
        if (!preg_match('/[0-9]/', $username)) {
            return false;
        }

        if (User::containsHtmlEntities($username)) {
            return false;
        }
        // Username passed all validation criteria
        return true;
    }

    public static function containsHtmlEntities($input)
    {
        $decoded = htmlspecialchars_decode($input);
        return $decoded !== $input;
    }



    // Hashes the given password using bcrypt algorithm
    public static function hash_pass($pass)
    {
        $options = [
            'cost' => 12, // Cost parameter for bcrypt (higher is slower but more secure)
        ];
        return password_hash($pass, PASSWORD_BCRYPT, $options);
    }

    // Verifies if the provided password matches the hashed password
    public static function pass_verify($pass, $hash)
    {
        return password_verify($pass, $hash);
    }

    // Retrieves the current timestamp
    public static function gettime()
    {
        return time();
    }

    // Retrieves the user's IP address
    public static function getip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    // Retrieves the user agent information (browser, device)
    public static function getagent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
