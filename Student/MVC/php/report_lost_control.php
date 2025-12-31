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
     //default status lost
    $status = 'lost';

    $image_path = NULL; 

    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] == 0) {
        
        $target_dir = "../uploads/";
        
        // Getting file extension
        $imageFileType = strtolower(pathinfo($_FILES["item_image"]["name"], PATHINFO_EXTENSION));
        
        // Validating image type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            // creating  a Unique Name for file
            $new_file_name = "item_" . time() . "_" . rand(10, 99) . "." . $imageFileType;
            $target_file = $target_dir . $new_file_name;

            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                $image_path = $new_file_name;
            } else {
                echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit();
        }
    }

    //Insert into Database
    $sql = "INSERT INTO items (user_id, title, category, description, location, lost_date, status, image_path) 
            VALUES ('$user_id', '$title', '$category', '$description', '$location', '$lost_date', '$status', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Item Reported Successfully!'); 
                window.location.href = '../html/dashboard.php';
              </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
    }

} else {
    header("Location: ../html/dashboard.php");
    exit();
}
?>