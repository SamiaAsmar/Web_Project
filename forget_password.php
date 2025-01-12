<?php
session_start();
header('Content-Type: application/json'); 

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    $db = new mysqli("localhost", "root", "", "SignUp");
    if ($db->connect_error) {
        die(json_encode(["status" => "error", "message" => "Connection failed: " . $db->connect_error]));
    }

    $stmt = $db->prepare("SELECT * FROM User_Info WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['reset_email'] = $email; 
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email not found. Please check your email address."]);
    }

    $stmt->close();
    $db->close();
    exit();
}
?>