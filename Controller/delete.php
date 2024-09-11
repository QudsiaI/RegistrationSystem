<?php
include '../Controller/checkSession.php';
include '../Controller/ini_db.php';
require_once '../models/User.php';
$user = new User($conn);

if (isset($_POST['u_id'])) {
    $id = $_POST['u_id'];
    
    if ($user->deleteFromId($u_id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID not provided']);
}
?>
<!-- <?php
include '../Controller/checkSession.php';
include '../Controller/ini_db.php';
require_once '../models/User.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// echo $username;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['u_id'])) {
    $user = new User($conn);
    $u_id = intval($_POST['u_id']); // Sanitize input

    if ($user->deleteFromId($u_id)) {
        header("Location: ../view/userDataAdmin.php?msg=User+deleted+successfully");
        exit();
    } else {
        header("Location: ../view/userDataAdmin.php?error=Unable+to+delete+user");
        exit();
    }
} else {
    header("Location: ../view/userDataAdmin.php?error=Invalid+request");
    exit();
}
?> -->
