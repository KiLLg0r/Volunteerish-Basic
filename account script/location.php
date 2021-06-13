<?php
session_start();

if (isset($_SESSION['id'])) {
    include "../php/db.php";
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM user WHERE id='$id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) === 1)
        $user = mysqli_fetch_assoc($result);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/account.css">
        <link rel="stylesheet" href="../css/loading.css">
        <title>Account</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="go-back"><?php if ($user['status'] == 'Volunteer') { ?>
                <a href="../account.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } else if ($user['status'] == 'Needy person') { ?>
                <a href="../account.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } ?>
        </div>

        <?php
        include "../php/db.php";
        include_once "../php/common.php";
        $common = new Common();
        $countries = $common->getCountry($db); ?>

        <div class="change">
            <h3>Change your location</h3>
            <p>If you moved you can easy change your location from your profile</p>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>

            <form action="./acc.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                <label for="country">Country</span></label>
                <div class="input">
                    <img src="https://s2.svgbox.net/hero-solid.svg?ic=flag&color=ff0000" width="40" height="40" />
                    <select name="country" id="countryId" class="dropdown" onchange="getStateByCountry();">
                        <option value="" style="font-style: italic">Select country...</option>
                        <?php
                        if ($countries->num_rows > 0) {
                            while ($country = $countries->fetch_object()) {  ?>
                                <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                        <?php }
                        }
                        ?>
                    </select>
                </div>

                <label for="state">State</label>
                <div class="input">
                    <img src="https://s2.svgbox.net/hero-solid.svg?ic=map&color=ff0000" width="40" height="40" />
                    <select class="dropdown" name="state" id="stateId" onchange="getCityByState();">
                        <option value="" style="font-style: italic">Select state...</option>
                    </select>
                </div>

                <label for="city">City</span></label>
                <div class="input">
                    <img src="https://s2.svgbox.net/hero-solid.svg?ic=office-building&color=ff0000" width="40" height="40" />
                    <select class="dropdown" name="city" id="cityDiv">
                        <option value="" style="font-style: italic">Select city...</option>
                    </select>
                </div>
                <button type="submit" id="btn">Save your changes</button>
            </form>
        </div>
    </body>
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="../js/loading.js"></script>
    <script src="../js/dropdown.js"></script>
    <script>
        function getStateByCountry() {
            var countryId = $("#countryId").val();
            $.post("../php/ajax.php", {
                getStateByCountry: "getStateByCountry",
                countryId: countryId
            }, function(response) {
                var data = response.split("^");
                $("#stateId").html(data[1]);
            });
        }

        function getCityByState() {
            var stateId = $("#stateId").val();
            $.post("../php/ajax.php", {
                getCityByState: "getCityByState",
                stateId: stateId
            }, function(response) {
                var data = response.split("^");
                $("#cityDiv").html(data[1]);
            });
        }
    </script>

    </html>

<?php
} else {
    header('Location: login.php');
    die();
}
?>