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
                    <input type="text" name="full_name" class="form-control" placeholder="Ebrahim Hanif" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control" placeholder="XX-XXXXX-X" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="xx-xxxxx-x@student.aiub.edu" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="passInput" class="form-control" placeholder="Create password" required>
                <img src="../images/eye-open.png" class="toggle-password" onclick="togglePass('passInput', this)">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirmInput" class="form-control" placeholder="Confirm password" required>
                <img src="../images/eye-open.png" class="toggle-password" onclick="togglePass('confirmInput', this)">
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