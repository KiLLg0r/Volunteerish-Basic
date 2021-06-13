<?php

// session start
session_start();

// include db connection
include './db.php';

if (isset($_POST['message'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    date_default_timezone_set('EET');
    $sent_by = validate($_GET['sent_by']);
    $received_by = validate($_GET['received_by']);
    $message = validate($_POST['message']);
    $createdAt = date("Y-m-d H:i:s");

    if ($message != "") {

        $sendMessage = "INSERT INTO messages (sent_by, received_by, message, createdAt) VALUES('$sent_by', '$received_by', '$message', '$createdAt')";
        $sendMessageStatus = mysqli_query($db, $sendMessage);

        if ($sendMessageStatus) {
            header("Location: ../msg.php?sendID=$sent_by&receiveID=$received_by");
            die();
        } else {
            header("Location: ../msg.php?sendID=$sent_by&receiveID=$received_by");
            die();
        }
    } else {
        header("Location: ../msg.php?sendID=$sent_by&receiveID=$received_by");
        die();
    }
}
