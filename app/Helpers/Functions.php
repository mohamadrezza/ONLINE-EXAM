<?php


function isJson($string)
{
    dd(2);
    try {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    } catch (Exception $e) {
        return false;
    }
}
