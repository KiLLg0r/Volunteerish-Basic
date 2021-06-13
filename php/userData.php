<?php

function userGetData($id)
{
    include "db.php";
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0)
        $row = mysqli_fetch_assoc($result);
    return $row;
}
