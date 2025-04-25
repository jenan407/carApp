<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Comments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="website icon" type="png" href="images/icon.jpg">
    <link rel ="stylesheet" href ="./css/view_comms.css">
<style>
    
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f8;
    color: #333;
    margin: 0;
    padding: 0;
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

    <div class="container mt-4">
  
        <h2 data-lang="CustomerComments">Customer Comments</h2>
        <div class="row review-grid">
            <?php
            include 'db_connection.php';

       
            $sqlComments = "SELECT name, content, created_at, type, car_id FROM comments WHERE is_public = 1 AND status = 'Approved' ORDER BY created_at DESC";
            $resultComments = $conn->query($sqlComments);

            if ($resultComments && $resultComments->num_rows > 0) {
                while ($row = $resultComments->fetch_assoc()) {
                    echo '<div class="review-card">';
                    echo '<h6 class="text-muted">';
                    echo 'By: ' . htmlspecialchars($row['name']);
                    echo ' - ';
                  
                    $dateTime = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                    $dateTime->setTimezone(new DateTimeZone('Australia/Sydney'));
                    echo $dateTime->format('F j, Y, g:i a');
                    echo '</h6>';
                    echo '<p>"' . nl2br(htmlspecialchars($row['content'])) . '"</p>';
                    if ($row['type'] === 'seller' && $row['car_id']) {
                        echo '<p class="small text-muted"data-lang="RegardingcarID">Regarding car ID: ' . htmlspecialchars($row['car_id']) . '</p>';
                        echo '<p class="small text-muted"> ' . htmlspecialchars($row['car_id']) . '</p>';
                    } elseif ($row['type'] === 'site') {
                        echo '<p class="small text-muted"data-lang="Generalwebsitefeedback">General website feedback</p>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<div class="no-comments" data-lang="noComments">No customer comments available yet.</div>';
            }
            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./js/script.js" type="module"></script>
</body>
</html>