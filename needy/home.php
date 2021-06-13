<?php

session_start();

if (isset($_SESSION['id'])) {
    include "../php/db.php";
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) === 1)
        $user = mysqli_fetch_assoc($result);

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
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/needy.css" />
        <link rel="stylesheet" href="../css/navNeedy.css">
        <link rel="stylesheet" href="../css/dropdown.css">
        <link rel="stylesheet" href="../css/card.css">
        <link rel="stylesheet" href="../css/msg-main.css">
        <link rel="stylesheet" href="../css/loading.css">
        <title>Needy person menu</title>
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
            <div class="ann-center">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>

                <h2 id="ann-center">Announce Center</h2>
                <?php
                $ann = "SELECT * FROM ann WHERE userID = '$id'";
                $annResult = mysqli_query($db, $ann);
                if (mysqli_num_rows($annResult) > 0) {
                    $helpingAnn = "SELECT * FROM ann WHERE userID = '$id' AND status = 'helping' ORDER BY id DESC";
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
                                    $volData = userGetData($helpingAnnRow['volunteerID']);
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
                                                    <img src="../uploads/<?= $user['image'] ?>" />
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
                                                <div class="card-helping-by">
                                                    <span>Helping by</span>
                                                    <?= $volData['firstname'] ?> <?= $volData['lastname'] ?>
                                                </div>
                                                <div class="card-msg">
                                                    <span>Description: </span>
                                                    <p><?= $helpingAnnRow['description'] ?></p>
                                                </div>
                                            </div>
                                            <div class="buttons">
                                                <div class="finish"><a href="../php/finish.php?annID=<?= $helpingAnnRow['id'] ?>">Finish</a></div>
                                                <div class="send-msg"><a href="../msg.php?sendID=<?= $id ?>&receiveID=<?= $helpingAnnRow['volunteerID'] ?>">Send message</a></div>
                                                <div class="cancel"><a href="../php/cancel.php?annID=<?= $helpingAnnRow['id'] ?>">Cancel</a></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }
                    $actAnn = "SELECT * FROM ann WHERE userID = '$id' AND status = 'active' ORDER BY id DESC";
                    $actAnnResult = mysqli_query($db, $actAnn);
                    if (mysqli_num_rows($actAnnResult) > 0) {
                    ?>
                        <div class="dropdown">
                            <div onclick="openDropdownActive()" class="dropbtn active">
                                <p>Active announces</p>
                                <img id="dropdown-img-1-active" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=b3884d" width="32" height="32" style="display: block;">
                                <img id="dropdown-img-2-active" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=b3884d" width="32" height="32" style="display: none;">
                            </div>
                            <div id="myDropdown" class="dropdown-content active">
                                <?php while ($actAnnRow = mysqli_fetch_assoc($actAnnResult)) {
                                    include_once "../php/userData.php";
                                    include_once "../php/age.php";
                                    $needyAge = ageCalculator($actAnnRow['userID']);

                                    if ($actAnnRow['dif'] == 0) $annDiff = 'Any';
                                    else if ($actAnnRow['dif'] == 1) $annDiff = 'Easy';
                                    else if ($actAnnRow['dif'] == 2) $annDiff = 'Medium';
                                    else if ($actAnnRow['dif'] == 3) $annDiff = 'Hard';
                                ?>
                                    <div class="card">
                                        <div class="card-row-1">
                                            <div class="card-img">
                                                <center>
                                                    <img src="../uploads/<?= $user['image'] ?>" />
                                                </center>
                                            </div>
                                            <div class="card-info">
                                                <div class="card-name"><?= $actAnnRow['name'] ?></div>
                                                <div class="card-age"><span>Age: </span><?= $needyAge ?></div>
                                                <div class="card-location"><span>Location: </span><?= $actAnnRow['city'] ?>, <?= $actAnnRow['state'] ?>, <?= $actAnnRow['country'] ?></div>
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
                                                    <?= $actAnnRow['type'] ?>
                                                </div>
                                                <div class="card-msg">
                                                    <span>Description: </span>
                                                    <p><?= $actAnnRow['description'] ?></p>
                                                </div>
                                            </div>
                                            <div class="buttons">
                                                <div class="close"><a href="../php/close.php?annID=<?= $actAnnRow['id'] ?>">Close</a></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php
                    }
                    $inAnn = "SELECT * FROM ann WHERE userID = '$id' AND status = 'inactive' ORDER BY id DESC";
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
                                    $volData = userGetData($inAnnRow['volunteerID']);
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
                                                    <img src="../uploads/<?= $user['image'] ?>" />
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
                                                <?php if ($volData['firstname'] != '' && $volData['lastname'] != '') { ?>
                                                    <div class="card-helping-by">
                                                        <span>Helped by</span>
                                                        <?= $volData['firstname'] ?> <?= $volData['lastname'] ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="card-msg">
                                                    <span>Description: </span>
                                                    <p><?= $inAnnRow['description'] ?></p>
                                                </div>
                                            </div>
                                            <div class="buttons">
                                                <div class="activate"><a href="../php/activate.php?annID=<?= $inAnnRow['id'] ?>">Activate</a></div>
                                                <div class="delete"><a href="../php/activate.php?annID=<?= $inAnnRow['id'] ?>">Delete</a></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
        <footer id="btnContainer" class="btn-footer">
            <a class="link link-1 active" href="./home.php">
                <div class="icon">
                    <img src="../img/home.png" width="32" height="32" />
                    <p class="txt">Home</p>
                </div>
            </a>
            <a id="add-link" class="link link-2" href="./ann.php">
                <div class="icon add">
                    <img src="../img/ann.png" width="32" height="32" />
                    <p class="txt">Announces</p>
                </div>
            </a>
            <a class="link link-3" href="./mess.php">
                <div class="icon">
                    <img src="../img/msg.png" width="32" height="32" />
                    <p class="txt">Messages</p>
                </div>
            </a>
            <a class="link link-4" href="./settings.php">
                <div class="icon">
                    <img src="../img/settings.png" width="32" height="32" />
                    <p class="txt">Settings</p>
                </div>
            </a>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.js" integrity="sha512-c08RNGquBScVDxl/Yf50kga+4ZEI/xuqjBxwFUTFjnRn4Zoz1qcd2m5e/E+Pi+2b0O+lwDPz+J9N3ZzHTbnxHA==" crossorigin="anonymous"></script>
        <script src="../js/dropdownmenu.js"></script>
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
    header('Location: ../login.php');
    die();
}
?>