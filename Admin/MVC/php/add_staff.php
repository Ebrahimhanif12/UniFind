<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied. System Owner only.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $raw_password = $_POST['password'];
    
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
    
    $staff_id = "STF-" . rand(1000, 9999);

    $sql = "INSERT INTO users (full_name, email, password, student_id, role) 
            VALUES ('$full_name', '$email', '$hashed_password', '$staff_id', 'staff')";

    if ($conn->query($sql) === TRUE) {
        
        $admin_id = $_SESSION['user_id'];
        $log_desc = "Created new staff account: $email";
        $log_sql = "INSERT INTO admin_logs (admin_id, action_type, description) 
                    VALUES ('$admin_id', 'ADD_STAFF', '$log_desc')";
        $conn->query($log_sql);

        header("Location: ../html/dashboard.php?page=staff");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>