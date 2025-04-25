<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php"); 
    exit();
}

include 'db_connection.php';
$user_id = $_SESSION['user_id'];


$sqlUser = "SELECT id, name, email, `profile-picture`, city, country FROM user WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$stmtUser->close();


$sqlCars = "SELECT id, brand, model, year, price, images FROM cars WHERE user_id = ?";
$stmtCars = $conn->prepare($sqlCars);
$stmtCars->bind_param("i", $user_id);
$stmtCars->execute();
$resultCars = $stmtCars->get_result();
$cars = $resultCars->fetch_all(MYSQLI_ASSOC);
$stmtCars->close();

$conn->close();

$passwordChangeMessage = "";
if (isset($_SESSION['password_change_message'])) {
    $passwordChangeMessage = $_SESSION['password_change_message'];
    unset($_SESSION['password_change_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarZone - Home</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel = "website icon " type ="png" href ="images/icon.jpg">
    <link rel="stylesheet" href="./css/addcoms.css"> 

    <link rel ="stylesheet" href ="./css/profile.css">
   

</head>
<body>
<nav>
        <h1 data-lang="CarZone">CarZone</h1>
        <ul>
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <?php if ($user['profile-picture']): ?>
                    <img src="<?php echo htmlspecialchars($user['profile-picture']); ?>" alt="Profile Picture" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;">
                <?php else: ?>
                    <img src="images/default_profile.png" alt="Default Profile Picture" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;"> <?php endif; ?>
                </a>
             
            </li>
            <li><a href="addcar.php"data-lang="AddListing">Add Car</a></li>
            <li><a href="home.php"data-lang="logout"></a></li>
            <li>
                <span data-lang="selectLanguage">Select a language</span>
                <select id="languageSelector" class="p-1 mt-2">
                    <option value="en" data-lang="english" selected >English</option>
                    <option value="ar"data-lang="arabic">Arabic</option>
                </select>
            </li>
        </ul>
    </nav>
</nav>


</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-picture">
                <?php if ($user['profile-picture']): ?>
                    <img src="<?php echo htmlspecialchars($user['profile-picture']); ?>" alt="<?php echo htmlspecialchars($user['name']); ?>'s Profile Picture">
                <?php else: ?>
                    <img src="images/default_profile.png" alt="Default Profile Picture"> <?php endif; ?>
            </div>
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
        </div>

        <div class="profile-info">
            <p data-lang="Email"><strong>Email:</strong></p> <?php echo htmlspecialchars($user['email']); ?>
            <?php if ($user['city']): ?>
                <p data-lang="City"><strong>City:</strong> </p><?php echo htmlspecialchars($user['city']); ?>
            <?php endif; ?>
            <?php if ($user['country']): ?>
                <p data-lang="Country"><strong>Country:</strong></p> <?php echo htmlspecialchars($user['country']); ?>
            <?php endif; ?>
        </div>

        <div class="owned-cars">
            <h2 data-lang="yourcars">Your Cars</h2>
            <?php if (!empty($cars)): ?>
                <div class="car-list">
                    <?php foreach ($cars as $car): ?>
                        <div class="car-card">
                            <div class="car-image-container">
                                <?php
                                $images = json_decode($car['images'], true);
                                if (!empty($images) && isset($images[0])) {
                                    echo '<img src="' . htmlspecialchars($images[0]) . '" alt="' . htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) . '">';
                                } else {
                                    echo '<img src="default_car.png" alt="No Image">';
                                }
                                ?>
                            </div>
                            <div class="car-details">
                                <h3><?php echo htmlspecialchars($car['brand']); ?> <?php echo htmlspecialchars($car['model']); ?></h3>
                                <p data-lang="Year">Year: </p><?php echo htmlspecialchars($car['year']); ?>
                                <p data-lang="Price">Price: $</p><?php echo number_format($car['price'], 2); ?>
                               
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-cars" data-lang="no_cars">You haven't listed any cars yet.</p>
            <?php endif; ?>
        </div>

        <div class="change-password-section">
            <h3 data-lang="ChangePassword">Change Password</h3>
            <?php if ($passwordChangeMessage): ?>
                <p class="password-change-message <?php echo (strpos($passwordChangeMessage, 'Error') === 0) ? 'password-change-error' : 'password-change-success'; ?>">
                    <?php echo $passwordChangeMessage; ?>
                </p>
            <?php endif; ?>
            <form action="changePass.php" method="post" class="change-password-form">
                <div class="form-group">
                    <label for="current_password" data-lang="CurrentPassword">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password" data-lang="NewPassword">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_new_password" data-lang="ConfirmNewPassword">Confirm New Password:</label>
                    <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                </div>
                <button type="submit"data-lang="ChangePassword">Change Password</button>
            </form>
        </div>
<p>   </p>
        <p><a href="addcar.php" class="btn btn-outline-info" data-lang ="AddListing">Add Car</a></p>
        <p><a href="logout.php" class="btn btn-outline-info" data-lang ="logout" >LogOut</a></p?>
    </div>
    <script src="./js/script.js" type="module"></script>
</body>
</html>