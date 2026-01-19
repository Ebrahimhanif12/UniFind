<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

// 1. Security Check: Admin Only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

if (isset($_GET['id'])) {
    $student_id = $conn->real_escape_string($_GET['id']);

    $check = $conn->query("SELECT email, full_name, role FROM users WHERE user_id='$student_id'")->fetch_assoc();

    if (!$check || $check['role'] !== 'student') {
        die("Error: User not found or is not a student.");
    }


    
    $conn->query("DELETE FROM claims WHERE claimant_id = '$student_id'");
    
    $conn->query("DELETE FROM claims WHERE item_id IN (SELECT item_id FROM items WHERE user_id = '$student_id')");

    $conn->query("DELETE FROM items WHERE user_id = '$student_id'");

    $sql = "DELETE FROM users WHERE user_id='$student_id'";

    if ($conn->query($sql) === TRUE) {
        
        $admin_id = $_SESSION['user_id'];
        $desc = "Deleted student: " . $check['full_name'] . " (" . $check['email'] . ")";
        
        $conn->query("INSERT INTO admin_logs (admin_id, action_type, description) 
                      VALUES ('$admin_id', 'DELETE_STUDENT', '$desc')");

        header("Location: ../html/dashboard.php?page=users");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>