<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
include 'db_connection.php';

    $user_id = $_SESSION['user_id'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    $sql = "SELECT password FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($currentPassword, $user['password'])) {
           
            if ($newPassword === $confirmNewPassword) {
                if (strlen($newPassword) >= 6) {
                 
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $sqlUpdate = "UPDATE user SET password = ? WHERE id = ?";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->bind_param("si", $hashedNewPassword, $user_id);

                    if ($stmtUpdate->execute()) {
                        $_SESSION['password_change_message'] = "Password changed successfully!";
                    } else {
                        $_SESSION['password_change_message'] = "Error updating password. Please try again.";
                    }
                    $stmtUpdate->close();
                } else {
                    $_SESSION['password_change_message'] = "Error: New password must be at least 6 characters long.";
                }
            } else {
                $_SESSION['password_change_message'] = "Error: New password and confirm password do not match.";
            }
        } else {
            $_SESSION['password_change_message'] = "Error: Incorrect current password.";
        }
    } else {
        $_SESSION['password_change_message'] = "Error: User not found.";
    }

    $stmt->close();
    $conn->close();

    header("Location: profile.php"); 
    exit();
} else {
    header("Location: profile.php"); 
    exit();
}
?>