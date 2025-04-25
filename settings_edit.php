<?php
require_once 'db_connection.php';


$siteName = '';
$iconePhoto = '';
$logoPhoto = '';
$facebookLink = '';
$instaLink = '';
$whatsappNum = ''; 
$carsualLines = '';
$carouselImages = ['', '', '']; 
$error = '';
$success = '';

$sql = "SELECT * FROM settings LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $siteName = htmlspecialchars($row['siteName'] ?? '', ENT_QUOTES, 'UTF-8');
    $iconePhoto = htmlspecialchars($row['iconePhoto'] ?? '', ENT_QUOTES, 'UTF-8');
    $logoPhoto = htmlspecialchars($row['logoPhoto'] ?? '', ENT_QUOTES, 'UTF-8');
    $facebookLink = htmlspecialchars($row['facebookLink'] ?? '', ENT_QUOTES, 'UTF-8');
    $instaLink = htmlspecialchars($row['instaLink'] ?? '', ENT_QUOTES, 'UTF-8');
    $whatsappNum = htmlspecialchars($row['watesapp'] ?? '', ENT_QUOTES, 'UTF-8'); 
    $carsualLines = htmlspecialchars($row['carsualLines'] ?? '', ENT_QUOTES, 'UTF-8');
    $carouselImages[0] = htmlspecialchars($row['carouselImage1'] ?? '', ENT_QUOTES, 'UTF-8');
    $carouselImages[1] = htmlspecialchars($row['carouselImage2'] ?? '', ENT_QUOTES, 'UTF-8');
    $carouselImages[2] = htmlspecialchars($row['carouselImage3'] ?? '', ENT_QUOTES, 'UTF-8');
}


if (isset($_POST['save_siteName'])) {
    $newSiteName = filter_var($_POST['siteName'], FILTER_SANITIZE_STRING);
    updateSetting('siteName', $newSiteName, $conn, $error, $success);
}

if (isset($_POST['upload_iconePhoto']) && isset($_FILES['new_iconePhoto']) && $_FILES['new_iconePhoto']['error'] === UPLOAD_ERR_OK) {
    handleFileUpload('new_iconePhoto', 'iconePhoto', 'images/icons/', $conn, $error, $success, $iconePhoto);
} elseif (isset($_POST['save_iconePhoto_url'])) {
    $newIconePhoto = filter_var($_POST['iconePhoto_url'], FILTER_SANITIZE_STRING);
    updateSetting('iconePhoto', $newIconePhoto, $conn, $error, $success, 'Favicon URL');
}

if (isset($_POST['upload_logoPhoto']) && isset($_FILES['new_logoPhoto']) && $_FILES['new_logoPhoto']['error'] === UPLOAD_ERR_OK) {
    handleFileUpload('new_logoPhoto', 'logoPhoto', 'images/logos/', $conn, $error, $success, $logoPhoto);
} elseif (isset($_POST['save_logoPhoto_url'])) {
    $newLogoPhoto = filter_var($_POST['logoPhoto_url'], FILTER_SANITIZE_STRING);
    updateSetting('logoPhoto', $newLogoPhoto, $conn, $error, $success, 'Logo URL');
}

if (isset($_POST['save_facebookLink'])) {
    $newFacebookLink = filter_var($_POST['facebookLink'], FILTER_SANITIZE_STRING);
    updateSetting('facebookLink', $newFacebookLink, $conn, $error, $success);
}

if (isset($_POST['save_instaLink'])) {
    $newInstaLink = filter_var($_POST['instaLink'], FILTER_SANITIZE_STRING);
    updateSetting('instaLink', $newInstaLink, $conn, $error, $success);
}

if (isset($_POST['save_whatsappNum'])) { 
    $newWhatsappNum = filter_var($_POST['whatsappNum'], FILTER_SANITIZE_STRING); 
    updateSetting('watesapp', $newWhatsappNum, $conn, $error, $success, 'WhatsApp Number');
}

if (isset($_POST['save_carsualLines'])) {
    $newCarsualLines = filter_var($_POST['carsualLines'], FILTER_SANITIZE_STRING);
    updateSetting('carsualLines', $newCarsualLines, $conn, $error, $success, 'Carousel Lines');
}


for ($i = 1; $i <= 3; $i++) {
    $imageField = "carouselImage" . $i;
    if (isset($_POST["upload_carouselImage{$i}"]) && isset($_FILES["new_carouselImage{$i}"]) && $_FILES["new_carouselImage{$i}"]['error'] === UPLOAD_ERR_OK) {
        handleFileUpload("new_carouselImage{$i}", $imageField, 'images/carousel/', $conn, $error, $success, $carouselImages[$i-1]);
    }  elseif (isset($_POST["save_carouselImage{$i}_url"])) {
        $newCarouselImageUrl = filter_var($_POST["carouselImage{$i}_url"], FILTER_SANITIZE_STRING);
        updateSetting($imageField, $newCarouselImageUrl, $conn, $error, $success, "Carousel Image {$i} URL");
    }
}

function updateSetting($fieldName, $newValue, $conn, &$error, &$success, $customSuccessName = null) {
    $checkSql = "SELECT COUNT(*) AS count FROM settings";
    $checkResult = $conn->query($checkSql);
    $rowCount = $checkResult->fetch_assoc()['count'];

     $successName = $customSuccessName ?? ucfirst(str_replace(['carsual', 'Link', 'Photo', 'whatsappNum'], ['', ' Link', ' Photo', ' WhatsApp Number'], $fieldName));


    if ($rowCount > 0) {
        $stmt = $conn->prepare("UPDATE settings SET $fieldName = ?");
    } else {
        $stmt = $conn->prepare("INSERT INTO settings ($fieldName) VALUES (?)");
    }
    $stmt->bind_param("s", $newValue);

    if ($stmt->execute()) {
        $success = $successName . " saved successfully!";
        header("Location: settings_edit.php");
        exit();
    } else {
        $error = "Error saving " . strtolower(str_replace(['carsual', 'Link', 'Photo', 'whatsappNum'], ['', ' link', ' photo', ' whatsapp number'], $fieldName)) . ": " . $stmt->error;
    }

    $stmt->close();
}

function handleFileUpload($fileInputName, $dbFieldName, $uploadDir, $conn, &$error, &$success, $oldFile = null) {
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid() . "_" . basename($_FILES[$fileInputName]['name']);
    $targetFilePath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $targetFilePath)) {
        $newFilePath = htmlspecialchars($targetFilePath, ENT_QUOTES, 'UTF-8');
        updateSetting($dbFieldName, $newFilePath, $conn, $error, $success, ucfirst(str_replace('Photo', ' Photo', $dbFieldName)));
         if ($oldFile && !strpos($oldFile, 'default')) {
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } else {
        $error = "Error uploading " . strtolower(str_replace('Photo', ' photo', $dbFieldName)) . ".";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Website Settings</title>
    <link rel="stylesheet" href="./css/admin.css">
    <link rel ="stylesheet" href ="./css/set_edit.css">
</head>
<body>
    <script src="admin.js"></script>
    <div class="container">
        <h1>Edit Website Settings</h1>
        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success-message"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <div class="form-group">
            <form method="post" action="settings_edit.php">
                <label for="siteName">Site Name:</label>
                <input type="text" id="siteName" name="siteName" value="<?php echo $siteName; ?>">
                <button type="submit" name="save_siteName">Save Site Name</button>
            </form>
        </div>

        <div class="form-group">
            <label for="iconePhoto">Favicon URL/Path:</label>
            <?php if (!empty($iconePhoto)): ?>
                <div class="image-preview">
                    <img src="<?php echo htmlspecialchars($iconePhoto, ENT_QUOTES, 'UTF-8'); ?>" alt="Favicon">
                </div>
            <?php endif; ?>
            <form method="post" action="settings_edit.php" enctype="multipart/form-data">
                <label for="new_iconePhoto">Upload New Favicon:</label>
                <input type="file" id="new_iconePhoto" name="new_iconePhoto" accept="image/*">
                <button type="submit" name="upload_iconePhoto">Upload Favicon</button>
            </form>
            <form method="post" action="settings_edit.php">
                <label for="iconePhoto_url">Or Enter Favicon URL:</label>
                <input type="text" id="iconePhoto_url" name="iconePhoto_url" value="<?php echo $iconePhoto; ?>">
                <button type="submit" name="save_iconePhoto_url">Save Favicon URL</button>
            </form>
            <small>You can upload a file or provide a direct URL for the favicon.</small>
        </div>

        <div class="form-group">
            <label for="logoPhoto">Logo URL/Path:</label>
            <?php if (!empty($logoPhoto)): ?>
                <div class="image-preview">
                    <img src="<?php echo htmlspecialchars($logoPhoto, ENT_QUOTES, 'UTF-8'); ?>" alt="Logo">
                </div>
            <?php endif; ?>
            <form method="post" action="settings_edit.php" enctype="multipart/form-data">
                <label for="new_logoPhoto">Upload New Logo:</label>
                <input type="file" id="new_logoPhoto" name="new_logoPhoto" accept="image/*">
                <button type="submit" name="upload_logoPhoto">Upload Logo</button>
            </form>
            <form method="post" action="settings_edit.php">
                 <label for="logoPhoto_url">Or Enter Logo URL:</label>
                <input type="text" id="logoPhoto_url" name="logoPhoto_url" value="<?php echo $logoPhoto; ?>">
                <button type="submit" name="save_logoPhoto_url">Save Logo URL</button>
            </form>
            <small>You can upload a file or provide a direct URL for the logo.</small>
        </div>

        <div class="form-group">
            <form method="post" action="settings_edit.php">
                <label for="facebookLink">Facebook Link:</label>
                <input type="text" id="facebookLink" name="facebookLink" value="<?php echo $facebookLink; ?>">
                <button type="submit" name="save_facebookLink">Save Facebook Link</button>
            </form>
        </div>

        <div class="form-group">
            <form method="post" action="settings_edit.php">
                <label for="instaLink">Instagram Link:</label>
                <input type="text" id="instaLink" name="instaLink" value="<?php echo $instaLink; ?>">
                <button type="submit" name="save_instaLink">Save Instagram Link</button>
            </form>
        </div>

        <div class="form-group">
            <form method="post" action="settings_edit.php">
                <label for="whatsappNum">WhatsApp Number:</label>
                <input type="text" id="whatsappNum" name="whatsappNum" value="<?php echo $whatsappNum; ?>">
                <button type="submit" name="save_whatsappNum">Save WhatsApp Number</button>
            </form>
        </div>

        <div class="form-group">
            <form method="post" action="settings_edit.php">
                <label for="carsualLines">Carousel Lines:</label>
                <textarea id="carsualLines" name="carsualLines" rows="3"><?php echo $carsualLines; ?></textarea>
                <small>Enter the lines of text you want to display on the carousel, separated by newlines.</small>
                <button type="submit" name="save_carsualLines">Save Carousel Lines</button>
            </form>
        </div>

        <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="form-group">
                <label for="carouselImage<?php echo $i; ?>">Carousel Image <?php echo $i; ?> URL/Path:</label>
                <?php if (!empty($carouselImages[$i - 1])): ?>
                    <div class="image-preview">
                        <img src="<?php echo htmlspecialchars($carouselImages[$i - 1], ENT_QUOTES, 'UTF-8'); ?>" alt="Carousel Image <?php echo $i; ?>">
                    </div>
                <?php endif; ?>
                <form method="post" action="settings_edit.php" enctype="multipart/form-data">
                    <label for="new_carouselImage<?php echo $i; ?>">Upload New Carousel Image <?php echo $i; ?>:</label>
                    <input type="file" id="new_carouselImage<?php echo $i; ?>" name="new_carouselImage<?php echo $i; ?>" accept="image/*">
                    <button type="submit" name="upload_carouselImage<?php echo $i; ?>">Upload Image <?php echo $i; ?></button>
                </form>
                 <form method="post" action="settings_edit.php">
                    <label for="carouselImage<?php echo $i; ?>_url">Or Enter Carousel Image <?php echo $i; ?> URL:</label>
                    <input type="text" id="carouselImage<?php echo $i; ?>_url" name="carouselImage<?php echo $i; ?>_url" value="<?php echo $carouselImages[$i - 1]; ?>">
                    <button type="submit" name="save_carouselImage<?php echo $i; ?>_url">Save Carousel Image <?php echo $i; ?> URL</button>
                </form>
            </div>
        <?php endfor; ?>
    </div>
</body>
</html>
