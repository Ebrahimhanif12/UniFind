<?php
session_start();
include '../db/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = $conn->real_escape_string($_POST['item_id']);
    $user_answer = $conn->real_escape_string(strtolower(trim($_POST['answer']))); 
    $current_user_id = $_SESSION['user_id']; 

    // 1. Fetch correct answer AND finder_id
    $sql = "SELECT security_answer, user_id FROM items WHERE item_id = '$item_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correct_answer = strtolower(trim($row['security_answer'])); 
        $finder_id = $row['user_id'];

        // --- SECURITY CHECK: PREVENT SELF-CLAIM ---
        if ($finder_id == $current_user_id) {
            echo "<script>
                    alert('Error: You cannot claim an item you posted yourself.');
                    window.location.href = '../html/dashboard.php?page=feed';
                  </script>";
            exit();
        }

        // 2. Compare Answers
        if ($user_answer === $correct_answer) {
            
            // --- SUCCESS CASE ---
            
            // A. Update Item Status
            $conn->query("UPDATE items SET status = 'claimed' WHERE item_id = '$item_id'");

            // B. Reward Finder
            $conn->query("UPDATE users SET karma_points = karma_points + 10 WHERE user_id = '$finder_id'");

            // C. Log SUCCESS (Status: approved)
            $log_sql = "INSERT INTO claims (item_id, claimant_id, answer_attempt, status) 
                        VALUES ('$item_id', '$current_user_id', '$user_answer', 'approved')";
            $conn->query($log_sql);

            // D. Get Finder Info
            $finder = $conn->query("SELECT full_name, email, student_id FROM users WHERE user_id = '$finder_id'")->fetch_assoc();

            // E. Save to Session
            $_SESSION['claim_success'] = [
                'name' => $finder['full_name'],
                'email' => $finder['email'],
                'student_id' => $finder['student_id']
            ];

            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();

        } else {
            
            // --- FAILURE CASE (THIS WAS MISSING) ---
            
            // 1. Log FAILURE (Status: rejected) - CRITICAL FOR FRAUD DETECTION
            // This is what the Staff Dashboard counts!
            $fail_sql = "INSERT INTO claims (item_id, claimant_id, answer_attempt, status) 
                         VALUES ('$item_id', '$current_user_id', '$user_answer', 'rejected')";
            $conn->query($fail_sql);

            // 2. Set Error
            $_SESSION['claim_error'] = "Incorrect Answer! This failed attempt has been recorded.";
            
            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();
        }

    } else {
        echo "Item not found.";
    }
}
?>