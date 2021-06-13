<?php

session_start();

include "db.php";

$annID = $_GET['annID'];
$sql = "UPDATE ann SET status = 'deleted' WHERE id = '$annID'";
$result = $db->query($sql);
if ($result) {
    header('Location: ../needy/home.php?success=Your announce was deleted!');
    exit();
} else {
    header('Location: ../needy/home.php?error=Error, the announcement could not be deleted!');
    exit();
}
