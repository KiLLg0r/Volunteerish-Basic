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
        <div class="change">
            <h3>Change your address</h3>
            <p>If you moved you can easy change your address from your profile</p>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
            <?php } ?>

            <form action="./acc.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">

                <label for="">Enter your new address</label>
                <div class="input">
                    <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                    <input type="text" name="address" placeholder="Enter your new address..." />
                </div>

                <label for="">Enter your new postcode</label>
                <div class="input">
                    <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                    <input type="text" name="postcode" placeholder="Enter your new postcode..." />
                </div>
                <button type="submit" id="btn">Save your changes</button>
            </form>
        </div>
    </body>
    <script src=" https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="../js/loading.js"></script>

    </html>

<?php
} else {
    header('Location: login.php');
    die();
}
?>