<?php
include '../Controller/checkSession.php'; 
include '../Controller/ini_db.php'; 
require_once '../models/contact_message.php';         

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['id'])) {
    $m_id = intval($_GET['id']);
    $message = new Message($conn);
    $message->getMsgData($m_id);
} else {
    die("Invalid request.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <link href="../Styling/style.css" rel="stylesheet">
</head>
<body>
<?php
    include __DIR__."/navigation/adminNavBar.php";
    ?>
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php";?>
    </div>
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="text-center">Message Details</h2>
            <form method="POST" > 
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($message->getName()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($message->getEmail()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="lastmodified">Sent Date</label>
                    <input type="text" class="form-control" id="sentTime" name="sentTime" value="<?php echo htmlspecialchars($message->getTime()); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="lastmodified">Message</label>
                    <textarea  class="form-control" id="msg" name="msg" readonly><?php echo htmlspecialchars($message->getMsg()); ?></textarea>
                </div>
                <!-- <button class="btn btn-primary">Reply</button> -->
            </form>
        </div>
    </div>

</body>
</html>