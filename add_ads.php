<?php

require_once 'db_connection.php';


$fullName = $adUrl = $startDate = $endDate = $location = '';
$fullNameErr = $imageErr = $adUrlErr = $startDateErr = $endDateErr = $locationErr = '';
$successMessage = '';
$errorMessage = '';


$validLocations = ['top', 'middle', 'bottom'];


$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    if (empty($_POST['full_name'])) {
        $fullNameErr = 'Please enter the ad name.';
    } else {
        $fullName = trim($_POST['full_name']);
    }

    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['image']['tmp_name']);
        finfo_close($fileInfo);

        if (!in_array($mimeType, $allowedTypes)) {
            $imageErr = 'Invalid image format. Only JPG, PNG, and GIF are allowed.';
        } elseif ($_FILES['image']['size'] > $maxFileSize) {
            $imageErr = 'Image size exceeds the maximum limit of 2MB.';
        }
    } else {
        $imageErr = 'Please upload an image.';
    }

    
    if (empty($_POST['ad_url'])) {
        $adUrlErr = 'Please enter the ad URL.';
    } elseif (!filter_var($_POST['ad_url'], FILTER_VALIDATE_URL)) {
        $adUrlErr = 'Please enter a valid URL.';
    } else {
        $adUrl = trim($_POST['ad_url']);
    }

    
    if (empty($_POST['start_date'])) {
        $startDateErr = 'Please enter the start date.';
    } else {
        $startDate = trim($_POST['start_date']);
    }

   
    if (empty($_POST['end_date'])) {
        $endDateErr = 'Please enter the end date.';
    } else {
        $endDate = trim($_POST['end_date']);
    }

  
    if (empty($_POST['location'])) {
        $locationErr = 'Please select the ad location.';
    } elseif (!in_array($_POST['location'], $validLocations)) {
        $locationErr = 'Please select a valid ad location.';
    } else {
        $location = $_POST['location'];
    }

    if (empty($fullNameErr) && empty($imageErr) && empty($adUrlErr) && empty($startDateErr) && empty($endDateErr) && empty($locationErr)) {
        $uploadDir = 'images/'; 
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); 
        }

        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $sql = "INSERT INTO ads ( `full_name`, `image`, `ad-url`, `start-date`, `end-date`, `location`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $fullName, $imageName, $adUrl, $startDate, $endDate, $location);

            if ($stmt->execute()) {
                $successMessage = 'Ad added successfully!';
              
                $fullName = $adUrl = $startDate = $endDate = $location = '';
            } else {
                $errorMessage = 'Error adding ad to database: ' . $stmt->error;
              
                unlink($targetFilePath);
            }

            $stmt->close();
        } else {
            $errorMessage = 'Error uploading image.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarZone - Add New Ad</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Advertisement</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form method="POST" action="add_ads.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="full_name">Ad Name:</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required value="<?php echo htmlspecialchars($fullName); ?>">
                <span class="text-danger"><?php echo $fullNameErr; ?></span>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image"  required>
                <small class="form-text text-muted">Upload an image file (JPG, PNG, GIF, max 2MB).</small>
                <span class="text-danger"><?php echo $imageErr; ?></span>
            </div>

            <div class="form-group">
                <label for="ad_url">Ad URL:</label>
                <input type="url" class="form-control" id="ad_url" name="ad_url" required value="<?php echo htmlspecialchars($adUrl); ?>">
                <span class="text-danger"><?php echo $adUrlErr; ?></span>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required value="<?php echo htmlspecialchars($startDate); ?>">
                <span class="text-danger"><?php echo $startDateErr; ?></span>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required value="<?php echo htmlspecialchars($endDate); ?>">
                <span class="text-danger"><?php echo $endDateErr; ?></span>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <select class="form-control" id="location" name="location" required >
                    <option >Select Location</option>
                    <?php foreach ($validLocations as $loc): ?>
                        <option  value="<?php echo htmlspecialchars($loc); ?>" <?php if ($location == $loc) echo 'selected'; ?>><?php echo htmlspecialchars(ucfirst($loc)); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="text-danger"><?php echo $locationErr; ?></span>
            </div>

            <button type="submit" class="btn btn-primary">Add Ad</button>
            <a href="home.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>