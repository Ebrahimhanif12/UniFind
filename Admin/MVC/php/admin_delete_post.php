<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied: You are not an Admin.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $conn->real_escape_string($_POST['item_id']);
    $admin_id = $_SESSION['user_id'];

    $check_sql = "SELECT title FROM items WHERE item_id = '$item_id'";
    $check_res = $conn->query($check_sql);
    
    if ($check_res->num_rows > 0) {
        $item_title = $check_res->fetch_assoc()['title'];

        $conn->query("DELETE FROM claims WHERE item_id = '$item_id'");
        
        $sql = "DELETE FROM items WHERE item_id = '$item_id'";

        if ($conn->query($sql) === TRUE) {
            
            $action = "DELETE_POST";
            $desc = "Deleted item #$item_id ($item_title)";
            
            $log_sql = "INSERT INTO admin_logs (admin_id, action_type, description) 
                        VALUES ('$admin_id', '$action', '$desc')";
            $conn->query($log_sql);

            header("Location: ../html/dashboard.php?page=posts");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Item not found.";
    }
}
?>