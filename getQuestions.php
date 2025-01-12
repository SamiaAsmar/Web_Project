<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['ismember']) || $_SESSION['ismember'] != 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access"]);
    exit();
}

if (!isset($_SESSION['user_email'])) {
    echo json_encode(['success' => false, 'message' => 'User email not found in session.']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "Question_Post");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$response = [];

try {
    // جلب الأسئلة
    $query = "SELECT Q_Id, Text_Q, Time_Q, Email, question_type, options FROM Post_Q";
    $result = $conn->query($query);

    if ($result) {
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $question = [
                'id' => $row['Q_Id'],
                'text' => $row['Text_Q'],
                'time' => $row['Time_Q'],
                'email' => $row['Email'],
                'type' => $row['question_type'],
                'options' => isset($row['options']) && !empty($row['options']) ? json_decode($row['options'], true) : [],
                'answers' => []
            ];

            // جلب الإجابات
            $answerQuery = "SELECT Id, Answer, Time_A, file_path, Email, selected_options, Votes FROM Answer_Q WHERE question_id = ?";
            $stmt = $conn->prepare($answerQuery);
            $stmt->bind_param("i", $row['Q_Id']);
            $stmt->execute();
            $answerResult = $stmt->get_result();

            while ($answerRow = $answerResult->fetch_assoc()) {
                $answer = [
                    'id' => $answerRow['Id'],
                    'text' => $answerRow['Answer'],
                    'time' => $answerRow['Time_A'],
                    'filePath' => !empty($answerRow['file_path']) ? $answerRow['file_path'] : null,
                    'email' => !empty($answerRow['Email']) ? $answerRow['Email'] : 'Unknown',
                    'selectedOptions' => isset($answerRow['selected_options']) && !empty($answerRow['selected_options']) ? json_decode($answerRow['selected_options'], true) : [],
                    'Votes' => $answerRow['Votes']
                ];
                $question['answers'][] = $answer;
            }

            $questions[] = $question;
        }

        $response['success'] = true;
        $response['questions'] = $questions;
    } else {
        throw new Exception('Error fetching questions: ' . $conn->error);
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
} finally {
    $conn->close();
}

echo json_encode($response);
?>