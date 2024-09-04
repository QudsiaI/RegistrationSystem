<?php
 include '../Controller/checkSession.php';
 include '../Controller/ini_db.php';
 include_once '../models/contact_message.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Messages - Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            <h2 class="text-center">User Messages</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $message = new Message($conn);
                        $message->showAllMessages();
                        
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>