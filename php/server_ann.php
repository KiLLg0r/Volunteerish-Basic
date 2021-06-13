<?php

session_start();

include "db.php";

if (isset($_POST['userid']) && isset($_POST['name']) && isset($_POST['country']) && isset($_POST['state']) && isset($_POST['city']) && isset($_POST['description']) && isset($_POST['diff']) && isset($_POST['type'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $values = array(
        array("Any", 20, 10, 25, 40),
        array("Groceries", 15, 10, 25, 40),
        array("Shopping", 15, 10, 25, 40),
        array("Cleaning", 20, 20, 35, 50),
        array("Walking", 20, 15, 30, 50),
        array("Cooking", 30, 25, 25, 40),
        array("Paying of bills", 10, 15, 20, 30),
        array("Emotional support", 25, 20, 40, 60),
        array("Physical labour", 30, 40, 50, 80),
        array("Hard work", 30, 40, 50, 80),
        array("School meditations", 30, 40, 50, 60),
    );

    $userID = validate($_POST['userid']);
    $name = validate($_POST['name']);
    $country = validate($_POST['country']);
    $state = validate($_POST['state']);
    $city = validate($_POST['city']);
    $desc = validate($_POST['description']);
    $active = validate('active');
    $ddesc = 'Hello! My name is ' . $name . ', and I need your help. I can`t type here what I need, but I can tell you at the phone. Thank you!';
    $edesc = validate($ddesc);
    $diff = validate($_POST['diff']);
    $type = validate($_POST['type']);

    if ($diff == "Any") {
        $dif = 1;
        $diff = 0;
    } else if ($diff == "Easy") {
        $dif = 2;
        $diff = 1;
    } else if ($diff == "Medium") {
        $dif = 3;
        $diff = 2;
    } else if ($diff == "Hard") {
        $dif = 4;
        $diff = 3;
    }

    if ($type == "Any") $typ = 0;
    else if ($type == "Groceries") $typ = 1;
    else if ($type == "Shopping") $typ = 2;
    else if ($type == "Cleaning") $typ = 3;
    else if ($type == "Walking") $typ = 4;
    else if ($type == "Cooking") $typ = 5;
    else if ($type == "Paying of bills") $typ = 6;
    else if ($type == "Emotional support") $typ = 7;
    else if ($type == "Physical labour") $typ = 8;
    else if ($type == "Hard work") $typ = 9;
    else if ($type == "School meditations") $typ = 10;

    $value = $values[$typ][$dif];

    if (empty($userID)) {
        header('location: ../needy/ann.php?error=Your must introduce an userID!');
        exit();
    } else if (empty($name)) {
        header('location: ../needy/ann.php?error=Name is required!');
        exit();
    } else if (empty($country)) {
        header('location: ../needy/ann.php?error=Country is required!');
        exit();
    } else if (empty($state)) {
        header('location: ../needy/ann.php?error=State is required!');
        exit();
    } else if (empty($city)) {
        header('location: ../needy/ann.php?error=City is required!');
        exit();
    } else if (empty($desc)) {
        $sql = "INSERT INTO ann (userID, name, country, state, city, description, status, dif, type, value) VALUES ('$userID', '$name', '$country', '$state', '$city', '$edesc', '$active', '$diff', '$type', '$value')";
        $result = mysqli_query($db, $sql);
        if ($result) {
            header('location: ../needy/ann.php?success=Your announcement has been posted successfully!');
            exit();
        } else {
            header("location: ../needy/ann.php?error=Unknown error occurred!");
            exit();
        }
    } else {
        $sql2 = "INSERT INTO ann(userID, name, country, state, city, description, status, dif, type, value) VALUES('$userID', '$name', '$country', '$state', '$city', '$desc', '$active', '$diff', '$type', '$value')";
        $result2 = mysqli_query($db, $sql2);
        if ($result2) {
            header('location: ../needy/ann.php?success=Your announcement has been posted successfully!');
            exit();
        } else {
            header("location: ../needy/ann.php?error=Unknown error occurred!");
            exit();
        }
    }
} else {
    header('location: ../needy/ann.php?error=Error');
    exit();
}
