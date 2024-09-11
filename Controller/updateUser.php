<?php 
include '../Controller/ini_db.php'; 
require_once '../models/User.php';  

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['editUserId'];
    $name = $_POST['name'];
    $email = $_POST['emailEdit'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    
    if ($user->update($user_id, $name, $email, $role, $status)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update user....']); 
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method']); 
}
?>
