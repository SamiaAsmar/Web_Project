<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.txt');

header('Content-Type: application/json'); // تأكد من أن الاستجابة هي JSON

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
if (!isset($data['post_id']) || !is_numeric($data['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid Post ID']);
    exit();
}

$post_id = $data['post_id'];
$user_email = $_SESSION['user_email'];

$conn->begin_transaction();

try {
    $stmt = $conn->prepare("SELECT Email FROM Post_B WHERE Post_Id = ?");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($post_owner_email);
    $stmt->fetch();

    if ($user_email !== $post_owner_email) {
        throw new Exception('You are not authorized to delete this post.');
    }

    $stmt = $conn->prepare("DELETE FROM Comment_B WHERE Post_Id = ?");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param("i", $post_id);

    if (!$stmt->execute()) {
        throw new Exception('Failed to delete comments: ' . $stmt->error);
    }

    // حذف المنشور
    $stmt = $conn->prepare("DELETE FROM Post_B WHERE Post_Id = ?");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("i", $post_id);

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Post and associated comments deleted successfully.']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>