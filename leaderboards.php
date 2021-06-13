<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/volunteer.css" />
        <link rel="stylesheet" href="./css/navVolunteer.css">
        <link rel="stylesheet" href="./css/homeVolunteer.css">
        <link rel="stylesheet" href="./css/dropdown.css">
        <link rel="stylesheet" href="./css/card.css">
        <link rel="stylesheet" href="./css/leaderboards.css">
        <title>Volunteer menu</title>
    </head>

    <body>
        <div class="go-back"><a href="javascript:history.back()"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a></div>
        <div class="leaderboards">
            <h2 id="ldb">Leaderboards</h2>
            <?php
            $sql = "SELECT * FROM user WHERE status='volunteer' ORDER BY people DESC";
            $result = mysqli_query($db, $sql);
            $ids = array();
            $image = array();
            $people = array();
            $firstname = array();
            $lastname = array();
            if (mysqli_num_rows($result) > 0)
                while ($data = mysqli_fetch_assoc($result)) {
                    $ids[] = $data['id'];
                    $image[] = $data['image'];
                    $people[] = $data['people'];
                    $firstname[] = $data['firstname'];
                    $lastname[] = $data['lastname'];
                }
            $arrLength = count($people);
            $nr = 3;
            $place = 4;
            ?>
            <div class="top-3">
                <?php if (1 < $arrLength) { ?>
                    <div id="silver">
                        <div class="circle silver">
                            <img src="./uploads/<?= $image[1] ?>" />
                        </div>
                        <p><?= $firstname[1] ?> <?= $lastname[1] ?></p>
                        <div class="podium">2</div>
                    </div>
                <?php } ?>
                <?php if (0 < $arrLength) { ?>
                    <div id="gold">
                        <div class="circle gold">
                            <img src="./uploads/<?= $image[0] ?>" />
                        </div>
                        <p><?= $firstname[0] ?> <?= $lastname[0] ?></p>
                        <div class="podium">1</div>
                    </div>
                <?php } ?>
                <?php if (2 < $arrLength) { ?>
                    <div id="bronze">
                        <div class="circle bronze">
                            <img src="./uploads/<?= $image[2] ?>" />
                        </div>
                        <p><?= $firstname[2] ?> <?= $lastname[2] ?></p>
                        <div class="podium">3</div>
                    </div>
                <?php } ?>
            </div>
            <div class="row info">
                <div class="place">Place</div>
                <div class="name">Name</div>
                <div class="points">People helped</div>
            </div>
            <?php if (0 < $arrLength) { ?>
                <div class="row gold">
                    <div class="place">1</div>
                    <div class="name"><?= $firstname[0] ?> <?= $lastname[0] ?></div>
                    <div class="points"><?php if ($people[0] >= 1000 && $people[0] <= 999999) {
                                            $people2 = number_format($people[0] / 1000, 0, '.', '');
                                            echo $people2 . 'K';
                                        } else if ($people[0] >= 1000000 && $people[0] <= 999999999) {
                                            $people2 = number_format($people[0] / 1000000, 0, '.', '');
                                            echo $people2 . 'M';
                                        } else if ($people[0] >= 1000000000) {
                                            $people2 = number_format($people[0] / 1000000000, 0, '.', '');
                                            echo $people2 . 'B';
                                        } else {
                                            echo $people[0];
                                        }
                                        ?></div>
                </div>
            <?php } ?>
            <?php if (1 < $arrLength) { ?>
                <div class="row silver">
                    <div class="place">2</div>
                    <div class="name"><?= $firstname[1] ?> <?= $lastname[1] ?></div>
                    <div class="points"><?php if ($people[1] >= 1000 && $people[1] <= 999999) {
                                            $people2 = number_format($people[1] / 1000, 0, '.', '');
                                            echo $people2 . 'K';
                                        } else if ($people[1] >= 1000000 && $people[1] <= 999999999) {
                                            $people2 = number_format($people[1] / 1000000, 0, '.', '');
                                            echo $people2 . 'M';
                                        } else if ($people[1] >= 1000000000) {
                                            $people2 = number_format($people[1] / 1000000000, 0, '.', '');
                                            echo $people2 . 'B';
                                        } else {
                                            echo $people[1];
                                        }
                                        ?></div>
                </div>
            <?php } ?>
            <?php if (2 < $arrLength) { ?>
                <div class="row bronze">
                    <div class="place">3</div>
                    <div class="name"><?= $firstname[2] ?> <?= $lastname[2] ?></div>
                    <div class="points"><?php if ($people[2] >= 1000 && $people[2] <= 999999) {
                                            $people2 = number_format($people[2] / 1000, 0, '.', '');
                                            echo $people2 . 'K';
                                        } else if ($people[2] >= 1000000 && $people[2] <= 999999999) {
                                            $people2 = number_format($people[2] / 1000000, 0, '.', '');
                                            echo $people2 . 'M';
                                        } else if ($people[2] >= 1000000000) {
                                            $people2 = number_format($people[2] / 1000000000, 0, '.', '');
                                            echo $people2 . 'B';
                                        } else {
                                            echo $people[2];
                                        }
                                        ?></div>
                </div>
            <?php } ?>
            <?php while ($nr < $arrLength) { ?>
                <div class="row">
                    <div class="place"><?= $place ?></div>
                    <div class="name"><?= $firstname[$nr] ?> <?= $lastname[$nr] ?></div>
                    <div class="points"><?php if ($people[$nr] >= 1000 && $people[$nr] <= 999999) {
                                            $people2 = number_format($people[$nr] / 1000, 0, '.', '');
                                            echo $people2 . 'K';
                                        } else if ($people[$nr] >= 1000000 && $people[$nr] <= 999999999) {
                                            $people2 = number_format($people[$nr] / 1000000, 0, '.', '');
                                            echo $people2 . 'M';
                                        } else if ($people[$nr] >= 1000000000) {
                                            $people2 = number_format($people[$nr] / 1000000000, 0, '.', '');
                                            echo $people2 . 'B';
                                        } else {
                                            echo $people[$nr];
                                        } ?></div>
                </div>
            <?php $nr++;
                $place++;
            }
            ?>
        </div>
    </body>

    </html>

<?php } else {
    header('Location: login.php');
    die();
}
?>