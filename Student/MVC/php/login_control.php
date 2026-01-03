<?php

session_start();
include '../db/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($email)) {
        $_SESSION['errors']['email'] = "Email is required";
    }
    if (empty($password)) {
        $_SESSION['errors']['password'] = "Password is required";
    }

    if (!empty($_SESSION['errors'])) {
        $_SESSION['old_email'] = $email;
        header("Location: ../html/login.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            
            
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['role'] = $row['role']; 
            $_SESSION['student_id'] = $row['student_id'];
            $_SESSION['karma_points'] = $row['karma_points'];

            if ($row['role'] === 'admin') {
                header("Location: ../../../Admin/MVC/html/dashboard.php");
            }
            elseif ($row['role'] == 'staff') {
                echo "Welcome staff! (Dashboard WIP)";
            } 
            else {
                header("Location: ../html/dashboard.php");
                exit();
            }
            exit();

        } else {
            $_SESSION['errors']['password'] = "Incorrect password";
            $_SESSION['old_email'] = $email;
            header("Location: ../html/login.php");
            exit();
        }

    } else {
        $_SESSION['errors']['email'] = "No account found with this email";
        $_SESSION['old_email'] = $email;
        header("Location: ../html/login.php");
        exit();
    }

} else {
    header("Location: ../html/login.php");
    exit();
}
?>