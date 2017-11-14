<?php
/**
 * Created by PhpStorm.
 * User: arielslf
 * Date: 14/11/17
 * Time: 8:43
 */

use RFHaversini\Distance;

if (! function_exists('distanceToKilometer')) {
    function distanceToKilometer($lat, $long, $desLat, $desLong)
    {
        return $inKilometers = Distance::toKilometers($lat, $long, $desLat, $desLong);
    }
}

if (! function_exists('HoursToMinutes')) {
    function HoursToMinutes($a)
    {
        return $a * 60;
    }
}

if (! function_exists('GetDrivingDistance')) {
    function GetDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $lat1 . "," . $long1 . "&destinations=" . $lat2 . "," . $long2 . "&mode=driving&language=pl-PL";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }
}
