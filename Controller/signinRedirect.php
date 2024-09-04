<?php
$test = "saba";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo "successfully";
}
if(isset($_SESSION["name"]) || isset($_SESSION["email"])) {
    if(isset($_SESSION["role"])){
        if($_SESSION["role"]=="admin"){
            header("Location: ../view/adminHome.php");
        }elseif($_SESSION["role"]=="user"){
            header("Location: ../view/Home.php");
        }
    }else{
        header("Location: ../view/Home.php");
    }
    exit();
}
?>