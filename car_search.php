<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarZone - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/all_cars.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel = "website icon " type ="png" href ="images/icon.jpg">
    <style>
    
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f8;
        color: #333;
        margin: 0;
        padding: 0;
        text-align: center;
    }
    nav {
        background-color: #708090;
        color: balck;
        padding: 30px 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    nav h1 {
        margin: 0;
        font-size: 24px;
    }
    
    nav ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }
    
    nav ul li {
        margin-left: 20px;
    }
    
    nav ul li a {
        color: black;
        text-decoration: none;
        font-size: 16px;
    }
    
    nav ul li a:hover {
        color: black;
    } 
    </style>
  
    

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
<script src="./js/script.js" type="module"></script>
</body>
</html>
<?php

include 'db_connection.php';


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';


$sql = "SELECT id, brand, model, year, price, images FROM cars WHERE brand LIKE ? OR model LIKE ?";
$stmt = $conn->prepare($sql);

    
if ($stmt) {
   
    $searchTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
       
        echo '<div class="container mt-4">';
        echo '<h1 class="text-center mb-4" data-lang="SearchResults">Search Results</h1>';
        echo '<div class="row car-grid">';
        while ($row = $result->fetch_assoc()) {

            $imagePaths = json_decode($row['images'], true);
             echo '<div class="col-lg-4 col-md-6 car-card">';
             foreach ($imagePaths as $imagePath):
                 echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '">';
            break;
             endforeach;
             echo '<h3>' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '</h3>';
             echo '<p data-lang="Year"> '.'</p>';
             echo ' :' . htmlspecialchars($row['year']) ;
             echo '<p data-lang="Price">' .'</p>' ;
             echo ':' . number_format($row['price']) ;
             echo '<a href ="car_detiales.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-primary" data-lang="Details">View Details</a>';
             echo '</div>';
        }
        echo '</div>'; 
        echo '</div>'; 
    } else {
        echo "<div class='container mt-4'><div class='alert alert-warning' data-lang='NoCarsFound'>No cars found matching your search.</div></div>"; //use data-lang
    }

    $stmt->close();
} else {
    echo "<div class='container mt-4'><div class='alert alert-danger' data-lang='QueryError'>Error in query: " . $conn->error . "</div></div>"; //use data-lang
}
$conn->close();
?>
