<?php
require_once __DIR__ . '/../config/config.php';

class Session
{
    // Insert user session data into the database
    public static function insert($username, $token, $conn)
    {
        $sql = "INSERT INTO `userconn` (`Username`, `Session`) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $conn->close();
            $_SESSION['username'] = $username;
            return true;
        } else {
            return false;
        }
    }

    // Verify user session data from the database
    public static function verify($username, $token, $conn)
    {
        $sql = "SELECT * FROM `userconn` WHERE `Username` = ? LIMIT 50";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['Session'] == $token) {
                    $stmt->close();
                    return true;
                }
            }
        }

        $stmt->close();
        return false;
    }

    // Set session data
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Set a cookie
    public static function setcookie($key, $value)
    {
        setcookie($key, $value, time() + (7 * 24 * 60 * 60), '/');
    }

    // Unset a specific cookie
    public static function unsetCookie($key)
    {
        if (isset($_COOKIE[$key])) {
            setcookie($key, '', time() - 3600, '/');
            unset($_COOKIE[$key]);
            return true;
        } else {
            return false;
        }
    }

    // Unset session data
    public static function unset($key)
    {
        unset($_SESSION[$key]);
    }

    // Destroy the session
    public static function destroy()
    {
        Session::unsetCookie('Token');
        $_SESSION = array();
        session_destroy();
        header("Location: ../app/");
        exit();
    }

    // Logout the user
    public static function logout()
    {
        if (isset($_COOKIE['Token'])) {
            $token = $_COOKIE['Token'];
            Session::unsetCookie('Token');
        } else {
            $token = $_SESSION['Token'];
        }

        $_SESSION = array();
        session_destroy();

        if (!empty($token)) {
            $conn = Database::getconnection();
            $sql = "UPDATE `userconn` SET `Active` = '0' WHERE `Token` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $token);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $stmt->close();
                $conn->close();
                header("Location: ../");
                exit();
            }
        }
    }
}
