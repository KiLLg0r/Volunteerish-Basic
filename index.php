<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['status'] == 'Volunteer') {
        header('location: ./volunteer/home.php');
        exit();
    } else if ($_SESSION['status'] == 'Needy person') {
        header('location: ./needy/home.php');
        exit();
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Redirecting page</title>
    </head>

    <body>
    </body>

    </html>
<?php } else {
    header('Location: ./login.php');
    die();
}
?>