<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <div class="info-container">
        <div class="info-box">
            <h1>Information</h1>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <p><a href="signup.php">Back to Sign Up</a></p>
            <p><a href="signin.php">Go to Sign In</a></p>
        </div>
    </div>
</body>
</html>