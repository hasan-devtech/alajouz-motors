<?php
namespace App\Helpers;
function resolvePerPage($perPage)
{
    return in_array($perPage, PAGINATION) ? $perPage : 10;
}