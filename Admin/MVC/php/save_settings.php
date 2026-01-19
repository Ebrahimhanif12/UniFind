<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied");
}

$action = $_POST['action'];

if ($action == 'update_features') {
    $posting = isset($_POST['enable_posting']) ? 1 : 0;
    $signup = isset($_POST['enable_signup']) ? 1 : 0;

    $conn->query("INSERT INTO system_settings (setting_key, setting_value) VALUES ('enable_posting', $posting) ON DUPLICATE KEY UPDATE setting_value=$posting");
    $conn->query("INSERT INTO system_settings (setting_key, setting_value) VALUES ('enable_signup', $signup) ON DUPLICATE KEY UPDATE setting_value=$signup");

    $admin_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO admin_logs (admin_id, action_type, description) VALUES ('$admin_id', 'SETTINGS_UPDATE', 'Updated system feature toggles')");

} elseif ($action == 'update_announcement') {
    $msg = $conn->real_escape_string($_POST['message']);
    $active = (int)$_POST['is_active'];
    $type = $conn->real_escape_string($_POST['type']);

    if ($active == 1) {
        $conn->query("UPDATE announcements SET is_active = 0");
    }

    $conn->query("INSERT INTO announcements (message, is_active, type) VALUES ('$msg', '$active', '$type')");

    $status_text = ($active == 1) ? "Active" : "Inactive";
    $admin_id = $_SESSION['user_id'];
    $conn->query("INSERT INTO admin_logs (admin_id, action_type, description) VALUES ('$admin_id', 'ANNOUNCEMENT', 'Updated banner ($status_text - $type): $msg')");
}

header("Location: ../html/dashboard.php?page=settings");
exit();
?>