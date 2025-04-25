<?php
session_start();
include 'db_connection.php'; 


$error = "";


if (isset($_POST['signin'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $sql = "SELECT id, name, password, role FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
  
    $stmt->bind_param("s", $email);
 
    $stmt->execute();

    $result = $stmt->get_result();

   
    if ($result->num_rows == 1) {
       
        $user = $result->fetch_assoc();
      
        if (password_verify($password, $user['password'])) {
        
            $_SESSION['user_id'] = $user['id'];
         
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] == 'admine'){
                header("Location: admin.php");
            } else {
                header("Location: profile.php");
            }
           
            exit();
        } else {
            
            $error = "Invalid email or password.";
        }
    } else {
       
        $error = "Invalid email or password.";
    }


    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="./css/signin.css">
    <style>
        body {
            background-color: #708090 !important;
        }
    </style>
</head>

<body>
    <div class="signin-container">
        <div class="signin-form">
            <h1>Sign In</h1>
            <?php if ($error) : ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="signin.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="signin" class="btn-primary">Sign In</button>
                <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</body>

</html>
