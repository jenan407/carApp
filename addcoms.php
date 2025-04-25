<?php

require_once 'db_connection.php';

session_start();


$name = $phone = $content = $type = $car_id = '';
$errors = [];
$successMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $content = trim($_POST['content']);
    $type = trim($_POST['type']);
    $car_id = isset($_POST['car_id']) ? filter_var($_POST['car_id'], FILTER_VALIDATE_INT) : null;

    if (empty($name)) {
        $errors['name'] = 'Your name is required.';
    }
    if (empty($content)) {
        $errors['content'] = 'Please enter your comment.';
    }
    if (!in_array($type, ['seller', 'site'])) {
        $errors['type'] = 'Invalid comment type.';
    }
    if ($type === 'seller' && (empty($car_id) || $car_id <= 0)) {
        $errors['car_id'] = 'Please select a car you are commenting about.';
    } elseif ($type === 'site') {
        $car_id = null; 
    }

   
    if (empty($errors)) {
        $is_public = 0; 
        $status = 'Pending'; 

        $stmt = $conn->prepare("INSERT INTO comments (name, phone, content, is_public, status, created_at, type, user_nsme, car_id) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?)");
        $stmt->bind_param("sssissi", $name, $phone, $content, $is_public, $status, $type, $_SESSION['username'] ?? null, $car_id); 

        if ($stmt->execute()) {
            $successMessage = 'Your comment has been submitted and is awaiting admin approval.';
         
            $name = $phone = $content = $type = '';
            $car_id = null;
        } else {
            $errors['database'] = 'There was an error submitting your comment. Please try again later.';
          
        }

        $stmt->close();
    }
}


$carIdFromUrl = isset($_GET['car_id']) ? filter_var($_GET['car_id'], FILTER_VALIDATE_INT) : null;
$typeFromUrl = isset($_GET['type']) ? trim($_GET['type']) : null;

if ($typeFromUrl === 'site') {
    $type = 'site';
} elseif ($carIdFromUrl > 0) {
    $type = 'seller';
    $car_id = $carIdFromUrl;
}
?>

<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Comment</title>
   
    <link rel="stylesheet" href="./css/addcoms.css"> 
    <link rel = "website icon " type ="png" href ="images/icon.jpg">


</head>

<body>
<nav>
        <h1 data-lang="CarZone">CarZone</h1>
        <ul>
            <li><a href="home.php"data-lang="Home">Home</a></li>
            <li><a href="signup.php"data-lang="Listings">SignUp</a></li>
            <li><a href="signin.php"data-lang="SignIN">SignIn</a></li>
            <li>
                <span data-lang="selectLanguage">Select a language</span>
                <select id="languageSelector" class="p-1 mt-2">
                    <option value="en" data-lang="english" selected >English</option>
                    <option value="ar"data-lang="arabic">Arabic</option>
                </select>
            </li>
        </ul>
    </nav>

            </h5>
        </ul>
    </div>
</nav>
    <div class="container mt-5">
        <h2 data-lang="LeaveaComment">Leave a Comment</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="name"data-lang="YourName">Your Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="error"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone"data-lang="YourPhone">Your Phone (Optional):</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <?php if (isset($errors['phone'])): ?>
                    <div class="error"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="type"data-lang="CommentAbout">Comment About:</label>
                <select class="form-control" id="type" name="type">
                    <option value=""data-lang="Select">Select...</option>
                    <option value="seller" data-lang="seller"<?php if ($type === 'seller') echo 'selected'; ?>>A Seller/Car Listing</option>
                    <option value="site" data-lang="site" <?php if ($type === 'site') echo 'selected'; ?>>The Website/General Feedback</option>
                </select>
                <?php if (isset($errors['type'])): ?>
                    <div class="error"><?php echo $errors['type']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group" id="carIdGroup" style="<?php echo ($type !== 'seller') ? 'display: none;' : ''; ?>">
                <label for="car_id"data-lang="SelectCarListing:">Select Car Listing:</label>
                <select class="form-control" id="car_id" name="car_id">
                    <option value=""data-lang="SelectaCar...">Select a Car...</option>
                    <?php
                 
                    $sqlCars = "SELECT id, brand, model FROM cars";
                    $resultCars = $conn->query($sqlCars);
                    if ($resultCars->num_rows > 0) {
                        while ($car = $resultCars->fetch_assoc()) {
                            $selected = ($car_id === $car['id']) ? 'selected' : '';
                            echo '<option value="' . $car['id'] . '" ' . $selected . '>' . htmlspecialchars($car['brand'] . ' ' . $car['model']) . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>No car listings available</option>';
                    }
                    ?>
                </select>
                <?php if (isset($errors['car_id'])): ?>
                    <div class="error"><?php echo $errors['car_id']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="content"data-lang="YourComment">Your Comment:</label>
                <textarea class="form-control" id="content" name="content" rows="5"><?php echo htmlspecialchars($content); ?></textarea>
                <?php if (isset($errors['content'])): ?>
                    <div class="error"><?php echo $errors['content'] ?></div>
                <?php endif; ?>
            </div>

            <?php if (isset($errors['database'])): ?>
                <div class="error"><?php echo $errors['database']; ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary custom-submit-button"data-lang="SubmitComment">Submit Comment</button> </form>
        </form>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const carIdGroup = document.getElementById('carIdGroup');

       
        if (typeSelect.value === 'seller') {
            carIdGroup.style.display = 'block';
        }

        typeSelect.addEventListener('change', function() {
            if (this.value === 'seller') {
                carIdGroup.style.display = 'block';
            } else {
                carIdGroup.style.display = 'none';
              
                document.getElementById('car_id').value = '';
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/script.js" type="module"></script>
</body>
</html>