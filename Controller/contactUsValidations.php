<?php
include "../Controller/ini_db.php";
include_once "../Controller/checkSession.php";
include_once '../models/contact_message.php';

$name = $_SESSION['name'];
$email = $_SESSION['email'];

$msg = new Message($conn);
$errors = [];
$data = [];

// Validate the message field
if (empty($_POST['message'])) {
    $errors['message'] = 'Message is required.';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $message = htmlspecialchars($_POST['message']);
    if ($msg->addMessage($name, $email, $message)) {
        $data['success'] = true;
        $data['message'] = 'Your message has been successfully sent!';
    } else {
        $data['success'] = false;
        $data['message'] = 'There was an error saving your message. Please try again.';
    }
}

// echo json_encode($data);
?>
