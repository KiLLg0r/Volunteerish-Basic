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
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="../css/needy.css" />
        <link rel="stylesheet" href="../css/navNeedy.css">
        <link rel="stylesheet" href="../css/dropdown.css">
        <link rel="stylesheet" href="../css/card.css">
        <link rel="stylesheet" href="../css/msg-main.css">
        <link rel="stylesheet" href="../css/loading.css">
        <title>Needy person menu</title>
    </head>

    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="page-section page-2 active">
            <form action="../php/server_ann.php" class="form" id="ann" method="post">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                <?php } ?>

                <h2>Post an announcement</h2>
                <center>
                    <img src="../uploads/<?= $user['image'] ?>" height="100px" />
                </center>

                <label for="">UserID</label>
                <input type="text" name="userid" value="<?= $id ?>">

                <label for="">Name</label>
                <input type="text" name="name" value="<?= $user['firstname'] ?> <?= $user['lastname'] ?>">

                <label for="">Country</label>
                <input type="text" name="country" value="<?= $user['country']; ?>">

                <label for="">State</label>
                <input type="text" name="state" value="<?= $user['state']; ?>">

                <label for="">City</label>
                <input type="text" name="city" value="<?= $user['city']; ?>">

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

                <label for="">Difficulty</label>
                <select class="dropdown2" name="diff" id="diff">
                    <option value="Any">Any</option>
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                </select>

                <label for="">Description</label>
                <textarea name="description" id="desc" cols="30" rows="10" placeholder="Enter for what you post this announcement..."></textarea>

                <button type="submit" id="btn" form="ann" value="Submit">Post announcement</button>
            </form>
        </div>
        <footer id="btnContainer" class="btn-footer">
            <a class="link link-1" href="./home.php">
                <div class="icon">
                    <img src="../img/home.png" width="32" height="32" />
                    <p class="txt">Home</p>
                </div>
            </a>
            <a id="add-link" class="link link-2 active" href="./ann.php">
                <div class="icon add">
                    <img src="../img/ann.png" width="32" height="32" />
                    <p class="txt">Announces</p>
                </div>
            </a>
            <a class="link link-3" href="./mess.php">
                <div class="icon">
                    <img src="../img/msg.png" width="32" height="32" />
                    <p class="txt">Messages</p>
                </div>
            </a>
            <a class="link link-4" href="./settings.php">
                <div class="icon">
                    <img src="../img/settings.png" width="32" height="32" />
                    <p class="txt">Settings</p>
                </div>
            </a>
        </footer>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.22/index.umd.js" integrity="sha512-c08RNGquBScVDxl/Yf50kga+4ZEI/xuqjBxwFUTFjnRn4Zoz1qcd2m5e/E+Pi+2b0O+lwDPz+J9N3ZzHTbnxHA==" crossorigin="anonymous"></script>
        <script src="../js/dropdownmenu.js"></script>
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
                            'background': 'var(--grey3)',
                            '-webkit-background-clip': 'border-box',
                            'background-clip': 'border-box',
                            '-webkit-text-fill-color': 'black',
                            'color': 'black'
                        });
                    }
                });
            });
        </script>
    </body>

    </html>

<?php } else {
    header('Location: ../login.php');
    die();
}
?>