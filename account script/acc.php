<?php

session_start();

include "../php/db.php";

$id = $_GET['id'];
$user = "SELECT * FROM user WHERE id = '$id'";
$userResult = mysqli_query($db, $user);
if (mysqli_num_rows($userResult) === 1)
    $userRow = mysqli_fetch_assoc($userResult);

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['firstname']) && isset($_POST['lastname'])) {

    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);

    if ($firstname == '') $firstname = $userRow['firstname'];
    if ($lastname == '') $lastname = $userRow['lastname'];

    $update = "UPDATE user SET firstname = '$firstname', lastname = '$lastname' WHERE id = '$id'";
    $updateResult = mysqli_query($db, $update);

    if ($updateResult) {
        header('location: ../account.php?success=You changed your name successfully!');
        die();
    } else {
        header('location: ../account.php?error=An error occurred and the data could not be updated!');
        die();
    }
}

if (isset($_POST['oemail']) && isset($_POST['nemail'])) {
    $oemail = validate($_POST['oemail']);
    $nemail = validate($_POST['nemail']);

    if ($oemail == '') {
        header('location: ./email.php?error=You must introduce your old email!');
        die();
    }
    if ($nemail == '') $nemail = $userRow['email'];
    else if ($nemail == $userRow['email']) {
        header('location: ./email.php?error=Your new email is same as your old email!');
        die();
    }

    if ($oemail == $userRow['email']) {
        $update = "UPDATE user SET email = '$nemail' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $update);

        if ($updateResult) {
            header('location: ../account.php?success=You changed your email successfully!');
            die();
        } else {
            header('location: ../account.php?error=An error occurred and the data could not be updated!');
            die();
        }
    } else {
        header('location: ../account.php?error=Your old email is incorect!');
        die();
    }
}

if (isset($_POST['birth'])) {
    $birth = validate($_POST['birth']);

    if ($birth == '') {
        header('location: ./bdate.php?error=You must introduce a date');
        die();
    } else {
        $update = "UPDATE user SET birth = '$birth' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $update);

        if ($updateResult) {
            header('location: ../account.php?success=You changed your birthdate successfully!');
            die();
        } else {
            header('location: ../account.php?error=An error occurred and the data could not be updated!');
            die();
        }
    }
}

if (isset($_POST['country']) && isset($_POST['state']) && isset($_POST['city'])) {
    $country = validate($_POST['country']);
    $state = validate($_POST['state']);
    $city = validate($_POST['city']);

    if ($country == '') {
        header('location: ./location.php?error=You must introduce a country!');
        die();
    } else if ($state == '') {
        header('location: ./location.php?error=You must introduce a state!');
        die();
    } else if ($city == '') {
        header('location: ./location.php?error=You must introduce a city!');
        die();
    } else {
        $update = "UPDATE user SET country = '$country', state = '$state', city = '$city' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $update);

        if ($updateResult) {
            header('location: ../account.php?success=You changed your location successfully!');
            die();
        } else {
            header('location: ../account.php?error=An error occurred and the data could not be updated!');
            die();
        }
    }
}

if (isset($_POST['address']) && isset($_POST['postcode'])) {

    $address = validate($_POST['address']);
    $postcode = validate($_POST['postcode']);

    if ($address == '') {
        header('location: ./address.php?error=You must to introduce an address!');
        die();
    } else if ($postcode == '') {
        header('location: ./address.php?error=You must to introduce a postcode!');
        die();
    }

    $update = "UPDATE user SET address = '$address', postcode = '$postcode' WHERE id = '$id'";
    $updateResult = mysqli_query($db, $update);

    if ($updateResult) {
        header('location: ../account.php?success=You changed your address successfully!');
        die();
    } else {
        header('location: ../account.php?error=An error occurred and the data could not be updated!');
        die();
    }
}

if (isset($_POST['ophone']) && isset($_POST['nphone'])) {
    $ophone = validate($_POST['ophone']);
    $nphone = validate($_POST['nphone']);

    if ($ophone == '') {
        header('location: ./phone.php?error=You must introduce your old phone number!');
        die();
    }
    if ($nphone == '') {
        header('location: ./phone.php?error=You must introduce your new phone number!');
        die();
    } else if ($nphone == $userRow['phone']) {
        header('location: ./phone.php?error=Your new phone number is same as your old phone number!');
        die();
    }

    if ($ophone == $userRow['phone']) {
        $update = "UPDATE user SET phone = '$nphone' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $update);

        if ($updateResult) {
            header('location: ../account.php?success=You changed your phone number successfully!');
            die();
        } else {
            header('location: ../account.php?error=An error occurred and the data could not be updated!');
            die();
        }
    } else {
        header('location: ../account.php?error=Your old phone number is incorect!');
        die();
    }
}

if (isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email'])) {
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['confirm_password']);
    $email = validate($_POST['email']);

    $userData = 'email=' . $email;

    if ($email == '') {
        header('location: ./password.php?error=You must introduce your email!');
        die();
    } else if ($password == '') {
        header("location: ./password.php?error=You must introduce your new password!&$userData");
        die();
    } else if ($confirm_password == '') {
        header("location: ./password.php?error=You must introduce your password twice!&$userData");
        die();
    } else if ($email != $userRow['email']) {
        header('location: ./password.php?error=Your entered enail do not match with your email!');
        die();
    } else if ($password == $userRow['password']) {
        header("location: ./password.php?error=Your new password cannot be same as your old!&$userData");
        die();
    } else if ($password == $confirm_password) {
        $update = "UPDATE user SET password = '$password' WHERE id = '$id'";
        $updateResult = mysqli_query($db, $update);

        if ($updateResult) {
            header('location: ../account.php?success=You changed your password successfully!');
            die();
        } else {
            header('location: ../account.php?error=An error occurred and the data could not be updated!');
            die();
        }
    } else {
        header('location: ../account.php?error=Your passwords do not match!');
        die();
    }
}
