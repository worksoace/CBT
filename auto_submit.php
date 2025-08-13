<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$score = 0;

$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($questions as $question) {
    $question_id = $question['id'];
    $correct_option = $question['correct_option'];
    $selected_option = $_POST['question_' . $question_id] ?? null;

    $insertAnswer = "INSERT INTO student_answers (student_id, question_id, selected_option) 
                     VALUES ('$student_id', '$question_id', '$selected_option')";
    mysqli_query($conn, $insertAnswer);

    if ($selected_option === $correct_option) {
        $score++;
    }
}

$total_questions = count($questions);
$current_time = date('Y-m-d H:i:s');

$insertResult = "INSERT INTO results (student_id, score, total_questions, timestamp) 
                 VALUES ('$student_id', '$score', '$total_questions', '$current_time')
                 ON DUPLICATE KEY UPDATE 
                 score = '$score', 
                 total_questions = '$total_questions',
                 timestamp = '$current_time'";
mysqli_query($conn, $insertResult);

$_SESSION['score'] = $score;
$_SESSION['total_questions'] = $total_questions;

header("Location: result.php");
exit();
?>
