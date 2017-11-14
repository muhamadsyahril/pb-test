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