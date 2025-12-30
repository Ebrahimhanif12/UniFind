<?php
session_start();
// Helper function to show error message
function showError($field) {
    if (isset($_SESSION['errors'][$field])) {
        echo '<span class="error-msg">' . $_SESSION['errors'][$field] . '</span>';
    }
}

// Helper to keep old values
function old($field) {
    if (isset($_SESSION['old_data'][$field])) {
        echo htmlspecialchars($_SESSION['old_data'][$field]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <div class="auth-container">
        <div class="auth-header">
            <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" alt="UniFind Logo">
            <h2>Sign Up</h2>
            <p>Create your student account</p>
            <p>Join the secure campus community</p>
        </div>
        <!-- ----------form-------------- -->

        <form action="../php/register_control.php" method="POST">
            
            <div class="row-group">
                <div class="form-group" style="flex: 1;">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?php old('full_name'); ?>" placeholder="Ebrahim Hanif">
                    <?php showError('full_name'); ?>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control" value="<?php old('student_id'); ?>" placeholder="XX-XXXXX-X">
                    <?php showError('student_id'); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" value="<?php old('email'); ?>" placeholder="student@university.edu">
                <?php showError('email'); ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="passInput" class="form-control" placeholder="Create password">
                <img src="../images/eye-open.png" class="toggle-password" onclick="togglePass('passInput', this)">
                <?php showError('password'); ?>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirmInput" class="form-control" placeholder="Confirm password">
                <img src="../images/eye-open.png" class="toggle-password" onclick="togglePass('confirmInput', this)">
                <?php showError('confirm_password'); ?>
            </div>

            <button type="submit" class="btn-reg">Register</button>
        </form>
        <!---------------- end of form -------------->

        <div class="link-text">
            Already have an ID? <a href="login.php">Login here</a>
        </div>
    </div>

    <script>
        // --------------function for hide-visible password--------
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
// Clear errors after displaying them so they don't show up on refresh
unset($_SESSION['errors']);
unset($_SESSION['old_data']);
?>