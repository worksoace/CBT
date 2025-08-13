<?php
session_start();
include 'db.php';
include 'exam-inc.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link rel="stylesheet" href="styles.css">
    <!-- math script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Timer -->
    <script>
        let timeLeft = <?php echo $time_left; ?>; // Remaining time in seconds

        function startTimer() {
            const timerDisplay = document.getElementById('timer');
            const form = document.getElementById('examForm');

            const timer = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    alert("Time is up! Your answers will now be submitted.");
                    form.submit();
                    return;
                }

                let hours = Math.floor(timeLeft / 3600);
                let minutes = Math.floor((timeLeft % 3600) / 60);
                let seconds = timeLeft % 60;

                // Format hours, minutes, and seconds
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                // Update timer display
                timerDisplay.textContent = `Time Left: ${hours}:${minutes}:${seconds}`;

                timeLeft--;
            }, 1000); // Update every second
        }

        window.onload = startTimer;
    </script>
</head>

<body>
    <div class="exam-container">
        <div class="header">
            <div class="welcome">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h2>
            </div>
            <div id="timer" class="timer"> Time Left: 00:00:00</div>
        </div>

        <!-- Display session message if exists -->
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>

        <div class="question-container">
            <h3>Answer the following questions:</h3>
            <form id="examForm" method="POST">
                <?php foreach ($questions as $question): ?>
                    <div class="question">
                        <p class="mathjax"><?php echo htmlspecialchars($question['question_text']); ?></p>
                        <div class="options">
                            <label>
                                <input type="radio" name="question_<?php echo $question['id']; ?>" value="A">
                                A. <?php echo htmlspecialchars($question['option_a']); ?>
                            </label>
                            <label>
                                <input type="radio" name="question_<?php echo $question['id']; ?>" value="B">
                                B. <?php echo htmlspecialchars($question['option_b']); ?>
                            </label>
                            <label>
                                <input type="radio" name="question_<?php echo $question['id']; ?>" value="C">
                                C. <?php echo htmlspecialchars($question['option_c']); ?>
                            </label>
                            <label>
                                <input type="radio" name="question_<?php echo $question['id']; ?>" value="D">
                                D. <?php echo htmlspecialchars($question['option_d']); ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" onclick="return sure()">Submit Exam</button>
            </form>
        </div>
    </div>
</body>

<script>
    function sure() {
        return confirm("Are you sure you would like to submit? ")
    }
    
</script>

</html>