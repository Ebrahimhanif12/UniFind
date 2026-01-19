<?php
// SYSTEM LOGIC ENGINE
// This file reads the settings set by the Admin/Owner.

// 1. CHECK: Is Posting Enabled?
function isPostingEnabled($conn) {
    $sql = "SELECT setting_value FROM system_settings WHERE setting_key = 'enable_posting'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (int)$row['setting_value'] === 1; // Returns TRUE if 1, FALSE if 0
    }
    return true; // Default to TRUE if setting missing
}

// 2. CHECK: Is Signup Enabled?
function isSignupEnabled($conn) {
    $sql = "SELECT setting_value FROM system_settings WHERE setting_key = 'enable_signup'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (int)$row['setting_value'] === 1;
    }
    return true;
}

// 3. GET: Active Announcement
function getGlobalAnnouncement($conn) {
    // Fetch the latest ACTIVE announcement
    // We select message and type (info, warning, danger)
    $sql = "SELECT message, type FROM announcements WHERE is_active = 1 ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc(); // Returns ['message' => '...', 'type' => '...']
    }
    return null; // No active announcement
}
?>