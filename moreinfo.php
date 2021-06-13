<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
    include_once "./php/userData.php";
    include_once "./php/age.php";
    $id = $_GET['annID'];
    $ann = "SELECT * FROM ann WHERE id = '$id'";
    $annResult = mysqli_query($db, $ann);
    if (mysqli_num_rows($annResult) > 0)
        $annRow = $annResult->fetch_assoc();

    $needyData = userGetData($annRow['userID']);
    $needyAge = ageCalculator($annRow['userID']);

    if ($annRow['dif'] == 0) $annDiff = 'Any';
    else if ($annRow['dif'] == 1) $annDiff = 'Easy';
    else if ($annRow['dif'] == 2) $annDiff = 'Medium';
    else if ($annRow['dif'] == 3) $annDiff = 'Hard';

    function getColor($val)
    {
        if ($val == "Any") {
            return  'var(--dark-grey)';
        } else if ($val == "Easy") {
            return 'green';
        } else if ($val == "Medium") {
            return 'orange';
        } else if ($val == "Hard") {
            return 'red';
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/moreinfo.css">
        <title>More info about the person</title>
    </head>

    <body>
        <div class="go-back"><a href="./volunteer/home.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a></div>
        <div class="more-info-card">
            <div class="image">
                <img src="./uploads/<?= $needyData['image'] ?>">
            </div>
            <div class="name">
                <p><?= $needyData['firstname'] ?> <?= $needyData['lastname'] ?></p>
            </div>
            <div class="age">
                <span>Age</span>
                <p><?= $needyAge ?></p>
            </div>
            <div class="city">
                <span>City</span>
                <p><?= $needyData['city'] ?></p>
            </div>
            <div class="state">
                <span>State</span>
                <p><?= $needyData['state'] ?></p>
            </div>
            <div class="country">
                <span>Country</span>
                <p><?= $needyData['country'] ?></p>
            </div>
            <div class="phone">
                <span>Phone</span>
                <p><?= $needyData['phone'] ?></p>
            </div>
            <div class="address">
                <span>Address</span>
                <p><?= $needyData['address'] ?></p>
            </div>
            <div class="diff">
                <span>Difficulty</span>
                <p style="color: <?= getColor($annDiff) ?>;"><?= $annDiff ?></p>
            </div>
            <div class="type">
                <span>Type</span>
                <p><?= $annRow['type'] ?></p>
            </div>
            <div class="desc">
                <span>Description</span>
                <p><?= $annRow['description'] ?></p>
            </div>
            <div class="map"><iframe width="100%" height="100%" style="border:0; border-radius: 20px" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/place?q='<?= $needyData['address']; ?>+<?= $needyData['postcode']; ?>'&key=AIzaSyBEQK4O4xdWl7fv2hG9hbNIT8SRhSfGxqo"></iframe></div>
        </div>
    </body>

    </html>

<?php } else {
    header('Location: login.php');
    die();
}
?>