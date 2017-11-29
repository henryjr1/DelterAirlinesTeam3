<!DOCTYPE html>
<?php

$url = 'http://35.188.55.177/api/v1.0/Flight-Search?toLocation=Atlanta%2C%20GA&startDate=2017-12-28&fromLocation=Starkville%2C%20MS&endDate=2017-01-28';
		$ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $return = curl_exec ($ch);
        curl_close ($ch);

        $array = (json_decode($return, true));
              print_r($array);
 ?>

