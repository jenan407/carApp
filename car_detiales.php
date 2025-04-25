<?php


session_start(); 


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index4.php?error=invalid_car_id"); 
    exit();
}

$car_id = intval($_GET['id']);

require_once 'db_connection.php';


$sql = "SELECT
            c.id,
            c.brand,
            c.model,
            c.year,
            c.price,
            c.images,
            c.description,
            c.sold,
            c.color,
            c.country,
            c.city,
            u.name AS seller_name,
            u.email AS seller_email
        FROM
            cars c
        JOIN
            user u ON c.user_id = u.id
        WHERE
            c.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $_SESSION['car_details_error'] = "Car details not found.";
    header("Location: index4.php?error=car_not_found"); 
    exit();
}

$car = $result->fetch_assoc();

$imagePaths = json_decode($car['images'], true);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) . ' Details'; ?></title>
    
   
    <link rel="stylesheet" href="./css/car_detiales.css"> 
    <link rel = "website icon " type ="png" href ="images/icon.jpg">
<style>nav {
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
}</style>
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
    <div class="container car-details-container">
        <h2 class="car-title">
            <?php echo htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) . ' (' . htmlspecialchars($car['year']) . ')'; ?>
            <?php if ($car['sold']): ?>
                <span class="sold-badge"data-lang="sold">Sold</span>
            <?php else: ?>
                <span class="not-sold-badge"data-lang="Available">Available</span>
            <?php endif; ?>
        </h2>

        <div class="car-info-row">
            <div class="car-info-label"data-lang="Price">Price:</div>
            <div class="car-info-label"><?php echo htmlspecialchars('$' . number_format($car['price'], 2)); ?></div>
        </div>

        <div class="car-info-row">
            <div class="car-info-label"data-lang="Color">Color:</div>
            <div class="car-info-label"><?php echo htmlspecialchars($car['color']); ?></div>
        </div>

        <div class="car-info-row">
            <div class="car-info-label"data-lang="Country">Country:</div>
            <div class="car-info-label"><?php echo htmlspecialchars($car['country']); ?></div>
        </div>

        <div class="car-info-row">
            <div class="car-info-label"data-lang="City">City:</div>
            <div class="car-info-label"><?php echo htmlspecialchars($car['city']); ?></div>
        </div>

        <div class="car-description-section">
            <h3 class="car-description-title"data-lang="Description">Description</h3>
            <p class="car-description-text"><?php echo nl2br(htmlspecialchars($car['description'])); ?></p>
        </div>

        <?php if (!empty($imagePaths)): ?>
            <div class="car-images-section">
                <h3 class="car-images-title"data-lang="CarImages">Car Images</h3>
                <div class="car-image-gallery">
                    <?php foreach ($imagePaths as $imagePath): ?>
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) . ' Image'; ?>">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="car-images-section">
                <h3 class="car-images-title"data-lang="CarImages">Car Images</h3>
                <p>No images available for this car.</p>
            </div>
        <?php endif; ?>

        <div class="seller-info-section">
            <h3 class="seller-info-title"data-lang="SellerInformation">Seller Information</h3>
            <div class="seller-info-row">
                <div class="seller-info-label"data-lang="Name">Name:</div>
                <div class="seller-info-label"><?php echo htmlspecialchars($car['seller_name']); ?></div>
            </div>
            <div class="seller-info-row">
                <div class="seller-info-label"data-lang="Email">Email:</div>
                <div class="seller-info-value"><a href="mailto:<?php echo htmlspecialchars($car['seller_email']); ?>"><?php echo htmlspecialchars($car['seller_email']); ?></a></div>
            </div>
        </div>

        <a href="home.php" class="back-link"data-lang="Back">Back to Listings</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/script.js" type="module"></script>

</body>
</html>