<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/login.css" />
    <link rel="stylesheet" href="./css/loading.css">
    <title>Login</title>
</head>

<body>
    <div class="loading">
        <div class="spinner"></div>
    </div>
    <div class="icon"></div>
    <div class="login">
        <form action="./php/server_login.php" method="post">
            <h3>
                <p><span style="color: #ff0000">Log in </span>into your <span style="color: #ff0000"> Volunteerish </span>account</p>
            </h3>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <label for="">Email</label>
            <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=mail&color=ff0000" width="40" height="40" />
                <input type="email" name="email" placeholder="Enter your email..." />
            </div>

            <label for="">Password</label>
            <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=lock-closed&color=ff0000" width="40" height="40" />
                <input type="password" name="password" placeholder="Enter your password..." id="password" class="password" />
                <img id="passImg" src="https://s2.svgbox.net/hero-solid.svg?ic=eye&color=ff0000" width="40" height="40" onclick="showPass();" />
            </div>

            <button type="submit">Login</button>
            <div class="register">
                <p>Don't have an account ?</p>
                <a href="register.php" class="option">Sign up</a>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" integrity="sha512-lOtDAY9KMT1WH9Fx6JSuZLHxjC8wmIBxsNFL6gJPaG7sLIVoSO9yCraWOwqLLX+txsOw0h2cHvcUJlJPvMlotw==" crossorigin="anonymous"></script>
    <script src="./js/loading.js"></script>
    <script src="./js/showPassword.js"></script>
</body>

</html>