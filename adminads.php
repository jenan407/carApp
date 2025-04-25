<?php

require_once 'db_connection.php';


$sql = "SELECT 
            ads.id, 
            ads.full_name, 
            ads.image, 
            ads.`ad-url`, 
           ads.hit,
            ads.`start-date`,
            ads.`end-date`,
            ads.location
        FROM ads
     
        ORDER BY hit DESC"; 
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching ads data: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Statistics</title>
    <link rel="stylesheet" href="./css/admin.css">
    <style>
  

        .image-preview {
            max-width: 100px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ad Statistics</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Image</th>
                        <th>Ad URL</th>
                        <th>Hits</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($row['image']): ?>
                                    <img src="<?php echo htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Ad Image" class="image-preview">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td><a href="<?php echo htmlspecialchars($row['ad-url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><?php echo htmlspecialchars($row['ad-url'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                            <td><?php echo htmlspecialchars($row['hit'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['start-date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['end-date'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['location'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-ads">No ads found.</p>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
