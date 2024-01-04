<?

// Include necessary files
require_once __DIR__ . '/../config/config.php';
if (isset($_SESSION['login'])) {

    // Get database connection
    $conn = Database::getconnection();

    // Call the logout function from the Session class to log the user out
    Session::logout($conn);
} else {
    header("Location: /");
    exit();
}
