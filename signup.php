<?php
session_start();
require_once 'db_connection.php';

$error = "";
$success = ""; 

if (isset($_POST['signup'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $mobileno = filter_var($_POST['mobileno'], FILTER_SANITIZE_STRING);
    $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
    $country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    
    $profilePicturePath = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "images/";
        $filename = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $targetFilePath = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFilePath)) {
            $profilePicturePath = htmlspecialchars($targetFilePath, ENT_QUOTES, 'UTF-8');
        } else {
            $error .= "Error uploading profile picture. ";
        }
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "Invalid email format. ";
    } elseif (empty($password) || strlen($password) < 6) {
        $error .= "Password must be at least 6 characters long. ";
    }
    
    if (empty($error)) {
       
        $stmtCheck = $conn->prepare("SELECT email FROM user WHERE email = ?");
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        if ($resultCheck->num_rows > 0) {
            $error = "Email address already registered.";
        } else {
     
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          
            $stmtInsert = $conn->prepare("INSERT INTO user (name, email, password, mobileno, `profile-picture`, city, country) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtInsert->bind_param("sssssss", $name, $email, $hashedPassword, $mobileno, $profilePicturePath, $city, $country);
            
            if ($stmtInsert->execute()) {
                $_SESSION['success'] = "Registration successful!";
                header("Location: registration_success.php");
                exit();
            } else {
                error_log("Database Error: " . $conn->error, 0);
                $error = "Error during registration. Please try again.";
            }
            $stmtInsert->close();
        }
        $stmtCheck->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/signin.css">
    <script src="./js/sn.js"></script>
    <style>
        body {
            background-color: #708090 !important;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-form">
            <h1>Sign Up</h1>
            <?php if ($error): ?>
                <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <p class="success-message"><?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['success']); ?></p>
            <?php endif; ?>
            <form action="signup.php" method="post" enctype="multipart/form-data" id="signupForm">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <small class="form-text">Must be at least 6 characters.</small>
                </div>
                <div class="form-group">
                    <label for="mobileno">Mobile Number:</label>
                    <input type="text" id="mobileno" name="mobileno" value="<?php echo isset($_POST['mobileno']) ? htmlspecialchars($_POST['mobileno'], ENT_QUOTES, 'UTF-8') : ''; ?>"required>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    <small class="form-text">Optional</small>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8') : ''; ?>"required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8') : ''; ?>"required>
                </div>
                <button type="submit" name="signup" class="btn-primary">Sign Up</button>
                <p class="signin-link">Already have an account? <a href="signin.php">Sign In</a></p>
            </form>
        </div>
    </div>
</body>
</html>
