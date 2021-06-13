<?php
session_start();

if (isset($_SESSION['id'])) {
    include "../php/db.php";
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
    }

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
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/volunteer.css" />
        <link rel="stylesheet" href="../css/msg-main.css">
        <link rel="stylesheet" href="../css/navVolunteer.css">
        <link rel="stylesheet" href="../css/homeVolunteer.css">
        <link rel="stylesheet" href="../css/dropdown.css">
        <link rel="stylesheet" href="../css/card.css">
        <link rel="stylesheet" href="../css/leaderboards.css">
        <link rel="stylesheet" href="../css/shop.css">
        <link rel="stylesheet" href="../css/modal.css">
        <link rel="stylesheet" href="../css/loading.css">
        <title>Volunteer menu</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="page-section page-1 active">
            <div class="head">
                <h1 class="title"></h1>
                <p class="desc"></p>
            </div>
            <div class="profile">
                <h2>Profile</h2>
                <img src="../uploads/<?= $user['image'] ?>" />
                <h3><?= $user['firstname'] ?> <?= $user['lastname'] ?></h3>
                <div class="profile-info">
                    <div class="helped-people">
                        <p class="head">Helped people</p>
                        <p class="down"><?php if ($user['people'] > 1000 && $user['people'] < 999999) {
                                            $people = number_format($user['people'] / 1000, 0, '.', '');
                                            echo $people . 'K';
                                        } else if ($user['people'] > 1000000 && $user['people'] < 999999999) {
                                            $people = number_format($user['people'] / 1000000, 0, '.', '');
                                            echo $people . 'M';
                                        } else if ($user['people'] > 1000000000) {
                                            $people = number_format($user['people'] / 1000000000, 0, '.', '');
                                            echo $people . 'B';
                                        } else {
                                            echo $user['people'];
                                        } ?></p>
                    </div>
                    <div class="points">
                        <p class="head">Points</p>
                        <p class="down"><?php if ($user['points'] > 1000 && $user['points'] < 999999) {
                                            $points = number_format($user['points'] / 1000, 0, '.', '');
                                            echo $points . 'K';
                                        } else if ($user['points'] > 1000000 && $user['points'] < 999999999) {
                                            $points = number_format($user['points'] / 1000000, 0, '.', '');
                                            echo $points . 'M';
                                        } else if ($user['points'] > 1000000000) {
                                            $points = number_format($user['points'] / 1000000000, 0, '.', '');
                                            echo $points . 'B';
                                        } else {
                                            echo $user['points'];
                                        } ?></p>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="ann-center">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <!--Show succes if account was created successfully-->
                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>

                <h2 id="ann-center">Announce Center</h2>
                <?php
                $ann = "SELECT * FROM ann WHERE volunteerID = '$id'";
                $annResult = mysqli_query($db, $ann);
                if (mysqli_num_rows($annResult) > 0) {
                    $helpingAnn = "SELECT * FROM ann WHERE volunteerID = '$id' AND status = 'helping' ORDER BY id DESC";
                    $helpingAnnResult = mysqli_query($db, $helpingAnn);
                    if (mysqli_num_rows($helpingAnnResult) > 0) {
                ?>
                        <div class="dropdown">
                            <div onclick="openDropdownHelping()" class="dropbtn helping">
                                <p>Helping in progress</p>
                                <img id="dropdown-img-1-helping" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=b3884d" width="32" height="32" style="display: none;">
                                <img id="dropdown-img-2-helping" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=b3884d" width="32" height="32" style="display: block;">
                            </div>
                            <div id="myDropdown" class="dropdown-content show helping">
                                <?php while ($helpingAnnRow = mysqli_fetch_assoc($helpingAnnResult)) {
                                    include_once "../php/userData.php";
                                    include_once "../php/age.php";
                                    $needyData = userGetData($helpingAnnRow['userID']);
                                    $needyAge = ageCalculator($helpingAnnRow['userID']);

                                    if ($helpingAnnRow['dif'] == 0) $annDiff = 'Any';
                                    else if ($helpingAnnRow['dif'] == 1) $annDiff = 'Easy';
                                    else if ($helpingAnnRow['dif'] == 2) $annDiff = 'Medium';
                                    else if ($helpingAnnRow['dif'] == 3) $annDiff = 'Hard';
                                ?>
                                    <div class="card">
                                        <div class="card-row-1">
                                            <div class="card-img">
                                                <center>
                                                    <img src="../uploads/<?= $needyData['image'] ?>" />
                                                </center>
                                            </div>
                                            <div class="card-info">
                                                <div class="card-name"><?= $helpingAnnRow['name'] ?></div>
                                                <div class="card-age"><span>Age: </span><?= $needyAge ?></div>
                                                <div class="card-location"><span>Location: </span><?= $helpingAnnRow['city'] ?>, <?= $helpingAnnRow['state'] ?>, <?= $helpingAnnRow['country'] ?></div>
                                            </div>
                                        </div>
                                        <div class="card-row-2">
                                            <div class="card-info-2">
                                                <div class="card-difficulty" style="color: <?= getColor($annDiff) ?>;">
                                                    <span>Difficulty</span>
                                                    <?= $annDiff ?>
                                                </div>
                                                <div class="card-type">
                                                    <span>Type</span>
                                                    <?= $helpingAnnRow['type'] ?>
                                                </div>
                                                <div class="card-msg">
                                                    <span>Description: </span>
                                                    <p><?= $helpingAnnRow['description'] ?></p>
                                                </div>
                                            </div>
                                            <div class="buttons">
                                                <div class="cancel"><a href="../php/cancel.php?annID=<?= $helpingAnnRow['id'] ?>">Cancel</a></div>
                                                <div class="send-msg"><a href="../msg.php?sendID=<?= $id ?>&receiveID=<?= $helpingAnnRow['userID'] ?>">Send message</a></div>
                                                <div class="more-info"><a href="../moreinfo.php?annID=<?= $helpingAnnRow['id'] ?>">More info</a></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }
                    $inAnn = "SELECT * FROM ann WHERE volunteerID = '$id' AND (status = 'inactive' OR status = 'deleted') ORDER BY id DESC";
                    $inAnnResult = mysqli_query($db, $inAnn);
                    if (mysqli_num_rows($inAnnResult) > 0) {
                    ?>
                        <div class="dropdown">
                            <div onclick="openDropdownInactive()" class="dropbtn helped">
                                <p>Inactive or deleted announces</p>
                                <img id="dropdown-img-1-inactive" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=b3884d" width="32" height="32" style="display: block;">
                                <img id="dropdown-img-2-inactive" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=b3884d" width="32" height="32" style="display: none;">
                            </div>
                            <div id="myDropdown" class="dropdown-content inactive">
                                <?php while ($inAnnRow = mysqli_fetch_assoc($inAnnResult)) {
                                    include_once "../php/userData.php";
                                    include_once "../php/age.php";
                                    $needyData = userGetData($inAnnRow['userID']);
                                    $needyAge = ageCalculator($inAnnRow['userID']);

                                    if ($inAnnRow['dif'] == 0) $annDiff = 'Any';
                                    else if ($inAnnRow['dif'] == 1) $annDiff = 'Easy';
                                    else if ($inAnnRow['dif'] == 2) $annDiff = 'Medium';
                                    else if ($inAnnRow['dif'] == 3) $annDiff = 'Hard';
                                ?>
                                    <div class="card">
                                        <div class="card-row-1">
                                            <div class="card-img">
                                                <center>
                                                    <img src="../uploads/<?= $needyData['image'] ?>" />
                                                </center>
                                            </div>
                                            <div class="card-info">
                                                <div class="card-name"><?= $inAnnRow['name'] ?></div>
                                                <div class="card-age"><span>Age: </span><?= $needyAge ?></div>
                                                <div class="card-location"><span>Location: </span><?= $inAnnRow['city'] ?>, <?= $inAnnRow['state'] ?>, <?= $inAnnRow['country'] ?></div>
                                            </div>
                                        </div>
                                        <div class="card-row-2">
                                            <div class="card-info-2">
                                                <div class="card-difficulty" style="color: <?= getColor($annDiff) ?>;">
                                                    <span>Difficulty</span>
                                                    <?= $annDiff ?>
                                                </div>
                                                <div class="card-type">
                                                    <span>Type</span>
                                                    <?= $inAnnRow['type'] ?>
                                                </div>
                                                <div class="card-msg">
                                                    <span>Description: </span>
                                                    <p><?= $inAnnRow['description'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="line"></div>
            <div class="leaderboards">
                <h2 id="ldb">Leaderboards</h2>
                <?php
                $sql = "SELECT * FROM user WHERE status='volunteer' ORDER BY people DESC LIMIT 7";
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
                                <img src="../uploads/<?= $image[1] ?>" />
                            </div>
                            <p><?= $firstname[1] ?> <?= $lastname[1] ?></p>
                            <div class="podium">2</div>
                        </div>
                    <?php } ?>
                    <?php if (0 < $arrLength) { ?>
                        <div id="gold">
                            <div class="circle gold">
                                <img src="../uploads/<?= $image[0] ?>" />
                            </div>
                            <p><?= $firstname[0] ?> <?= $lastname[0] ?></p>
                            <div class="podium">1</div>
                        </div>
                    <?php } ?>
                    <?php if (2 < $arrLength) { ?>
                        <div id="bronze">
                            <div class="circle bronze">
                                <img src="../uploads/<?= $image[2] ?>" />
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
                <div class="btn" onclick="location.href='../leaderboards.php';">
                    <p id="showMore">Show more</p>
                </div>
            </div>
        </div>
        <footer id="btnContainer" class="btn-footer">
            <a class="link link-1 active" href="./home.php">
                <div class="icon">
                    <img src="../img/home.png" width="32" height="32" />
                    <p class="txt">Home</p>
                </div>
            </a>
            <a class="link link-2" href="./ann.php">
                <div class="icon">
                    <img src="../img/ann.png" width="32" height="32" />
                    <p class="txt">Announces</p>
                </div>
            </a>
            <a id="shop-link" class="link link-3" href="./shop.php">
                <div class="icon shop">
                    <img src="../img/shop.png" width="32" height="32" />
                    <p class="txt">Shop</p>
                </div>
            </a>
            <a class="link link-4" href="./mess.php">
                <div class="icon">
                    <img src="../img/msg.png" width="32" height="32" />
                    <p class="txt">Messages</p>
                </div>
            </a>
            <a class="link link-5" href="./settings.php">
                <div class="icon">
                    <img src="../img/settings.png" width="32" height="32" />
                    <p class="txt">Settings</p>
                </div>
            </a>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.js" integrity="sha512-c08RNGquBScVDxl/Yf50kga+4ZEI/xuqjBxwFUTFjnRn4Zoz1qcd2m5e/E+Pi+2b0O+lwDPz+J9N3ZzHTbnxHA==" crossorigin="anonymous"></script>
        <script src="../js/dropdown.js"></script>
        <script src="../js/dropdownmenu.js"></script>
        <script src="../js/modal.js"></script>
        <script src="../js/loading.js"></script>
        <script>
            const ptr = PullToRefresh.init({
                mainElement: 'body',
                onRefresh() {
                    window.location.reload();
                }
            });
        </script>
    </body>

    </html>

<?php } else {
    header('Location: login.php');
    die();
}
?>