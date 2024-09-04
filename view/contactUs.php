<?php
include "../Controller/checkSession.php";
include "../Controller/ini_db.php";
include "../Controller/contactUsValidations.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Styling/style.css">
</head>
<body>
    <?php include "navigation/userNavbar.php";?>
    <!-- Sidebar -->
    <div class="sidebar">
        <?php include "navigation/userSideNav.php";?>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Contact Us Form -->
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <h2 class="text-center">Contact Us</h2>
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Your message has been received.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username" placeholder="Enter your username" value="<?php echo $name;?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email address</label>
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter your email" value="<?php echo $email;?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Enter your message"><?php echo isset($message) ? $message : ''; ?></textarea>
                            <small class="text-danger"><?php echo $messageErr; ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        <?php if ($success): ?>
            // Clear the textarea after the form is submitted successfully
            document.getElementById("message").value = "";
            <?php endif; ?>
            </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
