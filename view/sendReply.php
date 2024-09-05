<?php
include_once "../Controller/checkSession.php";
// include_once "../models/contact_message.php";
include '../Controller/ini_db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Reply - Admin Panel</title>
    <link href="../Styling/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include __DIR__."/navigation/adminNavBar.php";
    ?>
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php";?>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 form">
                    <form action="../Controller/sendReply.php" method="POST">
                        <h2>Your Reply</h2>
                        <div class="form-group">
                            <textarea class="form-control" id="reply" name="reply" placeholder="Enter reply" rows="8" required></textarea>
                        </div>
                        <input type="hidden" id="msgId" name="msgId" value="<?php echo $_GET['id']; ?>">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>