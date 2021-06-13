<?php

session_start();

include "db.php";

$annID = $_GET['annID'];
$userID = $_GET['userID'];
$sql = "UPDATE ann SET volunteerID = '$userID', status = 'helping' WHERE id = '$annID'";
$result = $db->query($sql);
if ($result) {
    header('Location: ../volunteer/home.php?success=You are now helping a person!');
    exit();
} else {
    header('Location: ../volunteer/home.php?error=Fail!');
    exit();
}
