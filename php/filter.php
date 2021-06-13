<?php

session_start();

include "db.php";

$id = $_SESSION['id'];

if (isset($_POST['action'])) {
    $query = "SELECT * FROM ann WHERE status = 'active' ";

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function getColor($val)
    {
        if ($val == "Any") {
            return  'var(--dark-grey)';
        } else if ($val == "Easy") {
            return 'green';
        } else if ($val == "Medium") {
            return 'orange';
        } else if ($val == "Hard") {
            return 'red';
        }
    }

    if (isset($_POST['city']) && !empty($_POST['city'])) {
        $city = $_POST['city'];
        $sql = "SELECT * FROM cities WHERE id='$city'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $city = validate($row['name']);
        }
        $query .= "AND city = '$city' ";
    }

    if (isset($_POST['state']) && !empty($_POST['state'])) {
        $state = $_POST['state'];
        $sql = "SELECT * FROM states WHERE id='$state'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $state = validate($row['name']);
        }
        $query .= "AND state = '$state' ";
    }

    if (isset($_POST['country']) && !empty($_POST['country'])) {
        $country = $_POST['country'];
        $sql = "SELECT * FROM countries WHERE id='$country'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $country = validate($row['name']);
        }
        $query .= "AND country = '$country' ";
    }

    if (isset($_POST['diff']) && !empty($_POST['diff'])) {
        $diff = validate($_POST['diff']);
        if ($diff != 'Any')
            $query .= "AND dif = '$diff' ";
    }

    if (isset($_POST['type']) && !empty($_POST['type'])) {
        $type = validate($_POST['type']);
        if ($type != 'Any')
            $query .= "AND type = '$type' ";
    }

    if (isset($_POST['sort']) && !empty($_POST['sort'])) {
        $sort = validate($_POST['sort']);
        if ($sort == 'recents') {
            $query .= "ORDER BY id DESC";
        } else if ($sort == 'oldest') {
            $query .= "ORDER BY id ASC";
        } else if ($sort == 'ascdif') {
            $query .= "ORDER BY dif ASC";
        } else if ($sort == 'descdif') {
            $query .= "ORDER BY dif DESC";
        }
    }

    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($ann = mysqli_fetch_assoc($result)) {
            include_once "./userData.php";
            include_once "./age.php";
            $needy = userGetData($ann['userID']);
            $needyAge = ageCalculator($ann['userID']);

            if ($ann['dif'] == 0) $annDiff = 'Any';
            else if ($ann['dif'] == 1) $annDiff = 'Easy';
            else if ($ann['dif'] == 2) $annDiff = 'Medium';
            else if ($ann['dif'] == 3) $annDiff = 'Hard';
?>
            <div class="card">
                <div class="card-row-1">
                    <div class="card-img">
                        <center>
                            <img src="../uploads/<?= $needy['image'] ?>" />
                        </center>
                    </div>
                    <div class="card-info">
                        <div class="card-name"><?= $ann['name'] ?></div>
                        <div class="card-age"><span>Age: </span><?= $needyAge ?></div>
                        <div class="card-location"><span>Location: </span><?= $ann['city'] ?>, <?= $ann['state'] ?>, <?= $ann['country'] ?></div>
                    </div>
                </div>
                <div class="card-row-2">
                    <div class="card-info-2">
                        <div class="card-difficulty" style="color: <?= getColor($annDiff) ?>;">
                            <span>Difficulty</span>
                            <?= $annDiff ?>
                        </div>
                        <div class="card-type">
                            <span>Type</span>
                            <?= $ann['type'] ?>
                        </div>
                        <div class="card-msg">
                            <span>Description: </span>
                            <p><?= $ann['description'] ?></p>
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="help"><a href="../php/help.php?annID=<?= $ann['id'] ?>&userID=<?= $id ?>">Help this person</a></div>
                    </div>
                </div>
            </div>
        <?php }
    } else { ?>
        <div class="main act">
            <div class="notFound">
                <img src="../img/nfound.png" height="100" width="100" />
                <span class="notFound-text">No announces were found based on your criteria</span>
            </div>
        </div>
<?php }
}
?>