<?php
namespace App\Helpers;
function haversine($userLat, $userLng, $companyLat, $companyLng)
{
    $earthRadius = 6371;
    $dLat = deg2rad($companyLat - $userLat);
    $dLon = deg2rad($companyLng - $userLng);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($userLat)) * cos(deg2rad($companyLat)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}