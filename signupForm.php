<?php
session_start();
if(isset($_SESSION['name']) && isset($_SESSION['email'])){
    if(isset($_SESSION["role"])){
        if($_SESSION["role"]=="admin"){
            header("Location: ../view/adminHome.php");
        }elseif($_SESSION["role"]=="user"){
            header("Location: ../view/Home.php");
        }
    }
}
$nameErr = isset($_SESSION['nameErr']) ? $_SESSION['nameErr'] : '';
$emailErr = isset($_SESSION['emailErr']) ? $_SESSION['emailErr'] : '';
$passErr = isset($_SESSION['passErr']) ? $_SESSION['passErr'] : '';
unset($_SESSION['nameErr']);
unset($_SESSION['emailErr']);
unset($_SESSION['passErr']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="Styling/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
        <!-- Sign Up Form -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 form">
                <h2 class="text-center">Sign Up</h2>
                <form method="POST" action="Controller/addUserValidation.php">
                    <div class="form-group">
                        <label for="Username">Username</label>
                        <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter your username">
                        <small class="text-danger" id="nameErr"><?php echo $nameErr; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email address</label>
                        <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter your email">
                        <small class="text-danger" id="emailErr"><?php echo $emailErr; ?></small>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <div class="password-container">
                            <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter your password">
                            <span class="toggle-password" onclick="togglePassword()">
                                <i id="password-icon" class="fa fa-eye"></i>
                            </span>
                        </div>
                        <small class="text-danger" id="passErr"><?php echo $passErr; ?></small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="view/signinForm.php">Sign in</a></p>
            </div>
        </div>

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
