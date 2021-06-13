<?php

function ageCalculator($id)
{
    include "db.php";
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $birth = $row['birth'];
        $birthY = date('Y', strtotime($birth));
        $currentY = date('Y');
        $y = $currentY - $birthY;
        $age = $y . " years";
    }
    return $age;
}
