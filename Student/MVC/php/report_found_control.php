<?php
session_start();
include '../db/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $lost_date = $_POST['lost_date']; 
    $description = $_POST['description'];
    
    $security_question = $_POST['security_question'];
    $security_answer = strtolower(trim($_POST['security_answer'])); 

    $status = 'found'; 

   
    $image_path = NULL;
    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($_FILES["item_image"]["name"], PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            $new_file_name = "found_" . time() . "_" . rand(10, 99) . "." . $imageFileType;
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_dir . $new_file_name)) {
                $image_path = $new_file_name;
            }
        }
    }

   
    $sql = "INSERT INTO items (user_id, title, category, description, location, lost_date, status, image_path, security_question, security_answer) 
            VALUES ('$user_id', '$title', '$category', '$description', '$location', '$lost_date', '$status', '$image_path', '$security_question', '$security_answer')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Found Item Posted!'); window.location.href = '../html/dashboard.php?page=feed';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>