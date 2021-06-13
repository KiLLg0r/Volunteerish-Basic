<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="./css/register.css" />
  <link rel="stylesheet" href="./css/loading.css">
  <link rel="stylesheet" href="./css/swiper.css">
  <title>Register</title>
</head>

<body>
  <div class="loading">
    <div class="spinner"></div>
  </div>
  <div class="icon"></div>
  <div class="reg">
    <form action="./php/server_register.php" method="post" enctype="multipart/form-data">
      <h3>
        <p><span style="color: #ff0000">Create </span>your <span style="color: #ff0000"> Volunteerish </span>account</p>
      </h3>

      <?php
      include "./php/db.php";
      include_once "./php/common.php";
      $common = new Common();
      $countries = $common->getCountry($db); ?>
      <!--Show errors-->
      <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
      <?php } ?>

      <!--Show succes if account was created successfully-->
      <?php if (isset($_GET['success'])) { ?>
        <p class="success"><?php echo $_GET['success']; ?></p>
      <?php } ?>

      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <center class="img-upload">
              <div class="img-placeholder">
                <img src="./img/img-placeholder.png" id="img-placeholder" style="height: 80%; width: 80%; margin: 10px">
              </div>
              <input type="file" name="imageUpload" onchange="loadFile(event)" id="imageUpload" style="display: none;" />
              <label for="file" style="cursor: pointer;">Upload a picture</label>
            </center>
          </div>

          <div class="swiper-slide">
            <label for="">First name <span style="color: red">*</span></label>
            <?php if (isset($_GET['firstname'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=identification&color=ff0000" width="40" height="40" />
                <input type="text" name="firstname" placeholder="Enter your first name..." value="<?php echo $_GET['firstname']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=identification&color=ff0000" width="40" height="40" />
                <input type="text" name="firstname" placeholder="Enter your first name..." />
              </div>
            <?php } ?>

            <label for="">Last name <span style="color: red">*</span></label>
            <?php if (isset($_GET['lastname'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=identification&color=ff0000" width="40" height="40" />
                <input type="text" name="lastname" placeholder="Enter your last name..." value="<?php echo $_GET['lastname']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=identification&color=ff0000" width="40" height="40" />
                <input type="text" name="lastname" placeholder="Enter your last name..." />
              </div>
            <?php } ?>
          </div>

          <div class="swiper-slide">
            <label for="">Birth date <span style="color: red">*</span></label>
            <?php if (isset($_GET['birth'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=calendar&color=ff0000" width="40" height="40">
                <input type="date" name="birth" placeholder="Enter your birth date..." value="<?php echo $_GET['birth']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=calendar&color=ff0000" width="40" height="40">
                <input type="date" name="birth" placeholder="Enter your birth date..." min="1950-01-01" max="2030-12-31" />
              </div>
            <?php } ?>

            <label for="">Email <span style="color: red">*</span></label>
            <?php if (isset($_GET['email'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=mail&color=ff0000" width="40" height="40" />
                <input type="email" name="email" placeholder="Enter your email..." value="<?php echo $_GET['email']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=mail&color=ff0000" width="40" height="40" />
                <input type="email" name="email" placeholder="Enter your email..." />
              </div>
            <?php } ?>
          </div>

          <div class="swiper-slide">
            <label for="country">Country <span style="color: red">*</span></label>
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

            <label for="state">State <span style="color: red">*</span></label>
            <div class="input">
              <img src="https://s2.svgbox.net/hero-solid.svg?ic=map&color=ff0000" width="40" height="40" />
              <select class="dropdown" name="state" id="stateId" onchange="getCityByState();">
                <option value="" style="font-style: italic">Select state...</option>
              </select>
            </div>

            <label for="city">City <span style="color: red">*</span></label>
            <div class="input">
              <img src="https://s2.svgbox.net/hero-solid.svg?ic=office-building&color=ff0000" width="40" height="40" />
              <select class="dropdown" name="city" id="cityDiv">
                <option value="" style="font-style: italic">Select city...</option>
              </select>
            </div>

          </div>

          <div class="swiper-slide">
            <label for="">Address <span style="color: red">*</span></label>
            <?php if (isset($_GET['address'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                <input type="text" name="address" placeholder="Enter your address..." value="<?php echo $_GET['address']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                <input type="text" name="address" placeholder="Enter your address..." />
              </div>
            <?php } ?>

            <label for="">Postcode <span style="color: red">*</span></label>
            <?php if (isset($_GET['postcode'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                <input type="text" name="postcode" placeholder="Enter your postal code..." value="<?php echo $_GET['postcode']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=home&color=ff0000" width="40" height="40" />
                <input type="text" name="postcode" placeholder="Enter your postal code..." />
              </div>
            <?php } ?>
          </div>

          <div class="swiper-slide">
            <label for="">Phone number <span style="color: red">*</span></label>
            <?php if (isset($_GET['phone'])) { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=device-mobile&color=ff0000" width="40" height="40" />
                <input type="tel" name="phone" placeholder="Enter your phone number..." value="<?php echo $_GET['phone']; ?>" />
              </div>
            <?php } else { ?>
              <div class="input">
                <img src="https://s2.svgbox.net/hero-solid.svg?ic=device-mobile&color=ff0000" width="40" height="40" />
                <input type="tel" name="phone" placeholder="Enter your phone number..." />
              </div>
            <?php } ?>

            <label for="">Status <span style="color: red">*</span></label>
            <div class="input">
              <img src="https://s2.svgbox.net/hero-solid.svg?ic=tag&color=ff0000" width="40" height="40">
              <select name="status" class="dropdown">
                <option value="" style="font-style: italic">Select status...</option>
                <option value="Volunteer">Volunteer</option>
                <option value="Needy person">Needy person</option>
              </select>
            </div>
          </div>

          <div class="swiper-slide"><label for="">Password <span style="color: red">*</span></label>
            <div class="input">
              <img src="https://s2.svgbox.net/hero-solid.svg?ic=lock-closed&color=ff0000" width="40" height="40" />
              <input type="password" name="password" placeholder="Enter your password..." id="password" class="password" />
              <img id="passImg" src="https://s2.svgbox.net/hero-solid.svg?ic=eye&color=ff0000" width="40" height="40" onclick="showPass();" />
            </div>

            <label for="">Confirm password <span style="color: red">*</span></label>
            <div class="input">
              <img src="https://s2.svgbox.net/hero-solid.svg?ic=lock-closed&color=ff0000" width="40" height="40" />
              <input type="password" name="confirm_password" placeholder="Renter your password..." id="confirmPassword" class="password" />
              <img id="confirmPassImg" src="https://s2.svgbox.net/hero-solid.svg?ic=eye&color=ff0000" width="40" height="40" onclick="showConfirmPass();" />
            </div>
          </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div id="next" class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
      <button id="reg-btn" type="submit" name="submit" value="UPLOAD" style="display: none;">Create account</button>
      <div class="login">
        <p>Already have an account ?</p>
        <a href="login.php" class="option">Log in</a>
      </div>
    </form>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script src="./js/dropdown.js"></script>
  <script src="./js/loading.js"></script>
  <script src="./js/showPassword.js"></script>
  <script src="./js/reg-img.js"></script>
  <script src="./js/swiper.js"></script>
  <script src="./js/csc.js"></script>
</body>

</html>