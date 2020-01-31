<?php

use Helldar\BeautifulPhone\Services\Phone;
use Illuminate\Container\Container;

if (! function_exists('phone')) {
    /**
     * {@inheritdoc}
     * @param $phone
     * @param int $city_code
     * @param bool $is_html
     * @param bool $is_link
     * @param array $attributes
     *
     * @return string
     */
    function phone($phone, int $city_code = 0, bool $is_html = true, bool $is_link = true, array $attributes = [])
    {
        if (class_exists(Container::class)) {
            return Container::getInstance()->make(Phone::class)
                ->get($phone, $city_code, $is_html, $is_link, $attributes);
        }

        return (new Phone())->get($phone, $city_code, $is_html, $is_link, $attributes);
    }
}
