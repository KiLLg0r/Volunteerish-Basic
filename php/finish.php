<?php

session_start();

include "db.php";

$annID = $_GET['annID'];
$ann = "SELECT * FROM ann WHERE id = '$annID'";
$annResult = mysqli_query($db, $ann);
if (mysqli_num_rows($annResult) > 0)
    $annRow = mysqli_fetch_assoc($annResult);

$volID = $annRow['volunteerID'];

$user = "SELECT * FROM user WHERE id = '$volID'";
$userResult = mysqli_query($db, $user);
if (mysqli_num_rows($userResult) > 0)
    $userRow = mysqli_fetch_assoc($userResult);

$points = $userRow['points'] + $annRow['value'];
$people = $userRow['people'] + 1;

$sql = "UPDATE user SET points = '$points', people = '$people' WHERE id = '$volID'";
$result = mysqli_query($db, $sql);

$sql2 = "UPDATE ann SET status = 'inactive' WHERE id = '$annID'";
$result2 = mysqli_query($db, $sql2);

if ($result1 && $result2) {
    header('Location: ../needy/home.php?success=Your help announcement has been completed!');
    exit();
} else {
    header('Location: ../needy/home.php?error=Fail!');
    exit();
}

header('location: ../needy.php');
exit();
