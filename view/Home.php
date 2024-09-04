<?php
 include "../Controller/checkSession.php";
 include "../Controller/ini_db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Styling/style.css">

   
</head>
<body>
   <?php
    include "navigation/userNavbar.php";
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <?php include "navigation/userSideNav.php";?>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Your main content goes here -->
        <h1>Welcome to the Dashboard</h1>
    </div>

</body>
</html>