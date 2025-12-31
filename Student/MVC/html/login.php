<?php
session_start();
function showError($field) {
    if (isset($_SESSION['errors'][$field])) {
        echo '<span style="color: red; font-size: 0.85rem; font-weight: 500; display: block; margin-top: 5px;">' 
             . $_SESSION['errors'][$field] 
             . '</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | UniFind</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="auth-mode">

    <div class="auth-container">
        <div class="auth-header">
            <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" alt="UniFind Logo">
            <h2>Welcome Back</h2>
            <p>Login to your account</p>
        </div>

        <form action="../php/login_control.php" method="POST">
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" 
                       value="<?php echo isset($_SESSION['old_email']) ? htmlspecialchars($_SESSION['old_email']) : ''; ?>" 
                       placeholder="xx-xxxxx-x@student.aiub.edu" required>
                <?php showError('email'); ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="loginPass" class="form-control" placeholder="Enter password" required>
                <img src="../images/eye-open.png" class="toggle-password" onclick="togglePass('loginPass', this)">
                <?php showError('password'); ?>
            </div>

            <button type="submit" class="btn-reg">Login</button>
        </form>

        <div class="link-text">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>

    <script>
        function togglePass(inputId, iconElement) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                iconElement.src = "../images/eye-close.png"; 
            } else {
                input.type = "password";
                iconElement.src = "../images/eye-open.png"; 
            }
        }
    </script>

</body>
</html>

<?php
unset($_SESSION['errors']);
unset($_SESSION['old_email']);
?>