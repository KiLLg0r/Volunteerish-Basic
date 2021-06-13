<?php

session_start();

include "db.php";

$annID = $_GET['annID'];
$sql = "UPDATE ann SET status = 'active', volunteerID = NULL WHERE id = '$annID'";
$result = $db->query($sql);
if ($result) {
    header('Location: ../volunteer/home.php?success=You are not helping this person anymore!');
    exit();
} else {
    header('Location: ../volunteer/home.php?error=Error!');
    exit();
}
