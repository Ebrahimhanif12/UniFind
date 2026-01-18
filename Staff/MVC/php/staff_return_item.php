<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    die("Access Denied");
}

if (isset($_GET['id'])) {
    $item_id = $conn->real_escape_string($_GET['id']);
    $staff_id = $_SESSION['user_id'];

    $item_query = $conn->query("SELECT user_id, title FROM items WHERE item_id = '$item_id'");
    
    if ($item_query->num_rows > 0) {
        $item = $item_query->fetch_assoc();
        $finder_id = $item['user_id'];
        $item_title = $conn->real_escape_string($item['title']);

        $conn->begin_transaction();

        try {
             Update Item Status to 'claimed'
            $conn->query("UPDATE items SET status = 'claimed' WHERE item_id = '$item_id'");

            //Add to Custody Log (Chain of Custody)
            $log_note = "Item returned to owner.";
            $conn->query("INSERT INTO custody_log (item_id, staff_id, action_type, notes) 
                          VALUES ('$item_id', '$staff_id', 'returned', '$log_note')");

            // We give 50 points for successfully returning an item to the office
            $conn->query("UPDATE users SET karma_points = karma_points + 50 WHERE user_id = '$finder_id'");

            $conn->commit();

            header("Location: ../html/dashboard.php?page=custody");
            exit();

        } catch (Exception $e) {
            $conn->rollback();
            echo "Error processing return: " . $e->getMessage();
        }

    } else {
        echo "Item not found.";
    }
}
?>