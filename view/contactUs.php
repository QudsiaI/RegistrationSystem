<?php
include "../Controller/checkSession.php";
include "../Controller/contactUsValidations.php";

$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$messageErr = isset($_SESSION['messageErr']) ? $_SESSION['messageErr'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Styling/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../js/contactForm.js"></script>
</head>
<body>
    <?php include "navigation/userNavbar.php";?>
    
    <div class="sidebar">
        <?php include "navigation/userSideNav.php";?>
    </div>
    
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <h2 class="text-center">Contact Us</h2>
                    <form method="POST" id="contactForm">
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="Username" name="Username" value="<?php echo htmlspecialchars($name); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email address</label>
                            <input type="email" class="form-control" id="Email" name="Email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" placeholder="Enter your message"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                            <small id="msg-err" class="text-danger"><?php echo htmlspecialchars($messageErr); ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
