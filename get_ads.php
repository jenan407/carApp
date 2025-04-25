<?php

require_once 'db_connection.php';

$currentDateSydney = new DateTime('now', new DateTimeZone('Australia/Sydney'));
$currentDateFormatted = $currentDateSydney->format('Y-m-d');

$sqlAds = "SELECT `full-name`, image, `ad-url`, location AS placement FROM ads
           ORDER BY location, RAND()"; 

$resultAds = $conn->query($sqlAds);

if ($resultAds === false) {
   
    error_log("Error executing SQL query: " . $conn->error);
   
    $adsByPlacement = array();
}

$adsByPlacement = array();
while ($row = $resultAds->fetch_assoc()) {
    $placement = $row['placement'];
    if (!isset($adsByPlacement[$placement])) {
        $adsByPlacement[$placement] = array();
    }
    $adsByPlacement[$placement][] = $row;
}

header('Content-Type: application/json');
echo json_encode($adsByPlacement);


?>