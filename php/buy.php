<?php

session_start();

include "./db.php";

$userID = $_GET['userID'];
$price = $_GET['price'];
$name = $_GET['name'];

$user = "SELECT * FROM user WHERE id = '$userID'";
$userResult = mysqli_query($db, $user);
if (mysqli_num_rows($userResult) === 1)
    $userData = mysqli_fetch_assoc($userResult);

$points = $userData['points'] - $price;

$sql = "UPDATE user SET points = '$points' WHERE id = '$userID'";
$result = $db->query($sql);
if ($result) {
    header("Location: ../volunteer/shop.php?success=Congratulations you bought $name!");
    exit();
} else {
    header('Location: ../volunteer/shop.php?error=The item could not be purchased!');
    exit();
}
