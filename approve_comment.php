<?php

    include 'db_connection.php';

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $comment_id = $_GET['id'];

        $sql = "UPDATE comments SET is_public = 1, status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            header("Location: admin.php?message=Comment+approved+successfully");
        } else {
            header("Location: admin.php?error=Error+approving+comment");
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: comments.php?error=Invalid+comment+ID");
        exit();
    }
?>