<?php
session_start();

$emailErr = isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : '';
$passErr = isset($_SESSION['passErr']) ? $_SESSION['passErr'] : '';
unset($_SESSION['emailErr']);
unset($_SESSION['passErr']);

include ("../Controller/signinRedirect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Page</title>
    <!-- Bootstrap CSS -->
    <link href="../Styling/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Sign In Form -->
<div class="row justify-content-center mt-5">
    <div class="col-md-4 form">
        <h2 class="text-center">Sign In</h2>
        <form method="POST" action="../Controller/signinValidations.php">
            <div class="form-group">
                <label for="Email">Email address</label>
                <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter your email" required>
                <small class="text-danger"><?php echo $emailErr; ?></small>
            </div>
            <div class="form-group">
                <label for="Password">Password</label>
                <div class="password-container">
                    <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter new password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i id="password-icon" class="fa fa-eye"></i>
                    </span>
                </div>
                <small class="text-danger"><?php echo $passErr; ?></small>
            </div>
            <button type="submit" class="btn btn-primary btn-block" id="signin" name="signin">Sign In</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="../signupForm.php">Sign up</a></p>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

<script>
    function togglePassword() {
    var passwordField = document.getElementById('Password');
    var passwordIcon = document.getElementById('password-icon');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>
