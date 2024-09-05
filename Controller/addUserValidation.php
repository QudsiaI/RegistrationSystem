<?php
session_start();

include_once "../models/User.php";
include ("ini_db.php");
$nameErr = $name = $emailErr = $email = $passErr = $pass = "";
// $error = "";
$user = new User($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST['Username'])) {
        $_SESSION['nameErr'] = "Name is Required";
        // $error = $_SESSION['nameErr'];
        $valid = false;
    } else {
        $name = $user->sanitizeData($_POST['Username']);
        // Regex validation
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $_SESSION['nameErr'] = "Invalid name format";
            // $error = $_SESSION['nameErr'];
            $valid = false;
        }
    }

    if (empty($_POST['Email'])) {
        $_SESSION['emailErr'] = "Email is Required";
        // $error = $error." ".$_SESSION['emailErr'];
        $valid = false;
    } else {
        $email = $user->sanitizeData($_POST['Email']);
        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['emailErr'] = "Invalid email format";
            // $error = $error." ".$_SESSION['emailErr'];
            $valid = false;
        }
    }

    if (empty($_POST['Password'])) {
        $_SESSION['passErr'] = "Password is Required";
        // $error = $error." ".$_SESSION['passErr'];
        $valid = false;
    } else {
        $pass = $user->sanitizeData($_POST['Password']);
    }

    if ($valid) {
        $createUserResult = $user->create($name, $email, $pass);

        if ($createUserResult === true) {
            if (isset($_POST['fromAdmin'])) {
                header("Location: ../view/userDataAdmin.php");
                exit();
            } else {
                $_SESSION["name"] = $name;
                $_SESSION["email"] = $email;
                header("Location: ../view/Home.php");
                exit();
            }
        }elseif($createUserResult="email_exists"){
            $_SESSION['emailErr'] = "Email already exists";
            // $error = $error." ".$_SESSION['emailErr'];
            if (isset($_POST['fromAdmin'])) {
                header("Location: ../view/userDataAdmin.php");
                exit();
            } else {
                header("Location: ../signupForm.php");
                exit();
            }
        }   
    }else{
        if (isset($_POST['fromAdmin'])) {
            header("Location: ../view/userDataAdmin.php");
            exit();
        } else {
            header("Location: ../signupForm.php");
            exit();
        }
    }
}

?>