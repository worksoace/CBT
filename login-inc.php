<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM students WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $student = mysqli_fetch_assoc($result);

        if ($password === $student['password']) {

            // Check if the student has already written the exam
            $examCheckQuery = "SELECT * FROM results WHERE student_id = '{$student['id']}'";
            $examCheckResult = mysqli_query($conn, $examCheckQuery);

            if (mysqli_num_rows($examCheckResult) > 0) {
                $_SESSION['error'] = "oops You have already written the exam!, contact the admin if you have any issues.";
                header("Location: login.php");
                exit();
            }

            //set Session variables
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['student_name'];

            header("Location: exam.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password!";
            header("Location: login.php");
            exit();
        }
    } else {

        $_SESSION['error'] = "Invalid username or password!";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
