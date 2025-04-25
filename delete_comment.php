<?php

   
    include 'db_connection.php';

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $comment_id = $_GET['id'];

        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            header("Location: admin.php?message=Comment+deleted+successfully");
        } else {
            header("Location: admin.php?error=Error+deleting+comment");
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: comments.php?error=Invalid+comment+ID");
        exit();
    }
?>