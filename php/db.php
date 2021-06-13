 <?php
    $db = mysqli_connect('localhost', 'root', '', 'hardcore entrepreneur');

    if (!$db) {
        echo "Connection failed!";
    }
