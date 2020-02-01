<?php

use Helldar\BeautifulPhone\Services\Phone;
use Illuminate\Container\Container;

if (! function_exists('phone')) {
    /**
     * {@inheritdoc}
     *
     * @param $phone
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return string
     */
    function phone($phone, int $city_code = 0, bool $is_html = true, bool $is_link = true, array $attributes = [])
    {
        return Container::getInstance()->make('Helldar\BeautifulPhone\Services\Phone')
            ->get($phone, $city_code, $is_html, $is_link, $attributes);
    }
}
