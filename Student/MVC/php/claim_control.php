<?php
session_start();
include '../db/db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $item_id = $_POST['item_id'];
    $user_answer = strtolower(trim($_POST['answer'])); 
    $current_user_id = $_SESSION['user_id']; // The logged-in user

    // 1. Fetch correct answer AND finder_id
    $sql = "SELECT security_answer, user_id FROM items WHERE item_id = '$item_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correct_answer = $row['security_answer']; 
        $finder_id = $row['user_id'];

        // --- SECURITY CHECK: PREVENT SELF-CLAIM ---
        if ($finder_id == $current_user_id) {
            echo "<script>
                    alert('Error: You cannot claim an item you posted yourself.');
                    window.location.href = '../html/dashboard.php?page=feed';
                  </script>";
            exit();
        }
        // ------------------------------------------

        // 2. Compare User's Answer vs Database Answer
        if ($user_answer === $correct_answer) {
            
            // --- SUCCESS: CYCLE COMPLETE ---
            
            // A. CLOSE THE TICKET (Update status to 'claimed')
            $update_item_sql = "UPDATE items SET status = 'claimed' WHERE item_id = '$item_id'";
            $conn->query($update_item_sql);

            // B. REWARD THE FINDER (+10 Karma Points)
            $update_karma_sql = "UPDATE users SET karma_points = karma_points + 10 WHERE user_id = '$finder_id'";
            $conn->query($update_karma_sql);

            // ======================================================
            // C. CREATE CLAIM RECORD (Adapted for your table)
            // ======================================================
            $status_log = 'Verified'; 
            
            // We use your specific columns: item_id, claimant_id, answer_attempt, status
            $log_claim_sql = "INSERT INTO claims (item_id, claimant_id, answer_attempt, status) 
                              VALUES ('$item_id', '$current_user_id', '$user_answer', '$status_log')";
            
            $conn->query($log_claim_sql);
            // ======================================================

            // D. Get Finder's Info (to show to the claimant)
            $finder_sql = "SELECT full_name, email, student_id FROM users WHERE user_id = '$finder_id'";
            $finder_res = $conn->query($finder_sql);
            $finder = $finder_res->fetch_assoc();

            // E. Save Info to Session
            $_SESSION['claim_success'] = [
                'name' => $finder['full_name'],
                'email' => $finder['email'],
                'student_id' => $finder['student_id']
            ];

            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();

        } else {
            // FAIL
            $_SESSION['claim_error'] = "Incorrect Answer! Please try again.";
            header("Location: ../html/dashboard.php?page=claim&item_id=$item_id");
            exit();
        }

    } else {
        echo "Item not found.";
    }
}
?>