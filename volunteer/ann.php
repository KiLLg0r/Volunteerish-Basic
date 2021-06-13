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
    $country = $user['country'];
    $state = $user['state'];
    $city = $user['city'];

    $countries = "SELECT * FROM countries WHERE name = '$country'";
    $countriesResult = mysqli_query($db, $countries);
    if (mysqli_num_rows($countriesResult) === 1) {
        $countryRow = mysqli_fetch_assoc($countriesResult);
        $countryID = $countryRow['id'];
    }

    $states = "SELECT * FROM states WHERE name = '$state' AND country_id = '$countryID'";
    $statesResult = mysqli_query($db, $states);
    if (mysqli_num_rows($statesResult) === 1) {
        $stateRow = mysqli_fetch_assoc($statesResult);
        $stateID = $stateRow['id'];
    }

    $cities = "SELECT * FROM cities WHERE name = '$city' AND state_id = '$stateID'";
    $citiesResult = mysqli_query($db, $cities);
    if (mysqli_num_rows($citiesResult) === 1) {
        $citiesRow = mysqli_fetch_assoc($citiesResult);
        $cityID = $citiesRow['id'];
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

    <style>
        .card {
            margin: 20px auto;
        }
    </style>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="page-section page-2 active">
            <div class="ann">
                <div class="head">
                    <h3>People's announces</h3>
                    <p>Below are the announces of people in need of help. You can choose which person to help or you can try to help as many as possible!</p>
                </div>

                <?php
                include "../php/db.php";
                include_once "../php/common.php";
                $common = new Common();
                $countries = $common->getCountry($db);
                ?>

                <div class="dropdown">
                    <div onclick="openDropdownFilter()" class="dropbtn filter">
                        <img src="https://s2.svgbox.net/materialui.svg?ic=filter_alt&color=41403e" width="30" height="30">
                        <p>Filter</p>
                        <img id="dropdown-img-1-filter" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=41403e" width="30" height="30" style="display: block;">
                        <img id="dropdown-img-2-filter" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=41403e" width="30" height="30" style="display: none;">
                    </div>
                    <div id="myDropdown" class="dropdown-content filter">
                        <div class="filter-content">
                            <label for="country">Country: </label>
                            <select name="country" id="countryId" class="dropdown2" onchange="getStateByCountry();">
                                <option value="<?= $countryID ?>"><?= $user['country'] ?></option>
                                <?php
                                if ($countries->num_rows > 0) {
                                    while ($country = $countries->fetch_object()) {  ?>
                                        <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>

                        <div class="filter-content">
                            <label for="state">State: </label>
                            <select class="dropdown2" name="state" id="stateId" onchange="getCityByState();">
                                <option value="<?= $stateID ?>"><?= $user['state'] ?></option>
                                <?php
                                $states2 = "SELECT * FROM states WHERE country_id = '$countryID'";
                                $statesResult2 = mysqli_query($db, $states2);
                                if (mysqli_num_rows($statesResult2) > 0)
                                    while ($stateRow2 = mysqli_fetch_assoc($statesResult2)) {
                                ?>
                                    <option value="<?= $stateRow2['id'] ?>"><?= $stateRow2['name']  ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="filter-content">
                            <label for="city">City: </label>
                            <select class="dropdown2" name="city" id="cityDiv">
                                <option value="<?= $cityID ?>"><?= $user['city'] ?></option>
                                <?php
                                $cities2 = "SELECT * FROM cities WHERE state_id = '$stateID'";
                                $citiesResult2 = mysqli_query($db, $cities2);
                                if (mysqli_num_rows($citiesResult2) > 0)
                                    while ($citiesRow2 = mysqli_fetch_assoc($citiesResult2)) {
                                ?>
                                    <option value="<?= $citiesRow2['id'] ?>"><?= $citiesRow2['name']  ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="filter-content">
                            <label for="">Difficulty</label>
                            <select class="dropdown2" name="diff" id="diff">
                                <option value="Any">Any</option>
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>

                        <div class="filter-content">
                            <label for="">Type of announce</label>
                            <select class="dropdown2" name="type" id="type">
                                <option value="Any">Any</option>
                                <option value="School meditations">School meditations</option>
                                <option value="Groceries">Groceries</option>
                                <option value="Shopping">Shopping</option>
                                <option value="Cleaning">Cleaning</option>
                                <option value="Walking">Walking</option>
                                <option value="Cooking">Cooking</option>
                                <option value="Payment of bills">Payment of bills</option>
                                <option value="Emotional support">Emotional support</option>
                                <option value="Physical labour">Physical labour</option>
                                <option value="Hard work">Hard work</option>
                            </select>
                        </div>

                        <div class="filter-content">
                            <label for="">Sort by</label>
                            <select class="dropdown2" name="sort" id="sort">
                                <option value="recents">Recents</option>
                                <option value="oldest">Oldest</option>
                                <option value="ascdif">Difficulty Ascending</option>
                                <option value="descdif">Difficulty Descending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="anns"></div>
            </div>
        </div>
        <footer id="btnContainer" class="btn-footer">
            <a class="link link-1" href="./home.php">
                <div class="icon">
                    <img src="../img/home.png" width="32" height="32" />
                    <p class="txt">Home</p>
                </div>
            </a>
            <a class="link link-2 active" href="./ann.php">
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

            $(document).ready(function() {
                $('select#diff').change(function() {
                    if ($('select#diff').children("option:selected").val() == 'Easy') {
                        $('select#diff').css({
                            'color': 'white',
                            'background': 'green',
                            'background-clip': 'border-box',
                            '-webkit-text-fill-color': 'white'
                        });
                    } else if ($('select#diff').children("option:selected").val() == 'Medium') {
                        $('select#diff').css({
                            'background': 'orange',
                            'color': 'white',
                            'background-clip': 'border-box',
                            '-webkit-text-fill-color': 'white'
                        });
                    } else if ($('select#diff').children("option:selected").val() == 'Hard') {
                        $('select#diff').css({
                            'background': 'red',
                            'color': 'white',
                            'background-clip': 'border-box',
                            '-webkit-text-fill-color': 'white'
                        });
                    } else if ($('select#diff').children("option:selected").val() == 'Any') {
                        $('select#diff').css({
                            'background': 'var(--gradient)',
                            '-webkit-background-clip': 'text',
                            'background-clip': 'text',
                            '-webkit-text-fill-color': 'transparent',
                        });
                    }
                });

                filter_data();

                function filter_data() {
                    var action = 'fetch_data';
                    var country = $('select#countryId').children("option:selected").val();
                    var state = $('select#stateId').children("option:selected").val();
                    var city = $('select#cityDiv').children("option:selected").val();
                    var diff = $('select#diff').children("option:selected").val();
                    var type = $('select#type').children("option:selected").val();
                    var sort = $('select#sort').children("option:selected").val();

                    $.ajax({
                        url: "../php/filter.php",
                        method: "POST",
                        data: {
                            action: action,
                            country: country,
                            state: state,
                            city: city,
                            diff: diff,
                            type: type,
                            sort: sort
                        },
                        success: function(data) {
                            $('.anns').html(data);
                        }
                    });
                }

                $('select').change(function() {
                    filter_data();
                });
            });
        </script>
    </body>

    </html>

<?php } else {
    header('Location: login.php');
    die();
}
?>