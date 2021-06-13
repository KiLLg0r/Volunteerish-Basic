<?php

session_start();

include "db.php";

$annID = $_GET['annID'];
$sql = "UPDATE ann SET status = 'active' WHERE id = '$annID'";
$result = $db->query($sql);
if ($result) {
    header('Location: ../needy/home.php?success=Your announce was activated!');
    exit();
} else {
    header('Location: ../needy/home.php?error=Fail!');
    exit();
}

header('location: ../needy.php');
exit();
