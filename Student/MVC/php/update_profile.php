<?php
session_start();
include '../../db/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nickname = $conn->real_escape_string(trim($_POST['nickname']));
$phone = $conn->real_escape_string(trim($_POST['phone_number']));

$image_query_part = "";
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $_FILES['profile_image']['name'];
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    
    if (in_array(strtolower($filetype), $allowed)) {
        // Creating unique name for image
        $new_filename = "profile_" . $user_id . "_" . time() . "." . $filetype;
        $target = "../uploads/" . $new_filename;
        
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
            $image_query_part = ", profile_image = '$new_filename'";
            
            $_SESSION['profile_image'] = $new_filename;
        }
    }
}

$sql = "UPDATE users SET nickname = '$nickname', phone_number = '$phone' $image_query_part WHERE user_id = '$user_id'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['nickname'] = $nickname;
    $_SESSION['phone'] = $phone; 
    
    header("Location: ../html/dashboard.php?page=profile&success=1");
} else {
    header("Location: ../html/dashboard.php?page=profile&error=Update failed");
}
exit();
?>