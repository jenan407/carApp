<?php
include 'db_connection.php';

if (isset($_GET['ad_id']) && isset($_GET['url'])) {
    $adId = $_GET['ad_id'];
    $redirectUrl = $_GET['url'];


    $adId = intval($adId);
    if ($adId <= 0) {
      
        header("Location: index5.php"); 
        exit;
    }

    $sql = "UPDATE ads SET hit = hit + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $adId);
        $stmt->execute();
        $stmt->close();
    }


    header("Location: " . $redirectUrl);
    exit;
} else {
   
    header("Location: index5.php");
    exit;
}
?>
