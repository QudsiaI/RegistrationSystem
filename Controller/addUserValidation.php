<?php
session_start();

include_once "../models/User.php";
include ("ini_db.php");
$nameErr = $name = $emailErr = $email = $passErr = $pass = "";
$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;

    if (empty($_POST['Username'])) {
        $_SESSION['nameErr'] = "Name is Required";
        // exit();
        $valid = false;
    } else {
        $name = $user->sanitizeData($_POST['Username']);
        // Regex validation
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $_SESSION['nameErr'] = "Invalid name format";
            $valid = false;
        }
    }

    if (empty($_POST['Email'])) {
        $_SESSION['emailErr'] = "Email is Required";
        $valid = false;
    } else {
        $email = $user->sanitizeData($_POST['Email']);
        // Email validation
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

    if ($valid) {
        $user->create($name, $email, $pass);

        if (isset($_POST['isAdmin'])) {
            header("Location: ../view/userDataAdmin.php");
            exit();
        } else {
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            header("Location: ../view/Home.php");
            exit();
        }
        
    }
}

?>