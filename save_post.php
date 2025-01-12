<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['ismember']) || $_SESSION['ismember'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if (!isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User email not found in session.']);
    exit();
}

$content = htmlspecialchars(trim($_POST['post-text'] ?? ''), ENT_QUOTES, 'UTF-8');
$user_email = $_SESSION['user_email'];

if (!$content) {
    echo json_encode(['success' => false, 'message' => 'Missing required data.']);
    exit();
}

$image_path = null;
if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] == 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    $file_type = $_FILES['file-upload']['type'];
    $file_size = $_FILES['file-upload']['size'];

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']);
        exit();
    }

    if ($file_size > $max_size) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds the maximum allowed size of 5MB.']);
        exit();
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . uniqid() . '_' . basename($_FILES["file-upload"]["name"]);

    if (move_uploaded_file($_FILES["file-upload"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
        exit();
    }
}

try {
    $conn = new mysqli("localhost", "root", "", "Borrow_Post");

    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO Post_B (Text_Content, image_Path, Email) VALUES (?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("sss", $content, $image_path, $user_email);

    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    $post_id = $stmt->insert_id;
    echo json_encode(['success' => true, 'message' => 'Post saved successfully.', 'post_id' => $post_id]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>