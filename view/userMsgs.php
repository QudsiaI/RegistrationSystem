<?php
include_once "../Controller/checkSession.php";
include_once "../models/contact_message.php";
include '../Controller/ini_db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Styling/style.css" rel="stylesheet">
</head>
<body>
    <?php
    include __DIR__."/navigation/userNavBar.php";
    ?>
    <div class="sidebar">
        <?php include "navigation/userSideNav.php";?>
    </div>
    <div class="main-content">
    <div class="container mt-5">
            <h2 class="text-center">My Messages</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $message = new Message($conn);
                        $message->showMessagesToUser($_SESSION['name']);
                    ?>
                </tbody>
            </table>

            <h2 class="text-center">My Replies</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Reply</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $message->getReplies($_SESSION['name']);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>