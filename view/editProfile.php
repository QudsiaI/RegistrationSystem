<?php
include "../Controller/editProfileValidations.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="../Styling/style.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include "../view/navigation/adminNavbar.php";
    ?>
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php";?>
    </div>
    <div class="main-content">
        <div class="container">
            <!-- Update User Information Form -->
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <h2 class="text-center">Personal Information</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="<?php echo $name; ?>" placeholder="Enter your username">
                            <small class="text-danger"><?php echo $nameErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email address</label>
                            <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $email; ?>" placeholder="Enter your email">
                            <small class="text-danger"><?php echo $emailErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="Password">New Password (leave blank to keep current)</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter new password">
                                <span class="toggle-password" onclick="togglePassword()">
                                    <i id="password-icon" class="fa fa-eye"></i>
                                </span>
                            </div>
                            <small class="text-danger"><?php echo $passErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="ProfilePic">Profile Picture</label>
                            <input type="file" class="form-control-file" id="profilePic" name="profilePic">
                            <small class="text-danger"><?php echo $picErr; ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update Information</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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