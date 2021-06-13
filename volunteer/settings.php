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
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
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
        <div class="page-section page-5 active">
            <h3>Settings</h3>
            <div class="account" onclick="location.href='../account.php'">
                <img src="https://s2.svgbox.net/materialui.svg?ic=account_circle&color=41403e" width="32" height="32">
                <p>Account</p>
                <img src="https://s2.svgbox.net/materialui.svg?ic=chevron_right&color=41403e" width="32" height="32">
            </div>
            <div id="line"></div>
            <div class="help-support" onclick="location.href='../help&support.php'">
                <img src="https://s2.svgbox.net/materialui.svg?ic=headset&color=41403e" width="32" height="32">
                <p>Help & Support</p>
                <img src="https://s2.svgbox.net/materialui.svg?ic=chevron_right&color=41403e" width="32" height="32">
            </div>
            <div id="line"></div>
            <div class="about">
                <div class="header">
                    <img src="https://s2.svgbox.net/octicons.svg?ic=question-bold&color=41403e" width="32" height="32">
                    <p>About</p>
                </div>
                <span>Version 1.0.0 Alpha</span>
            </div>
            <div id="line"></div>
            <div class="logout" onclick="location.href='../php/logout.php'">
                <img src="https://s2.svgbox.net/materialui.svg?ic=logout&color=e8594f" width="32" height="32">
                <p>Logout</p>
            </div>
        </div>
        <footer id="btnContainer" class="btn-footer">
            <a class="link link-1" href="./home.php">
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
            <a class="link link-5 active" href="./settings.php">
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