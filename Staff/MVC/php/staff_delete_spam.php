<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access Denied");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $conn->real_escape_string($_POST['item_id']);
    $staff_id = $_SESSION['user_id'];

    $conn->query("DELETE FROM claims WHERE item_id = '$item_id'");
    $sql = "DELETE FROM items WHERE item_id = '$item_id'";

    if ($conn->query($sql) === TRUE) {
        
        $conn->query("INSERT INTO admin_logs (admin_id, action_type, description) 
                      VALUES ('$staff_id', 'DELETE_SPAM', 'Removed item #$item_id as spam')");

        header("Location: ../html/dashboard.php?page=fraud");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>