<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
require_once 'db_connection.php';

    $user_id = $_POST['user_id'];
    $brand = $conn->real_escape_string($_POST['brand']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = intval($_POST['year']);
    $price = floatval($_POST['price']);
    $color = $conn->real_escape_string($_POST['color']);
    $country = $conn->real_escape_string($_POST['country']);
    $city = $conn->real_escape_string($_POST['city']);
    $description = $conn->real_escape_string($_POST['description']);
    $sold = intval($_POST['sold']);

  
    $uploadDir = "images/";
    $imagePaths = [];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 4 * 1024 * 1024; // 2MB

    if (!empty($_FILES['images']['name'][0])) {
        $fileCount = count($_FILES['images']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                if (in_array($_FILES['images']['type'][$i], $allowedTypes) && $_FILES['images']['size'][$i] <= $maxFileSize) {
                    $filename = uniqid() . "_" . $conn->real_escape_string(basename($_FILES['images']['name'][$i]));
                    $targetFilePath = $uploadDir . $filename;
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $targetFilePath)) {
                        $imagePaths[] = $targetFilePath;
                    } else {
                        $_SESSION['add_car_error'] = "Error uploading one or more images.";
                        header("Location: addcar.php");
                        $conn->close();
                        exit();
                    }
                } else {
                    $_SESSION['add_car_error'] = "Invalid file type or size for one or more images.";
                    header("Location: addcar.php");
                    $conn->close();
                    exit();
                }
            } elseif ($_FILES['images']['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                $_SESSION['add_car_error'] = "Error during image upload.";
                header("Location: addcar.php");
                $conn->close();
                exit();
            }
        }
    }

    $imagesJson = json_encode($imagePaths);

    $sql = "INSERT INTO cars (user_id, brand, model, year, price, images, description, sold, color, country, city)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issiississs", $user_id, $brand, $model, $year, $price, $imagesJson, $description, $sold, $color, $country, $city);

    if ($stmt->execute()) {
        header("Location: profile.php?message=car_added"); 
    } else {
        $_SESSION['add_car_error'] = "Error adding car listing: " . $conn->error;
        header("Location: addcar.php");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: addcar.php"); 
    exit();
}
?>
