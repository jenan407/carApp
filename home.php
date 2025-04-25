<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarZone - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/lung.css">
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



    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/carousel.jpg" class="d-block w-100" alt="Carousel 1">
                <div class="carousel-caption d-none d-md-block">
    <h5 data-lang="Find Your Dream Car!">Find Your Dream Car!</h5>
    <p data-lang="Browse our best deals.">Browse our best deals.</p>
</div>
            </div>
            <div class="carousel-item">
                <img src="images/carousel10.jpg" class="d-block w-100" alt="Carousel 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Sell Your Car Easily</h5>
                    <p>Get the best price.</p>
                </div>
            </div>

        <div class="carousel-item">
                <img src="images/carousel3.jpg" class="d-block w-100" alt="Carousel 3">
                <div class="carousel-caption d-none d-md-block">

                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container mt-4">
        <div id="top-ads-container" class="mb-4">
            <?php
            include 'db_connection.php';
          

            $currentDate = date('Y-m-d'); 

            $sqlBottomAds = "SELECT `full_name`, image, `ad-url`, id FROM ads
                                          WHERE location = 'top'
                                            AND `end-date` >= '$currentDate' 
                                          ORDER BY RAND()";
            $stmtBottom = $conn->prepare($sqlBottomAds);
            $stmtBottom->execute();
            $resultBottomAds = $stmtBottom->get_result();
            $bottomAds = $resultBottomAds->fetch_all(MYSQLI_ASSOC);
            $stmtBottom->close();

            if (!empty($bottomAds)): ?>
                <div id="top-ads-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                    <div class="carousel-inner">
                        <?php foreach ($bottomAds as $index => $ad): ?>
                            <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                                <div class="ad-banner">
                                    <a href="update_hits.php?ad_id=<?php echo htmlspecialchars($ad['id']); ?>&url=<?php echo urlencode($ad['ad-url']); ?>" target="_blank" class="ad-link">
                                        <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['full_name']); ?>" class="ad-image">
                                        <span class="ad-text"><?php echo htmlspecialchars($ad['full_name']); ?></span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-muted" data-lang ="Notopadvertisementsavailable">No top advertisements available.</p>
            <?php endif; ?>
       
        </div>

        <form class="input-group mb-4" action="car_search.php" method="GET">
    <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search for a car..." data-lang-placeholder="Searchforacar">
    <div class="input-group-append">
        <button class="btn btn-primary" type="submit" id="searchButton" data-lang="Search">Search</button>
    </div>
         </form>

        <section class="latest-cars">
        <h2 data-lang="LatestCars">Latest Cars</h2>

            <div class="row car-grid">
                <?php
               

               
                $sqlLatest = "SELECT id, brand, model, year, price, images FROM cars ORDER BY id DESC LIMIT 6";
                $resultLatest = $conn->query($sqlLatest);
               
                    if ($resultLatest && $resultLatest->num_rows > 0) {
                        while ($row = $resultLatest->fetch_assoc()) {
    
                           $imagePaths = json_decode($row['images'], true);
                            echo '<div class="col-lg-4 col-md-6 car-card">';
                            foreach ($imagePaths as $imagePath):
                                echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '">';
                           break; 
                            endforeach;
                            echo '<h3>' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '</h3>';
                            echo '<p>Year: ' . htmlspecialchars($row['year']) . '</p>';
                            echo '<p>Price: $' . number_format($row['price']) . '</p>';
                            echo '<a href ="car_detiales.php?id=' . htmlspecialchars($row['id']) . '"  class="btn btn-sm btn-primary"data-lang="Details" >View Details</a>';
                            echo '</div>';
                        }
                    } else {
                    echo '<p>No latest cars available.</p>';
                }
                ?>
            </div>
            <div class="mt-3">
                <a href="all_cars.php" class="btn btn-outline-info" data-lang ="ViewAllCars">View All Cars</a>
            </div>
        </section>

        <section class="featured-cars">
            <h2 data-lang="FeaturedCars">Featured Cars</h2>
            <div class="row car-grid">
                <?php
                $sqlFeatured = "SELECT id, brand, model, year, price, images FROM cars ORDER BY RAND() LIMIT 3";
                $resultFeatured = $conn->query($sqlFeatured);
                if ($resultFeatured && $resultFeatured->num_rows > 0) {
                    while ($row = $resultFeatured->fetch_assoc()) {

                       $imagePaths = json_decode($row['images'], true);
                        echo '<div class="col-lg-4 col-md-6 car-card">';
                        foreach ($imagePaths as $imagePath):
                            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '">';
                       break; 
                        endforeach;
                        echo '<h3>' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '</h3>';
                        echo '<p>Year: ' . htmlspecialchars($row['year']) . '</p>';
                        echo '<p>Price: $' . number_format($row['price']) . '</p>';
                        echo '<a href ="car_detiales.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-primary" data-lang="Details">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No featured cars available.</p>';
                }
                ?>
            </div>
        </section>

        <div id="middle-ads-container" class="mt-4 mb-4">
        <?php
    

        $currentDate = date('Y-m-d'); 

        $sqlMiddleAds = "SELECT `full_name`, image, `ad-url`, id FROM ads
                                         WHERE location = 'middle'
                                         AND `end-date` >= '$currentDate' 
                                         ORDER BY RAND()";
        $stmtMiddle = $conn->prepare($sqlMiddleAds);
        $stmtMiddle->execute();
        $resultMiddleAds = $stmtMiddle->get_result();
        $middleAds = $resultMiddleAds->fetch_all(MYSQLI_ASSOC);
        $stmtMiddle->close();

        if (!empty($middleAds)): ?>
            <div id="middle-ads-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                <div class="carousel-inner">
                    <?php foreach ($middleAds as $index => $ad): ?>
                        <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                            <div class="ad-banner">
                                <a href="update_hits.php?ad_id=<?php echo htmlspecialchars($ad['id']); ?>&url=<?php echo urlencode($ad['ad-url']); ?>" target="_blank" class="ad-link">
                                    <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['full_name']); ?>" class="ad-image">
                                    <span class="ad-text"><?php echo htmlspecialchars($ad['full_name']); ?></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($middleAds) > 1): ?>
                    <a class="carousel-control-prev" href="#middle-ads-carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#middle-ads-carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-muted"data-lang="Nomiddleadvertisementsavailable">No middle advertisements available.</p>
        <?php endif; ?>
    </div>


        <section class="sold-cars">
            <h2 data-lang="RecentlySoldCars">Recently Sold Cars</h2>
            <div class="row car-grid">
                <?php
                
                $sqlSold = "SELECT id, brand, model, year, price, images FROM cars WHERE sold = 1 ORDER BY id DESC LIMIT 5";
                $resultsold = $conn->query($sqlSold);
                if ($resultsold && $resultsold->num_rows > 0) {
                    while ($row = $resultsold->fetch_assoc()) {

                       $imagePaths = json_decode($row['images'], true);
                        echo '<div class="col-lg-4 col-md-6 car-card">';
                        foreach ($imagePaths as $imagePath):
                            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '">';
                       break; 
                        endforeach;
                        echo '<h3>' . htmlspecialchars($row['brand'] . ' ' . $row['model']) . '</h3>';
                        echo '<p>Year: ' . htmlspecialchars($row['year']) . '</p>';
                        echo '<p>Price: $' . number_format($row['price']) . '</p>';
                        echo '<span class="badge badge-success">Sold</span>'; 
                        echo '</div>';
                    }
                } else {
                    echo '<p>No recently sold cars available.</p>';
                }
                ?>
            </div>
        </section>

        <section class="comments">
            <h2 data-lang="CustomerComments">Customer Comments</h2>
            <div class="row review-grid">
                <?php
              
                $sqlComments = "SELECT name, content, created_at, type, car_id FROM comments WHERE is_public = 1 AND status = 'Approved' ORDER BY created_at DESC LIMIT 5";
                $resultComments = $conn->query($sqlComments);

                if ($resultComments && $resultComments->num_rows > 0) {
                    while ($row = $resultComments->fetch_assoc()) {
                        echo '<div class="col-lg-6 review-card">';
                        echo '<h6 class="text-muted">';
                        echo 'By: ' . htmlspecialchars($row['name']);
                        echo ' - ';
                     
                        $dateTime = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                        $dateTime->setTimezone(new DateTimeZone('Australia/Sydney'));
                        echo $dateTime->format('F j, Y, g:i a');
                        echo '</h6>';
                        echo '<p>"' . nl2br(htmlspecialchars($row['content'])) . '"</p>';
                        if ($row['type'] === 'seller' && $row['car_id']) {
                            echo '<p class="small text-muted">Regarding car ID: ' . htmlspecialchars($row['car_id']) . '</p>';
                        } elseif ($row['type'] === 'site') {
                            echo '<p class="small text-muted">General website feedback</p>';
                        }
                        echo '</div>';
                    }
                } else {echo '<p>No customer comments available yet.</p>';
                }
                ?>
            </div>
            <div class="mt-3">
                <a href="addcoms.php?type=site" class="btn btn-outline-primary" data-lang ="LeaveWebsiteFeedback">Leave Website Feedback</a>
                <a href="view_comments.php" class="btn btn-outline-info" data-lang ="ViewAllComments">View All Comments</a>
            </div>
        </section>

        <div id="bottom-ads-container" class="mt-4">
        <?php
        
            $currentDate = date('Y-m-d'); 

            $sqlBottomAds = "SELECT `full_name`, image, `ad-url`, id FROM ads
                                          WHERE location = 'bottom'
                                            AND `end-date` >= '$currentDate' 
                                          ORDER BY RAND()";
            $stmtBottom = $conn->prepare($sqlBottomAds);
            $stmtBottom->execute();
            $resultBottomAds = $stmtBottom->get_result();
            $bottomAds = $resultBottomAds->fetch_all(MYSQLI_ASSOC);
            $stmtBottom->close();

            if (!empty($bottomAds)): ?>
                <div id="bottom-ads-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                    <div class="carousel-inner">
                        <?php foreach ($bottomAds as $index => $ad): ?>
                            <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                                <div class="ad-banner">
                                    <a href="update_hits.php?ad_id=<?php echo htmlspecialchars($ad['id']); ?>&url=<?php echo urlencode($ad['ad-url']); ?>" target="_blank" class="ad-link">
                                        <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="<?php echo htmlspecialchars($ad['full_name']); ?>" class="ad-image">
                                        <span class="ad-text"><?php echo htmlspecialchars($ad['full_name']); ?></span>
                                    </a>
                                </div>
                            </div>
            <?php endforeach; ?>
            </div>
            <?php if (count($bottomAds) > 1): ?>
                <a class="carousel-control-prev" href="#bottom-ads-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#bottom-ads-carousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-muted"data-lang="Nobottomadvertisementsavailable">No bottom advertisements available.</p>
            <?php endif; ?>
        </div>

        <footer class="mt-4 text-center">
            <button class="btn btn-outline-primary" data-lang="ContactUs"><i class="fas fa-envelope"></i> Contact Us</button>
            <button class="btn btn-outline-primary" data-lang="SocialMedia"><i class="fab fa-facebook"></i> Social Media</button>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/script.js" type="module"></script>
    <script>
        $(document).ready(function() {
            $('#carouselExampleControls').carousel();
        });
    </script>
</body>
</html>