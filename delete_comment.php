<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['ismember']) || $_SESSION['ismember'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User email not found in session.']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "Borrow_Post");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['comment_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing comment ID.']);
    exit();
}

$commentId = $data['comment_id'];
$userEmail = $_SESSION['user_email'];

$stmt = $conn->prepare("SELECT Email FROM Comment_B WHERE Comment_Id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $commentId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($commentEmail);
$stmt->fetch();

if ($userEmail !== $commentEmail) {
    echo json_encode(['success' => false, 'message' => 'You are not authorized to delete this comment.']);
    exit();
}

$stmt = $conn->prepare("DELETE FROM Comment_B WHERE Comment_Id = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $commentId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Comment deleted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting comment: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>