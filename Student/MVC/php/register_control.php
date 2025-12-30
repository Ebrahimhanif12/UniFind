<?php

session_start(); 
include '../db/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = $_POST['full_name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Array for store errors
    $errors = [];

    //  Validation
    if (empty($full_name)) $errors['full_name'] = "Name is required";
    if (empty($student_id)) $errors['student_id'] = "ID is required";
    if (empty($email)) $errors['email'] = "Email is required";
    
    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match!";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST; 
        header("Location: ../html/register.php");
        exit();
    }

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (full_name, student_id, email, password, role, karma_points) 
            VALUES ('$full_name', '$student_id', '$email', '$hashPassword', 'student', 0)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_msg'] = "Registration Successful! Please Login.";
        header("Location: ../html/login.php"); 
        exit();
    } else {
\
        $_SESSION['errors']['email'] = "Email or ID already registered!";
        $_SESSION['old_data'] = $_POST;
        header("Location: ../html/register.php");
        exit();
    }

} else {
    header("Location: ../html/register.php");
    exit();
}
?>