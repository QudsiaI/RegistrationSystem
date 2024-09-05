<?php
session_start();

include_once "../models/User.php";
include ("ini_db.php");
// if (!isset($conn)) {
//     die("Database connection failed.");
// }else{
// echo "Connection Host Info: " . $conn->host_info;
// }
$emailErr = $email = $passErr = $pass = "";
$user = new User($conn);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "test";
    $valid = true;
    if (empty($_POST['Email'])) {
        $_SESSION['emailErr'] = "Email is Required";
        $valid = false;
    } else {
        $email = $user->sanitizeData($_POST['Email']);
        // Regex validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailErr'] = "Invalid email format";
            $valid = false;
        }
    }
    if (empty($_POST['Password'])) {
        $_SESSION['passErr'] = "Password is Required";
        $valid = false;
    } else {
        $pass = $user->sanitizeData($_POST['Password']);
    }
    
    if($valid){
        $signinResult = $user->signin($email,$pass);
        if($signinResult !== true){
            header("Location: ../view/signinForm.php");
            exit();
        }
    }else{
        header("Location: ../view/signinForm.php");
        exit();
    }
}
?>