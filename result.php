<!-- PHP header Script -->
<div class="php">
    <?php
    session_start();

    // Check if student is logged in and score is set
    if (!isset($_SESSION['student_id']) || !isset($_SESSION['score'])) {
        header("Location: login.php");
        exit();
    }

    $score = $_SESSION['score'];
    $total_questions = $_SESSION['total_questions'];

    // Clear the score session variables
    unset($_SESSION['score'], $_SESSION['total_questions']);
    ?>
</div>


<!-- Html Template -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <h2>Exam Completed</h2>
    <p>Thank you for taking the exam, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</p>
    <p>Your Score: <strong><?php echo $score; ?></strong> out of <strong><?php echo $total_questions; ?></strong></p>
    <a href="logout.php">Logout</a>
</body>

</html>