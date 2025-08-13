<?php
session_start();
include 'db.php';

// Admin authentication (hardcoded for simplicity)
$admin_username = "admin";
$admin_password = "admin123";

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['admin_logged_in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}

// If not logged in, show login form
if (!isset($_SESSION['admin_logged_in'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
<?php
    exit();
}

// Fetch questions
$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle question addition
if (isset($_POST['add_question'])) {
    $question_text = mysqli_real_escape_string($conn, $_POST['question_text']);
    $option_a = mysqli_real_escape_string($conn, $_POST['option_a']);
    $option_b = mysqli_real_escape_string($conn, $_POST['option_b']);
    $option_c = mysqli_real_escape_string($conn, $_POST['option_c']);
    $option_d = mysqli_real_escape_string($conn, $_POST['option_d']);
    $correct_option = mysqli_real_escape_string($conn, $_POST['correct_option']);

    $insertQuestion = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option) 
                       VALUES ('$question_text', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";
    mysqli_query($conn, $insertQuestion);
    header("Location: admin.php");
    exit();
}

// Handle question deletion
if (isset($_GET['delete_question'])) {
    $question_id = (int)$_GET['delete_question'];
    $deleteQuestion = "DELETE FROM questions WHERE id = $question_id";
    mysqli_query($conn, $deleteQuestion);
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>
</head>
<body>
    <h2>Admin Panel</h2>
    <a href="logout.php">Logout</a>

    <h3>Add Question</h3>
    <form method="POST">
        <label>Question:</label><br>
        <textarea name="question_text" placeholder="Use LaTeX for math questions" required></textarea><br><br>
        <label>Option A:</label><br>
        <input type="text" name="option_a" required><br><br>
        <label>Option B:</label><br>
        <input type="text" name="option_b" required><br><br>
        <label>Option C:</label><br>
        <input type="text" name="option_c" required><br><br>
        <label>Option D:</label><br>
        <input type="text" name="option_d" required><br><br>
        <label>Correct Option (A/B/C/D):</label><br>
        <input type="text" name="correct_option" maxlength="1" required><br><br>
        <button type="submit" name="add_question">Add Question</button>
    </form>

    <h3>Questions</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Options</th>
            <th>Correct Answer</th>
            <th>Action</th>
        </tr>
        <?php foreach ($questions as $question) { ?>
            <tr>
                <td><?php echo $question['id']; ?></td>
                <td><?php echo htmlspecialchars($question['question_text']); ?></td>
                <td>
                    A: <?php echo htmlspecialchars($question['option_a']); ?><br>
                    B: <?php echo htmlspecialchars($question['option_b']); ?><br>
                    C: <?php echo htmlspecialchars($question['option_c']); ?><br>
                    D: <?php echo htmlspecialchars($question['option_d']); ?>
                </td>
                <td><?php echo strtoupper($question['correct_option']); ?></td>
                <td>
                    <a href="?delete_question=<?php echo $question['id']; ?>" onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
