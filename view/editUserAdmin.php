<?php
include '../Controller/checkSession.php'; 
include '../Controller/ini_db.php'; 
require_once '../models/User.php';         

$conn = new mysqli($servername, $username, $password, $dbname);


// Fetch user ID from the URL
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    // echo $user_id;
    $user = new User($conn);
    $user->getUserData($user_id);
} else {
    die("Invalid request.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    
    if ($user->update($user_id, $name, $email, $role, $status)) {
        header("Location: ../view/userDataAdmin.php?msg=User+updated+successfully");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Styling/style.css" rel="stylesheet">
</head>
<body>
    <?php include "navigation/adminNavBar.php"; ?>
    <div class="sidebar">
        <?php include "navigation/adminSideNav.php";?>
    </div>
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="text-center">Edit User</h2>
            <form method="POST" > 
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user->getName()); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
                </div>
                <!-- <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" readonly>
                </div> -->
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role"  required>
                        <option value="user" <?php echo ($user->getRole() == '0') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($user->getRole() == '1') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" <?php echo ($user->getStatus() == '0') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($user->getStatus() == '1') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="lastmodified">Last Modified</label>
                    <input type="text" class="form-control" id="lastmodified" name="lastmodified" value="<?php echo htmlspecialchars($user->getDate()); ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
