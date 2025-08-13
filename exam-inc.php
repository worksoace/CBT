<?php
// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Check if the student has already submitted the exam
$query_check = "SELECT * FROM results WHERE student_id = '$student_id'";
$result_check = mysqli_query($conn, $query_check);

if (mysqli_num_rows($result_check) > 0) {
    // Set session message and redirect to the result page
    $_SESSION['message'] = "You have already completed the exam. You cannot retake it.";
    header("Location: result.php");
    exit();
}

// Set exam duration in seconds
$examDuration = 54000; // 1.5 hours

// Set exam start time if not already set
if (!isset($_SESSION['exam_start_time'])) {
    $_SESSION['exam_start_time'] = time(); // Current timestamp
}

// Calculate remaining time
$current_time = time();
$time_left = $_SESSION['exam_start_time'] + $examDuration - $current_time;

// If time is up, redirect to auto-submit
if ($time_left <= 0) {
    header("Location: auto_submit.php");
    exit();
}

// Fetch questions from the database
$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);
$questions = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $questions[] = $row;
    }
}

// Handle form submission (same as before)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['student_id'];
    $score = 0;

    foreach ($questions as $question) {
        $question_id = $question['id'];
        $correct_option = $question['correct_option'];
        $selected_option = isset($_POST['question_' . $question_id]) ? $_POST['question_' . $question_id] : null;

        // Save the student's answer
        $insertAnswer = "INSERT INTO student_answers (student_id, question_id, selected_option) 
                         VALUES ('$student_id', '$question_id', '$selected_option')";
        mysqli_query($conn, $insertAnswer);

        // Check if the answer is correct
        if ($selected_option === $correct_option) {
            $score++;
        }
    }

    // Save the result
    $total_questions = count($questions);
    $insertResult = "INSERT INTO results (student_id, score, total_questions) 
                     VALUES ('$student_id', '$score', '$total_questions')";
    mysqli_query($conn, $insertResult);

    // Redirect to the result page
    $_SESSION['score'] = $score;
    $_SESSION['total_questions'] = $total_questions;
    header("Location: result.php");
    exit();
}
?>