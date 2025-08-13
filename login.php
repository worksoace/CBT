<!-- PHP Script -->

<div class="php">
    <?php
    session_start();
    ?>
</div>

<!-- Html Template -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="login-body-container">
        <h2>User Login</h2>

        <div class="login-form-container">
            <form method="POST" action="login-inc.php">
                <input type="username" id="username" name="username" placeholder="User name" required>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="error"><?php echo $_SESSION['error'];
                                        unset($_SESSION['error']); ?></div>
                <?php } ?>
            </form>
        </div>
    </div>
</body>

</html>