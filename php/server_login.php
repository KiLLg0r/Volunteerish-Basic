<?php

session_start();

include "db.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if (empty($email)) {
        header('location: ../login.php?error=Email is required!');
        exit();
    } else if (empty($password)) {
        header('location: ../login.php?error=Password is required!');
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";

        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);
            if ($row['email'] == $email && $row['password'] == $password) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['status'] = $row['status'];
                header('location: ../index.php');
                exit();
            } else if ($row['email'] == $email && $row['password'] !== $password) {
                header('location: ../login.php?error=Incorect password!');
                exit();
            } else {
                header('location: ../login.php?error=Incorect email/password!');
                exit();
            }
        } else {
            header('location: ../login.php?error=Incorect email/password!');
            exit();
        }
    }
} else {
    header('location: ../login.php');
    exit();
}
