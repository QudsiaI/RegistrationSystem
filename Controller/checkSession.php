<?php
session_start();
// if session not set go back to signin page
if (!isset($_SESSION["name"]) || !isset($_SESSION["email"])) {
    header("Location: http://localhost/registration/view/signinForm.php");
    exit();
}
if(isset($_GET['error'])){
    echo "<script>alert('".$_GET['error']."');</script>";
}
if(isset($_GET['msg'])){
    echo "<script>alert('".$_GET['msg']."');</script>";
}
?>