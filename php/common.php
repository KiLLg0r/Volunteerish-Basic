<?php
class Common
{
    public function getCountry($db)
    {
        $mainQuery = "SELECT * FROM countries";
        $result = $db->query($mainQuery) or die("Error in main Query" . $db->error);
        return $result;
    }

    public function getStateByCountry($db, $countryId)
    {
        $query = "SELECT * FROM states WHERE country_id='$countryId'";
        $result = $db->query($query) or die("Error in  Query" . $db->error);
        return $result;
    }

    public function getCityByState($db, $stateId)
    {
        $query = "SELECT * FROM cities WHERE state_id='$stateId'";
        $result = $db->query($query) or die("Error in  Query" . $db->error);
        return $result;
    }
}
