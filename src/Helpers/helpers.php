<?php

if (!function_exists('phone')) {
    /**
     * {@inheritdoc}
     *
     * @param $phone
     * @param int $phone_code
     * @param bool $is_html
     * @param bool $is_link
     *
     * @return string
     */
    function phone($phone, $phone_code = 0, $is_html = true, $is_link = true)
    {
        return \app('phone')->get($phone, $phone_code, $is_html, $is_link);
    }
}
