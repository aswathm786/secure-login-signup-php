<?php
require_once __DIR__ . '/../config/config.php';

class Usersession
{
    // Authenticates user credentials (email and password)
    public static function authenticate($email, $password)
    {
        $conn = Database::getconnection(); // Get database connection
        $sql = "SELECT * FROM `userdb` WHERE `Email` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); // Bind the email parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row['Password'];
            $username = $row['Username'];
            $time = User::gettime(); // Get current time
            $ip = User::getip(); // Get user's IP address
            $agent = User::getagent(); // Get user agent information
            $token = md5(rand(0, 9999) . $time . $ip . $agent); // Generate a token

            if (User::pass_verify($password, $hash)) { // Verify password
                $sql1 = "INSERT INTO `userconn` (`Username`, `Token`, `Time`, `Ip`, `Agent`) VALUES (?, ?, ?, ?, ?)";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param("sssss", $username, $token, $time, $ip, $agent); // Bind parameters
                $stmt1->execute();

                if ($stmt1->affected_rows > 0) {
                    Session::set('Token', $token);
                    Session::set('Greeting', 'Hello');
                    if (isset($_SESSION['remember'])) {
                        Session::setcookie('Token', $token);
                    }
                    $stmt1->close();
                    $stmt->close();
                    return true;
                } else {
                    $stmt1->close();
                    return false;
                }
            } else {
                return false;
            }
        } else {
            $_SESSION['error'] = "No user found";
            $stmt->close();
            header("Location: ../app/login.php");
            exit();
        }
    }

    // Authorizes the user session based on the provided token
    public static function authorize($token)
    {
        $conn = Database::getconnection(); // Get database connection
        $sql = "SELECT * FROM `userconn` WHERE `Token` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token); // Bind the token parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['Active'] == 1 && User::getagent() === $row['Agent'] && User::getip() === $row['Ip']) {
                if (!isset($_SESSION['Greeting'])) {
                    Session::set('Greeting', 'Welcome Back');
                }
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                Session::destroy();
                return false;
            }
        } else {
            $stmt->close();
            Session::destroy();
            return false;
        }
    }

    // Retrieves the username associated with the provided token
    public static function retrieveusername($token)
    {
        $conn = Database::getconnection(); // Get database connection
        $sql = "SELECT `Username` FROM `userconn` WHERE `Token` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token); // Bind the token parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            Session::set('username', $row['Username']);
            return $row['Username'];
        } else {
            $stmt->close();
            return null; // Return null or handle the case where no username is found
        }
    }

    // Retrieves the name associated with the provided username
    public static function retrievename($username)
    {
        $conn = Database::getconnection(); // Get database connection
        $sql = "SELECT `Name` FROM `userdb` WHERE `Username` = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); // Bind the username parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['Name'];
        } else {
            $stmt->close();
            return null; // Return null or handle the case where no name is found
        }
    }

    public static function newpassverify($oldpass, $newpass)
    {
        $conn = Database::getconnection();
        $username = $_SESSION['username'];

        // Fetch the user's current hashed password from the database
        $stmt = $conn->prepare("SELECT `Password` FROM `userdb` WHERE `Username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        // Verify the old password against the stored hashed password
        if (User::pass_verify($oldpass, $hashedPassword)) {
            // Hash the new password
            $newpass = User::hash_pass($newpass);

            // Update the user's password in the database
            $stmt = $conn->prepare("UPDATE `userdb` SET `Password` = ? WHERE `Username` = ?");
            $stmt->bind_param("ss", $newpass, $username);
            $stmt->execute();

            if ($stmt->affected_rows === 1) {
                Session::set('success', 'Password Changed Successfully');
                header("Location: ../change-password/");
                exit();
            } else {
                Session::set('error', 'Failed to change password');
                header("Location: ../change-password/");
                exit();
            }
        } else {
            Session::set('error', 'Invalid Old password');
            header("Location: ../change-password/");
            exit();
        }
    }
}
