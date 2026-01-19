<?php
if (isset($_SESSION['user_id'])) {
    
    $uid = $_SESSION['user_id'];
    
    // Checking Status directly from DB
    $check_ban = $conn->query("SELECT is_banned FROM users WHERE user_id = '$uid'");
    
    if ($check_ban && $check_ban->num_rows > 0) {
        $user_data = $check_ban->fetch_assoc();
        
        if ($user_data['is_banned'] == 1) {
            session_destroy();
            echo "<script>
                alert('Your session has been terminated by the administrator.');
                window.location.href = '../../../Student/MVC/html/login.php';
            </script>";
            exit();
        }
    }
}
?>