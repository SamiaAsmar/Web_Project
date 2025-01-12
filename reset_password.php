<?php
session_start();
$error_message = "";

if (!isset($_SESSION['reset_email'])) {
    header("location: forgot_password.php");
    exit();
}

if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $db = new mysqli("localhost", "root", "", "SignUp");
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $db->prepare("UPDATE User_Info SET Pass = ? WHERE Email = ?");
        $stmt->bind_param("ss", $hashed_password, $_SESSION['reset_email']);
        $stmt->execute();

        session_unset();
        session_destroy();
        header("location: slideLogin.php?password_reset=success");
        exit();
    } else {
        $error_message = "Passwords do not match.";
    }
}
?>