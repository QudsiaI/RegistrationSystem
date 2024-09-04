<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  .navbar .dropdown-toggle::after {
    display: none; 
  }
  .dropdown-menu {
    position: absolute;
    right: 0; 
    left: auto; 
    width: auto; 
    max-width: 200px; 
  }
</style>
<?php
include "../Controller/getProfilePic.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Make sure $conn is valid
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch profile picture
$profilePicPath = getProfilePic($conn, $_SESSION['email']); // Use email to get the profile picture
// echo $profilePicPath;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="Home.php">
    Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i> <!-- Menu icon -->
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <!-- Profile picture instead of icon -->
          <img src="<?php echo htmlspecialchars($profilePicPath); ?>" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="updateUser.php">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../Controller/logout.php">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.11/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>