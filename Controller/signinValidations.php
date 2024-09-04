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
        header("Location: ../view/signinForm.php?error=Email+is+Required");
        exit();
        $valid = false;
    } else {
        $email = $user->sanitizeData($_POST['Email']);
        // Regex validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailErr'] = "Invalid email format";
            header("Location: ../view/signinForm.php?error=Invalid+email+format");
            exit();
            $valid = false;
        }
    }
    if (empty($_POST['Password'])) {
        $_SESSION['passErr'] = "Password is Required";
        header("Location: ../view/signinForm.php?error=Password+is+Required");        
        exit();
        $valid = false;
    } else {
        $pass = $user->sanitizeData($_POST['Password']);
    }
    
    if($valid){
        $user->signin($email,$pass);
    }
}
?>