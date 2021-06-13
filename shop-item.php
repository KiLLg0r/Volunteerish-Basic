<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
    $id = $_SESSION['id'];
    $user = "SELECT * FROM user WHERE id='$id'";
    $userResult = mysqli_query($db, $user);
    if (mysqli_num_rows($userResult) === 1) {
        $user = mysqli_fetch_assoc($userResult);
    }

    $productID = $_GET['productID'];
    $product = "SELECT * FROM shop WHERE id='$productID'";
    $result = mysqli_query($db, $product);
    if (mysqli_num_rows($result) === 1) {
        $product = mysqli_fetch_assoc($result);
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
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
        <link rel="stylesheet" href="./css/shop-item.css">
        <link rel="stylesheet" href="./css/loading.css">
        <link rel="stylesheet" href="./css/swiper.css">
        <title>Volunteer menu</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="go-back">
            <a href="./volunteer/shop.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
        </div>
        <div class="shop-card">
            <div class="shop-card-img">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="./img/shop/<?= $product['image'] ?>" /></div>
                        <?php if (!empty($product['image2'])) { ?>
                            <div class="swiper-slide"><img src="./img/shop/<?= $product['image2'] ?>" /></div>
                        <?php }
                        if (!empty($product['image3'])) { ?>
                            <div class="swiper-slide"><img src="./img/shop/<?= $product['image3'] ?>" /></div>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div id="next" class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

            </div>
            <div class="shop-card-title"><?= $product['name'] ?></div>
            <div class="shop-card-price"><?= $product['price'] ?> points</div>
            <div class="shop-card-description"><?= $product['description'] ?></div>
            <?php if ($user['points'] >= $product['price']) { ?>
                <div class="button-shop activated" onclick="location.href='./php/buy.php?userID=<?= $id ?>&price=<?= $product['price'] ?>&name=<?= $product['name'] ?>'">Buy</div>
            <?php } else { ?>
                <div class="button-shop disabled">Not enough points</div>
            <?php } ?>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.js" integrity="sha512-c08RNGquBScVDxl/Yf50kga+4ZEI/xuqjBxwFUTFjnRn4Zoz1qcd2m5e/E+Pi+2b0O+lwDPz+J9N3ZzHTbnxHA==" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script src="./js/loading.js"></script>
        <script>
            const ptr = PullToRefresh.init({
                mainElement: 'body',
                onRefresh() {
                    window.location.reload();
                }
            });

            var swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: '.swiper-pagination',
                },
            });
        </script>
    </body>

    </html>

<?php } else {
    header('Location: login.php');
    die();
}
?>