<?php
include_once "../models/contact_message.php";
include '../Controller/ini_db.php';

$msg = new Message($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = true;
    if (empty($_POST['reply'])) {
        $_SESSION['replyErr'] = "Reply is Required";
        $valid = false;
    } else {
        $reply = $msg->testData($_POST['reply']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $reply)) {
            $_SESSION['replyErr'] = "Only letters and spaces allowed";
            $valid = false;
        }
    }
    $msgId = $_POST['msgId'];

    if($msg->sendReply($msgId, $reply)){
        // echo "testing in";
        // exit();
        header ("Location: ../view/messagesAdmin.php?msg=reply+sent");
        exit();
    }else{
        echo "reply not sent :(";
    }
}
?>