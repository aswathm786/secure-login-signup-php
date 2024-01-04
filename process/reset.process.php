<?
require_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $conn = Database::getconnection();
    $password = $_POST['newPassword'];
    $password = User::hash_pass($password);
    $username = $_POST['username'];

    $sql = "UPDATE `userdb` SET `Password` = ?, `resettoken` = NULL, `resettoken_expiry` = NULL
        WHERE `Username` = ? COLLATE utf8mb4_bin";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $password, $username);
        $stmt->execute();
        $stmt->close();
        Session::set('success', 'Password changed successfully');
        header("Location: ../app/login.php");
        exit();
    } else {
        Session::set('token_invalid', 1);
        header("Location: ./");
        exit();
    }
} else {
    header("Location: /");
    exit();
}
