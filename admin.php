<?php

    $page = 'comments';
    if (isset($_GET['page']) && in_array($_GET['page'], ['users', 'add_ads', 'comments','ads','setting'])) {
        $page = $_GET['page'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./css/admin.css">
    <link rel = "website icon " type ="png" href ="images/icon.jpg">
</head>
<body>
    <nav class="admin-nav">
        <ul>
            <li><a href="?page=users" class="<?php if ($page === 'users') echo 'active'; ?>">Users</a></li>
            <li><a href="?page=add_ads" class="<?php if ($page === 'add_ads') echo 'active'; ?>">Add Ads</a></li>
            <li><a href="?page=comments" class="<?php if ($page === 'comments') echo 'active'; ?>">Comments</a></li>
            <li><a href="?page=ads" class="<?php if ($page === 'ads') echo 'active'; ?>">Ads</a></li>
            <li><a href="?page=setting" class="<?php if ($page === 'setting') echo 'active'; ?>">settings</a></li>
            <li><a href="logout.php">Logout</a></li> </ul>
    </nav>

    <div class="admin-content">
        <?php
            switch ($page) {
                case 'users':
                    include 'users.php';
                    break;
                case 'add_ads':
                    include 'add_ads.php';
                    break;
                case 'comments':
                    include 'admincoms.php';
                    break;
                    case 'ads':
                        include 'adminads.php';
                    break;
                    case 'setting' :
                        include 'settings_edit.php';
                    break;    
            }
        ?>
    </div>

    <script src="./js/admin.js"></script>
</body>
</html>