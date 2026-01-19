<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access Denied");
}

if (isset($_GET['id'])) {
    $target_id = $conn->real_escape_string($_GET['id']);
    $staff_id = $_SESSION['user_id'];

  
    $sql = "UPDATE users SET is_banned = 1 WHERE user_id = '$target_id'";

    if ($conn->query($sql) === TRUE) {
        
      
        $log_sql = "INSERT INTO admin_logs (admin_id, action_type, description) 
                    VALUES ('$staff_id', 'BAN_USER', 'Banned user ID #$target_id due to fraud')";
        $conn->query($log_sql);

        header("Location: ../html/dashboard.php?page=fraud");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>