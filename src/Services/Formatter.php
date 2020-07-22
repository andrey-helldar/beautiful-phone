<?php

namespace Helldar\BeautifulPhone\Services;

final class Formatter
{
    protected $instance;

    public function __construct(Phone $instance)
    {
        $this->instance = $instance;
    }

    public function spanLink($phone, int $city_code = 0, array $attributes = [])
    {
        return $this->instance->get($phone, $city_code, true, true, $attributes);
    }

    public function cleanLink($phone, int $city_code = 0, array $attributes = [])
    {
        return $this->instance->get($phone, $city_code, false, true, $attributes);
    }

    public function span($phone, int $city_code = 0)
    {
        return $this->instance->get($phone, $city_code, true, false);
    }

    public function clear($phone, int $city_code = 0)
    {
        return $this->instance->get($phone, $city_code, false, false);
    }

    public function fullClear($phone, int $city_code = 0)
    {
        return $this->instance->get($phone, $city_code, false, false, [], true);
    }
}
