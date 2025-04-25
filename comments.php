<?php

require_once 'db_connection.php';


function displayApprovedComments($conn, $commentType = null, $carId = null) {
    $sql = "SELECT name, content, created_at, user_nsme FROM comments WHERE is_public = 1 AND status = 'Approved'";

    if ($commentType === 'seller' && $carId !== null) {
        $sql .= " AND type = 'seller' AND car_id = ?";
    } elseif ($commentType === 'site') {
        $sql .= " AND type = 'site'";
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);

    if ($commentType === 'seller' && $carId !== null) {
        $stmt->bind_param("i", $carId);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="mt-4">';
        echo '<h4>Customer Comments:</h4>';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="card mb-3">';
            echo '<div class="card-body">';
                echo '<h6 class="card-subtitle mb-2 text-muted">';
                    echo 'By: ' . htmlspecialchars($row['name']);
                    if (!empty($row['user_nsme'])) {
                        echo ' (' . htmlspecialchars($row['user_nsme']) . ')';
                    }
                    
                    $dateTime = new DateTime($row['created_at'], new DateTimeZone('UTC'));
                    $dateTime->setTimezone(new DateTimeZone('Australia/Sydney'));
                    echo ' - ' . $dateTime->format('F j, Y, g:i a');
                echo '</h6>';
                echo '<p class="card-text">' . nl2br(htmlspecialchars($row['content'])) . '</p>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p class="mt-3">No comments available yet.</p>';
    }

    $stmt->close();
}


if (isset($_GET['car_id']) && is_numeric($_GET['car_id'])) {
    $currentCarId = filter_var($_GET['car_id'], FILTER_VALIDATE_INT);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Details - Comments</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Car Details</h2>
            <?php displayApprovedComments($conn, 'seller', $currentCarId); ?>

            <p><a href="add_comment.php?car_id=<?php echo $currentCarId; ?>">Leave a Comment</a></p>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}


?>