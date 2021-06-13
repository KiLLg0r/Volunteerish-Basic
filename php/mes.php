<?php

session_start();

include "./db.php";

$receiveID = $_GET['receiveID'];
$sendID = $_GET['sendID'];
$ocount = $_SESSION['count'];

$sql = "SELECT * FROM user WHERE id='$sendID'";
$result = mysqli_query($db, $sql);
if (mysqli_num_rows($result) === 1)
    $user = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM user WHERE id='$receiveID'";
$result2 = mysqli_query($db, $sql2);
if (mysqli_num_rows($result2) === 1)
    $receive = mysqli_fetch_assoc($result2);

$check = "SELECT * FROM messages WHERE (sent_by = '$receiveID' AND received_by = '$sendID') OR (sent_by = '$sendID' AND received_by = '$receiveID') ORDER BY createdAt ASC";
$checkResult = mysqli_query($db, $check);
$ncount = mysqli_num_rows($checkResult);
$nrMsg = $ncount - $ocount;

if ($ncount > $ocount) {
    $msg = "SELECT * FROM messages WHERE (sent_by = '$receiveID' AND received_by = '$sendID') OR (sent_by = '$sendID' AND received_by = '$receiveID') ORDER BY createdAt LIMIT $ocount, $ncount";
    $msgResult = mysqli_query($db, $msg);
    if (mysqli_num_rows($msgResult) > 0) {
        $_SESSION['count'] = $ncount;
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
<?php }
    }
} ?>