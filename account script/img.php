<?php

session_start();

include "../php/db.php";

$id = $_GET['id'];
$user = "SELECT * FROM user WHERE id = '$id'";
$userResult = mysqli_query($db, $user);
if (mysqli_num_rows($userResult) === 1)
    $userRow = mysqli_fetch_assoc($userResult);

$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);

$image = basename($_FILES["imageUpload"]["name"]);

$update = "UPDATE user SET image = '$image' WHERE id = '$id'";
$updateResult = mysqli_query($db, $update);

if ($updateResult) {
    header('location: ../account.php?success=You changed your profile image successfully!');
    die();
} else {
    header('location: ../account.php?error=An error occurred and the data could not be updated!');
    die();
}
