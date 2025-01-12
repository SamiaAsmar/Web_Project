<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

if (!isset($_SESSION['ismember']) || $_SESSION['ismember'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if (!isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User email not found in session']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "Question_Post");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$response = [];

try {
    // التحقق من البيانات المرسلة عبر POST
    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['questionId']) || !isset($data['answerId']) || !isset($data['userEmail'])) {
        throw new Exception('Missing required data.');
    }

    $questionId = $data['questionId'];
    $answerId = $data['answerId'];
    $userEmail = $data['userEmail'];

    // زيادة عدد الأصوات للإجابة المحددة
    $stmt = $conn->prepare("UPDATE Answer_Q SET votes = votes + 1 WHERE Id = ? AND question_id = ?");
    $stmt->bind_param("ii", $answerId, $questionId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Vote added successfully.';
    } else {
        throw new Exception('Error updating votes: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
} finally {
    $conn->close();
}

echo json_encode($response);
exit();
?>