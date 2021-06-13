<?php

session_start();

include "db.php";

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['birth']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['country']) && isset($_POST['state'])  && isset($_POST['city']) && isset($_POST['address']) && isset($_POST['postcode']) && isset($_POST['phone']) && isset($_POST['status'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $firstname = validate($_POST['firstname']);
    $lastname = validate($_POST['lastname']);
    $birth = validate($_POST['birth']);
    $email = validate($_POST['email']);
    $country = validate($_POST['country']);
    $state = validate($_POST['state']);
    $city = validate($_POST['city']);
    $address = validate($_POST['address']);
    $postcode = validate($_POST['postcode']);
    $phone = validate($_POST['phone']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST['confirm_password']);
    $status = validate($_POST['status']);

    $user_data = 'firstname=' . $firstname . '&lastname=' . $lastname . '&birth=' . $birth . '&email=' . $email . '&address=' . $address . '&postcode=' . $postcode . '&phone=' . $phone;

    if (empty($firstname)) {
        header("location: ../register.php?error=First name is required!&$user_data");
        exit();
    } else if (empty($lastname)) {
        header("location: ../register.php?error=Last name is required!&$user_data");
        exit();
    } else if (empty($birth)) {
        header("location: ../register.php?error=Birth dare is required!&$user_data");
        exit();
    } else if (empty($email)) {
        header("location: ../register.php?error=Email is required!&$user_data");
        exit();
    } else if (empty($country)) {
        header("location: ../register.php?error=Country is required!&$user_data");
        exit();
    } else if (empty($state)) {
        header("location: ../register.php?error=State is required!&$user_data");
        exit();
    } else if (empty($city)) {
        header("location: ../register.php?error=Local is required!&$user_data");
        exit();
    } else if (empty($address)) {
        header("location: ../register.php?error=address is required!&$user_data");
        exit();
    } else if (empty($postcode)) {
        header("location: ../register.php?error=Postal code is required!&$user_data");
        exit();
    } else if (empty($phone)) {
        header("location: ../register.php?error=Phone number is required!&$user_data");
        exit();
    } else if (empty($password)) {
        header("location: ../register.php?error=Password is required!&$user_data");
        exit();
    } else if (empty($confirm_password)) {
        header("location: ../register.php?error=You must enter your password twice!&$user_data");
        exit();
    } else if ($password !== $confirm_password) {
        header("location: ../register.php?error=Passwords do not match!&$user_data");
        exit();
    } else if (empty($status)) {
        header("location: ../register.php?error=Status is required!&$user_data");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("location: ../register.php?error=This email is already used!&$user_data");
            exit();
        } else {
            //Save name of city instead of id
            $sql2 = "SELECT * FROM cities WHERE id='$city' AND state_id='$state'";
            $result2 = mysqli_query($db, $sql2);
            if (mysqli_num_rows($result2) === 1) {
                $row = mysqli_fetch_assoc($result2);
                $city = $row['name'];
            }

            //Save name of state instead of id
            $sql3 = "SELECT * FROM states WHERE id='$state' AND country_id='$country'";
            $result3 = mysqli_query($db, $sql3);
            if (mysqli_num_rows($result3) === 1) {
                $row = mysqli_fetch_assoc($result3);
                $state = $row['name'];
            }

            //Save name of country instead of id
            $sql4 = "SELECT * FROM countries WHERE id='$country'";
            $result4 = mysqli_query($db, $sql4);
            if (mysqli_num_rows($result4) === 1) {
                $row = mysqli_fetch_assoc($result4);
                $country = $row['name'];
            }

            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["imageUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

            $image = basename($_FILES["imageUpload"]["name"]);

            //Insert data into user table and create a new account
            $sql5 = "INSERT INTO user(firstname, lastname, birth, email, password, country, state, city, address, postcode, phone, status, image) VALUES('$firstname', '$lastname', '$birth', '$email', '$password', '$country', '$state', '$city', '$address', '$postcode', '$phone', '$status', '$image')";
            $result5 = mysqli_query($db, $sql5);
            if ($result5) {
                header('location: ../login.php?success=Your account has been created successfully!');
                exit();
            } else {
                header("location: ../register.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }
    }
} else {
    header('location: ../register.php?error=Error');
    exit();
}
