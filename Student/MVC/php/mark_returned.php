<?php
session_start();
include '../db/db_conn.php';

// 1. Check if ID exists
if (!isset($_GET['item_id'])) {
    die("Error: Missing ID");
}

$item_id = $conn->real_escape_string($_GET['item_id']);
$user_id = $_SESSION['user_id'];

// 2. Security: Update ONLY if the item belongs to the logged-in user
$sql = "UPDATE items SET status = 'claimed' WHERE item_id = '$item_id' AND user_id = '$user_id'";

if ($conn->query($sql) === TRUE) {
    // Success: Go back to dashboard
    header("Location: ../html/dashboard.php?page=home");
} else {
    echo "Error updating record: " . $conn->error;
}
?>