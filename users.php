
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users</title>
        <link rel="stylesheet" href="./css/admin.css">
        <link rel ="stylesheet" href ="./css/users.css">    
    </head>
    <body>
        <h2>Users</h2>
        <?php

    include 'db_connection.php';

    $sql = "SELECT id,name, email ,mobileno FROM user"; 
    $result = $conn->query($sql);
    $users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

         if (!empty($users)): ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>phone number_format</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo $user['mobileno']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-users">No users found.</p>
        <?php endif; ?>
    </body>
    </html>
