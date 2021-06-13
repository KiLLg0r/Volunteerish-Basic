<?php
session_start();

if (isset($_SESSION['id'])) {
    include "./php/db.php";
    $sendID = $_GET['sendID'];
    $receiveID = $_GET['receiveID'];
    $sql = "SELECT * FROM user WHERE id='$sendID'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) === 1)
        $user = mysqli_fetch_assoc($result);
    $sql2 = "SELECT * FROM user WHERE id='$receiveID'";
    $result2 = mysqli_query($db, $sql2);
    if (mysqli_num_rows($result2) === 1)
        $receive = mysqli_fetch_assoc($result2);

    if (isset($_SESSION['count']))
        $count = $_SESSION['count'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./css/msg-second.css">
        <link rel="stylesheet" href="./css/loading.css">
        <title>Volunteer menu</title>
    </head>

    <body onscroll="scrollButton()">
        <div class="go-back">
            <?php if ($user['status'] == 'Volunteer') { ?>
                <a href="./volunteer/mess.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } else if ($user['status'] == 'Needy person') { ?>
                <a href="./needy/mess.php"><img src="https://s2.svgbox.net/hero-outline.svg?ic=chevron-left&color=e8594f" width="50" height="50"></a>
            <?php } ?>
            <div class="chat-user-image"><img src="./uploads/<?= $receive['image'] ?>" height="60" width="60"></div>
            <div class="chat-user-name"><?= $receive['firstname'] ?> <?= $receive['lastname'] ?></div>
        </div>
        <div class="messages">
            <div class="all-messages">
                <?php
                $msg = "SELECT * FROM messages WHERE (sent_by = '$receiveID' AND received_by = '$sendID') OR (sent_by = '$sendID' AND received_by = '$receiveID') ORDER BY createdAt ASC";
                $msgResult = mysqli_query($db, $msg);
                $_SESSION['count'] = mysqli_num_rows($msgResult);
                if (mysqli_num_rows($msgResult) > 0)
                    while ($msgRow = mysqli_fetch_assoc($msgResult))
                        if ($msgRow['sent_by'] == $sendID) {
                ?>
                    <div class="msg-card-sent">
                        <div class="data">
                            <div class="name"><?= $user['firstname'] ?> <?= $user['lastname'] ?></div>
                            <div class="msg"><?= $msgRow['message'] ?></div>
                            <div class="date"><?= $msgRow['createdAt'] ?></div>
                        </div>
                        <div class="img">
                            <img src="./uploads/<?= $user['image'] ?>" height="40" width="40">
                        </div>
                    </div>
                <?php } else if ($msgRow['sent_by'] == $receiveID) { ?>
                    <div class="msg-card-received">
                        <div class="img">
                            <img src="./uploads/<?= $receive['image'] ?>" height="40" width="40">
                        </div>
                        <div class="data">
                            <div class="name"><?= $receive['firstname'] ?> <?= $receive['lastname'] ?></div>
                            <div class="msg"><?= $msgRow['message'] ?></div>
                            <div class="date"><?= $msgRow['createdAt'] ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div id="bottom-btn" onclick="location.href='#down'"><img src="https://s2.svgbox.net/materialui.svg?ic=arrow_downward&color=fff" width="32" height="32"></div>
        </div>
        <form action="./php/sendMsg.php?sent_by=<?= $sendID ?>&received_by=<?= $receiveID ?>" class="send-msg" method="post">
            <input type="text" name="message" autofocus placeholder="Type message...">
            <button type="submit" class="send-msg-button"><img src="https://s2.svgbox.net/materialui.svg?ic=send&color=fff" width="32" height="32"></button>
        </form>
        <div id="down"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="./js/loading.js"></script>
        <script>
            function scrollButton() {
                let current = document.documentElement.scrollTop;
                let maxHeight = document.body.scrollHeight;

                if (current + screen.height <= maxHeight) $('#bottom-btn').css('display', 'block');
                else $('#bottom-btn').css('display', 'none');
            }

            function autoScroll() {
                $('html, body').animate({
                    scrollTop: $('#down').offset().top + screen.height
                }, 'slow');
            }

            $(window).on('load', function() {
                autoScroll();
            });

            $(document).ready(function() {
                function getData() {
                    $.ajax({
                        type: 'GET',
                        url: './php/mes.php?sendID=<?= $sendID ?>&receiveID=<?= $receiveID ?>',
                        success: function(data) {
                            $('.all-messages').append(data);
                            count = <?php echo $_SESSION['count'] ?>;
                        }

                    });
                }
                getData();
                setInterval(function() {
                    getData();
                }, 250);

                setInterval(function() {
                    if (document.documentElement.scrollTop + screen.height >= document.body.scrollHeight) autoScroll();
                }, 2000);

            });
        </script>
    </body>

    </html>

<?php
} else {
    header('Location: login.php');
    die();
}
?>