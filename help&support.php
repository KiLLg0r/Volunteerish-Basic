<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
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
        <link rel="stylesheet" href="./css/help&sup.css">
        <link rel="stylesheet" href="./css/loading.css">
        <title>Volunteer menu</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="go-back">
            <?php if ($user['status'] == 'Volunteer') { ?>
                <a href="./volunteer/settings.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } else if ($user['status'] == 'Needy person') { ?>
                <a href="./needy/settings.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } ?>
        </div>
        <div class="help-support">
            <h3>Help & Support</h3>
            <p>If you need help with the app or you want to report a bug or a serios problem you can contact us in a way below</p>

            <h4>F.A.Q</h4>

            <div class="dropdown">
                <div onclick="openDropdownNeedy()" class="dropbtn needy">
                    <p>Needy person section</p>
                    <img id="dropdown-img-1-needy" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=41403E" width="28" height="28" style="display: none;">
                    <img id="dropdown-img-2-needy" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=41403E" width="28" height="28" style="display: block;">
                </div>
                <div id="myDropdown" class="dropdown-content needy">
                    <div class="qa">
                        <div class="q">How can i change my name/email/birthdate/location/address/phone/password?</div>
                        <div class="a">To change one of these pieces of information, go to the settings tab, the account section and click on one of the pieces of information you want to change.</div>
                    </div>
                    <div class="qa">
                        <div class="q">How do I post announces?</div>
                        <div class="a">In order to post announces you have to go to the announces tab, complete all the fields and in the end press the "Post announcement" button.</div>
                    </div>
                    <div class="qa">
                        <div class="q">How can i talk to the person who help me?</div>
                        <div class="a">Here we have 2 options: </div>
                        <div class="a">
                            1. you will have to go to the home tab, the announce center section and click on the yellow "Send message" button on the respective announcement.
                        </div>
                        <div class="a">
                            2. you will have to go to the message tab, where you will be able to see the messages with all the people you are helping.
                        </div>
                    </div>
                    <div class="qa">
                        <div class="q">PS: If you need additional help do not hesitate to call us. To do this, go to the settings tab, Help & Support section, where you can find our emails. We are at your disposal 24 hours a day, 7 days a week. </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <div onclick="openDropdownVol()" class="dropbtn volunteer">
                    <p>Volunteer section</p>
                    <img id="dropdown-img-1-vol" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-down&color=41403E" width="28" height="28" style="display: none;">
                    <img id="dropdown-img-2-vol" src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-up&color=41403E" width="28" height="28" style="display: block;">
                </div>
                <div id="myDropdown" class="dropdown-content volunteer">
                    <div class="qa">
                        <div class="q">How do i help a person?</div>
                        <div class="a">All you have to do is go to the announces tab and click on the green "Help this person" button on one of the announces.
                        </div>
                    </div>
                    <div class="qa">
                        <div class="q">How can i change my name/email/birthdate/location/address/phone/password?</div>
                        <div class="a">To change one of these pieces of information, go to the settings tab, the account section and click on one of the pieces of information you want to change.</div>
                    </div>
                    <div class="qa">
                        <div class="q">How can I check the location on the map of the person I'm helping?</div>
                        <div class="a">For this you will have to go to the home tab, the announce center section and click on the red "More info" button on the respective announcement.</div>
                    </div>
                    <div class="qa">
                        <div class="q">How can i talk to the person i'm helping?</div>
                        <div class="a">Here we have 3 options: </div>
                        <div class="a">
                            1. you will have to go to the home tab, the announce center section and click on the yellow "Send message" button on the respective announcement.
                        </div>
                        <div class="a">
                            2. you will have to go to the message tab, where you will be able to see the messages with all the people you are helping.
                        </div>
                        <div class="a">
                            3. you will have to go to the home tab, the announce center section, click on the red "More info" button on the respective announcement and there you will be able to find the phone number of the respective person (if this person has a phone number)
                        </div>
                    </div>
                    <div class="qa">
                        <div class="q">How can I get points for the shop?</div>
                        <div class="a">You can get points by helping people. The number of points obtained depends on the difficulty and duration of the activities you do.</div>
                    </div>
                    <div class="qa">
                        <div class="q">How can I buy Volunteerish custom items? </div>
                        <div class="a">To purchase custom items you must first get points, then you must go to the shop tab where you have all the Volunteerish custom items. Here all you have to do is press the buy button.
                        </div>
                    </div>
                    <div class="qa">
                        <div class="q">How the points system works</div>
                        <div class="a"><img src="./img/points.png"></div>
                    </div>
                    <div class="qa">
                        <div class="q">PS: If you need additional help do not hesitate to call us. To do this, go to the settings tab, Help & Support section, where you can find our emails. We are at your disposal 24 hours a day, 7 days a week. </div>
                    </div>
                </div>
            </div>

            <h4>Contact</h4>

            <div class="contact-method">
                <p id="label">Email</p>
                <p>rob.oblesniuc@gmail.com - Robert</p>
                <p>alisa.i.moldoveanu@gmail.com - Alisa</p>
                <p>postolachefabian3@gmail.com - Fabian</p>
            </div>

        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.js" integrity="sha512-c08RNGquBScVDxl/Yf50kga+4ZEI/xuqjBxwFUTFjnRn4Zoz1qcd2m5e/E+Pi+2b0O+lwDPz+J9N3ZzHTbnxHA==" crossorigin="anonymous"></script>
        <script src="./js/loading.js"></script>
        <script src="./js/dropdownmenu.js"></script>
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