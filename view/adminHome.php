<?php

include '../Controller/checkSession.php';
include '../Controller/ini_db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Styling/style.css" rel="stylesheet">
    
</head>
<body>
<?php
    include __DIR__."/navigation/adminNavBar.php";
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php";?>
    </div>

        <!-- Main Content -->
    <div class="main-content">
        <!-- Your main content goes here -->
        <h1>Welcome to the Admin Dashboard</h1>
    </div>
</body>
</html>