<?php
$name = $_SESSION['name'];
$email = $_SESSION['email'];

include_once '../models/contact_message.php';

$messageErr ="";
$message = ""; 
$success = false;
$conn = new mysqli($servername, $username, $password, $dbname);
$msg = new Message($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST['message'])) {
        $messageErr = "Message is Required";
        $valid = false;
    } else {
        $message = $msg->testData($_POST['message']);
        if (!preg_match("/^[a-zA-Z0-9 @.,'\"()]*$/", $message)) {
            $messageErr = "Only letters, spaces, numbers, and special characters (@,.''\"()) are allowed";
            $valid = false;
        }
    }
    if($valid){
        if($msg->addMessage($name, $email, $message)){
            $success = true;
            $message = ""; // Clear the message after success
        }
    }
}


?>