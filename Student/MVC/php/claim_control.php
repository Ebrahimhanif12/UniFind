<?php
session_start();
include '../db/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = $_POST['item_id'];
    $user_answer = strtolower(trim($_POST['answer'])); 

    $sql = "SELECT security_answer, user_id FROM items WHERE item_id = '$item_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correct_answer = $row['security_answer']; 
        $finder_id = $row['user_id'];

        if ($user_answer === $correct_answer) {
            
            // --- SUCCESS ---
           
            $finder_sql = "SELECT full_name, email, student_id FROM users WHERE user_id = '$finder_id'";
            $finder_res = $conn->query($finder_sql);
            $finder = $finder_res->fetch_assoc();

            $_SESSION['claim_success'] = [
                'name' => $finder['full_name'],
                'email' => $finder['email'],
                'student_id' => $finder['student_id']
            ];

            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();

        } else {
            // --- FAIL ---
            $_SESSION['claim_error'] = "Incorrect Answer! Please try again.";
            
            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();
        }

    } else {
        echo "Item not found.";
    }
}
?>