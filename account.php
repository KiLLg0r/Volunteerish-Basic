<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
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
        <link rel="stylesheet" href="./css/account.css">
        <link rel="stylesheet" href="./css/loading.css">
        <title>Account</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="go-back"><?php if ($user['status'] == 'Volunteer') { ?>
                <a href="./volunteer/settings.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } else if ($user['status'] == 'Needy person') { ?>
                <a href="./needy/settings.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } ?>
        </div>
        <h3 id="acc">Account</h3>
        <div class="acc">
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>


            <form id="acc-form" action="./account script/img.php?id=<?= $id ?>" class="acc-center" method="POST" enctype="multipart/form-data">
                <center class="img-upload">
                    <div class="img-placeholder">
                        <img src="./uploads/<?= $user['image'] ?>" id="img-placeholder" height="100" width="100">
                    </div>
                    <input type="file" name="imageUpload" onchange="loadFile(event)" id="imageUpload" accept="image/*" style="display: none;" />
                    <label for="file" id="imgLabel" style="cursor: pointer;">Change picture</label>
                </center>

                <div class="label-row" onclick="location.href='./account script/name.php'">
                    <p id="label">Name</p>
                    <p id="value"><?= $user['firstname'] ?> <?= $user['lastname'] ?></p>
                </div>

                <div class="label-row" onclick="location.href='./account script/email.php'">
                    <p id="label">Email</p>
                    <p id="value"><?= $user['email']; ?></p>
                </div>

                <div class="label-row" onclick="location.href='./account script/bdate.php'">
                    <p id="label">Birthdate</p>
                    <p id="value"><?= $user['birth']; ?></p>
                </div>

                <div class="label-row" onclick="location.href='./account script/location.php'">
                    <p id="label">Location</p>
                    <p id="value"><?= $user['city']; ?>, <?= $user['state']; ?>, <?= $user['country']; ?> </p>
                </div>

                <div class="label-row" onclick="location.href='./account script/address.php'">
                    <p id="label">Address</p>
                    <p id="value"><?= $user['address']; ?></p>
                </div>

                <div class="label-row" onclick="location.href='./account script/phone.php'">
                    <p id="label">Phone</p>
                    <p id="value"><?= $user['phone']; ?></p>
                </div>

                <div class="label-row" onclick="location.href='./account script/password.php'">
                    <p id="label">Password</p>
                    <p id="value"></p>
                </div>

                <button style="display: none" type="submit" id="btn" form="acc-form" value="Submit">Save changes</button>
            </form>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="./js/dropdown.js"></script>
    <script src="./js/reg-img.js"></script>
    <script src="./js/loading.js"></script>
    <script>
        function checkImg() {
            if ($('.img-placeholder img').attr('src') == './uploads/<?php echo $user['image'] ?>')
                $('#btn').css('display', 'none');
            else
                $('#btn').css('display', 'block');
        }
        setInterval(checkImg, 1000);
    </script>

    </html>

<?php
} else {
    header('Location: login.php');
    die();
}
?>