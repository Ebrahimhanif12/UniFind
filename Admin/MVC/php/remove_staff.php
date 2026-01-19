<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

// 1. Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. System Owner only.");
}

if (isset($_GET['id'])) {
    $target_id = $conn->real_escape_string($_GET['id']);
    
    $check = $conn->query("SELECT email, role FROM users WHERE user_id='$target_id'")->fetch_assoc();
    
    if ($check['role'] !== 'staff') {
        die("Error: You can only remove Staff accounts via this link.");
    }

    // 2. Delete User
    $sql = "DELETE FROM users WHERE user_id='$target_id'";

    if ($conn->query($sql) === TRUE) {
        
        $admin_id = $_SESSION['user_id'];
        $log_desc = "Removed staff account: " . $check['email'];
        $conn->query("INSERT INTO admin_logs (admin_id, action_type, description) VALUES ('$admin_id', 'REMOVE_STAFF', '$log_desc')");

        header("Location: ../html/dashboard.php?page=staff");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>