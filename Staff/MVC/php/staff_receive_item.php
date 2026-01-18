<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

// Security: Staff Only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access Denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $conn->real_escape_string($_POST['item_id']);
    $staff_id = $_SESSION['user_id'];

    $sql = "UPDATE items SET status = 'custody' WHERE item_id = '$item_id'";

    if ($conn->query($sql) === TRUE) {
        
        $notes = "Item physically received at office by staff.";
        $log_sql = "INSERT INTO custody_log (item_id, staff_id, action_type, notes) 
                    VALUES ('$item_id', '$staff_id', 'received', '$notes')";
        $conn->query($log_sql);

        header("Location: ../html/dashboard.php?page=custody");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>