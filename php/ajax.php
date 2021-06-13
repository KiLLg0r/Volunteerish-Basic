<?php

include "./db.php";
include_once "./common.php";

if (isset($_POST['getStateByCountry']) == "getStateByCountry") {
    $countryId = $_POST['countryId'];
    $common = new Common();
    $states = $common->getStateByCountry($db, $countryId);
    $stateData = '<option value="" style="font-style: italic;">Select state...</option>';
    if ($states->num_rows > 0) {
        while ($state = $states->fetch_object()) {
            $stateData .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }
    }
    echo "test^" . $stateData;
}

if (isset($_POST['getCityByState']) == "getCityByState") {
    $stateId = $_POST['stateId'];
    $common = new Common();
    $cities = $common->getCityByState($db, $stateId);
    $cityData = '<option value="" style="font-style: italic;">Select city...</option>';
    if ($cities->num_rows > 0) {
        while ($city = $cities->fetch_object()) {
            $cityData .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
    }
    echo "test^" . $cityData;
}
