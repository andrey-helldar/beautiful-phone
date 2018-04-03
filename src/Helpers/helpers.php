<?php

if (!function_exists('phone')) {
    /**
     * @param      $phone
     * @param int  $phone_code
     * @param bool $is_html
     *
     * @return bool|string
     */
    function phone($phone, $phone_code = 0, $is_html = true)
    {
        return app('phone')->get($phone, $phone_code, $is_html);
    }
}

if (!function_exists('str_lower')) {
    /**
     * Convert the given string to lower-case.
     *
     * @param string $value
     *
     * @return string
     */
    function str_lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }
}
