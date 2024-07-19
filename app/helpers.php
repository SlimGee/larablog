<?php

if (! function_exists('convert_array_access')) {
    function convert_array_access($str)
    {
        $string = preg_replace('/\[(\w+)\]/', '.$1', $str, 1);

        // Handle subsequent conversions
        return preg_replace('/\[(\w+)\]/', '.$1', $string);
    }
}

if (! function_exists('respond_to')) {
    function respond_to(...$args): mixed
    {
        return response()->to(...$args);
    }
}
