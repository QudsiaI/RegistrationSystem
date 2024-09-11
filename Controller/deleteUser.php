<?php
include '../Controller/checkSession.php'; 
include '../Controller/ini_db.php';
require_once '../models/User.php';

// header('Content-Type: application/json');

$user = new User($conn);
$result_array = [];

if (isset($_POST['u_id'])) { 
    $id = $_POST['u_id']; 
    
    if ($user->deleteFromId($id)) { 
        echo json_encode(['success' => true]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user']); 
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID not provided']); 
}
// header("Location: ../view/adminUserData.php");
// exit();
?>
