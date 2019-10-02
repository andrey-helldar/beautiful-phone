<?php

namespace Helldar\BeautifulPhone\Services;

use Helldar\BeautifulPhone\Services\Support\Arr;
use Helldar\BeautifulPhone\Services\Support\Config;
use Helldar\BeautifulPhone\Services\Support\Str;

class Phone
{
    /**
     * @param string $phone
     * @param int $city_code
     * @param bool $is_html
     * @param bool $is_link
     *
     * @return string
     */
    public function get($phone, $city_code = 0, $is_html = true, $is_link = true)
    {
        $phone_clean = $this->clear($phone);
        $phone_code  = $this->phoneCode($phone_clean, $city_code);
        $formatted   = $this->format($phone_clean, $phone_code);

        if ($result = $this->getShortPhone($formatted, $is_html, $is_link)) {
            return $result;
        }

        $template = $is_html ? 'template_prefix_html' : 'template_prefix_text';
        $template = $this->config($template, '+%s (%s) %s');
        $result   = \sprintf($template, Arr::get($formatted, 'region'), Arr::get($formatted, 'city'), Arr::get($formatted, 'phone'));

        if ($is_link) {
            $template   = $this->config('template_link', '<a href="%s">%s</a>');
            $phone_link = $this->clear(\implode('', $formatted));
            $phone_link = Str::start($phone_link, '+');

            $result = \sprintf($template, $phone_link, $result);
        }

        return $result;
    }

    private function getShortPhone(array $formatted, $is_html = true, $is_link = true)
    {
        $phone = (string) Arr::get($formatted, 'phone');

        if (Str::length($phone) > 4) {
            return false;
        }

        if (($is_html && $is_link) || (! $is_html && $is_link)) {
            $template = $this->config('template_link', '%s');

            return \sprintf($template, $phone, $phone);
        }

        return $phone;
    }

    /**
     * Conversion of letter numbers into digital numbers.
     *
     * @param string $phone
     *
     * @return string
     */
    private function convertWords($phone = '')
    {
        $phone   = Str::lower($phone);
        $replace = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        foreach ($replace as $digit => $letters) {
            $phone = \str_ireplace($letters, $digit, $phone);
        }

        return (string) $phone;
    }

    /**
     * Delete all characters except digits from the number.
     *
     * @param string $phone
     *
     * @return string
     */
    private function clear($phone): string
    {
        $phone = $this->convertWords($phone);

        return (string) \preg_replace("/\D/", '', $phone);
    }

    /**
     * If a city code is found in the phone number from the list, return it,
     * otherwise we think that the city code consists of three digits.
     *
     * @param $phone
     * @param $region
     * @param $city
     *
     * @return string
     */
    private function code($phone, $region, $city = null)
    {
        if ($city && Str::startsWith($phone, ($region . $city))) {
            return $city;
        }

        foreach ($this->config('codes', []) as $code) {
            $len_region = Str::length($region);
            $len_code   = Str::length((string) $code);

            if (Str::substr($phone, $len_region, $len_code) === (string) $code) {
                return (string) $code;
            }
        }

        return Str::substr($phone, 1, 3);
    }

    /**
     * Obtain the region code (country).
     *
     * @param $phone
     *
     * @return bool|int|string
     */
    private function region($phone)
    {
        $codes = $this->config('countries', []);
        $code  = Str::substr($phone, 0, 1);

        foreach ($codes as $item) {
            if (Str::startsWith($phone, $item)) {
                return $this->replaceRegion($item);
            }
        }

        return $this->replaceRegion($code);
    }

    /**
     * @param string|int $value
     *
     * @return int
     */
    private function replaceRegion($value)
    {
        $regions = $this->config('replaces_country', []);

        return (int) Arr::get($regions, $value, $value);
    }

    /**
     * Splitting a phone number into groups.
     *
     * @param $phone
     *
     * @return string
     */
    private function split($phone)
    {
        $length = Str::length((string) $phone);

        if ($length <= 4) {
            return $phone;
        }

        if ($length == 7) {
            $tmp = [Str::substr($phone, 0, 3)];
            $tmp = \array_merge($tmp, \str_split(Str::substr($phone, 3), 2));

            return \implode('-', $tmp);
        }

        return \implode('-', \str_split($phone, 3));
    }

    /**
     * Attaching the phone code of the city.
     *
     * @param string $phone
     * @param null|int $code
     *
     * @return array
     */
    private function phoneCode($phone, $code = null): array
    {
        if (Str::length($phone) <= 4) {
            return [];
        }

        if (Str::length($phone) <= 7) {
            $region = $this->config('default_country', 7);
            $city   = $code ?: $this->config('default_city', 7);

            return \compact('region', 'city');
        }

        $region = $this->region($phone);
        $city   = $this->code($phone, $region, $code);

        return \compact('region', 'city');
    }

    /**
     * Checking the "beauty" of the phone number.
     *
     * @param string $phone
     *
     * @return bool
     */
    private function isBeauty($phone)
    {
        $arr = \str_split((string) $phone, 3);

        $is_beauty = $arr[0] === $arr[1];

        if (! $is_beauty) {
            $is_beauty = ($arr[0] % 10 == 0 || $arr[1] % 10 == 0);
        }

        if (! $is_beauty) {
            $sum0 = $this->sum($arr[0]);
            $sum1 = $this->sum($arr[1]);

            $count0 = \sizeof(\array_unique(\str_split((string) $arr[0])));
            $count1 = \sizeof(\array_unique(\str_split((string) $arr[1])));

            $is_beauty = ($sum0 == $sum1) || ($count0 === 1 && $count1 === 1);
        }

        return $is_beauty;
    }

    /**
     * Calculation of the sum of the digits of a string.
     *
     * @param string $digit
     *
     * @return int
     */
    private function sum($digit = '')
    {
        if ((int) $digit < 10) {
            return (int) $digit;
        }

        $sum = \array_sum(\str_split((string) $digit, 1));

        return (int) ($sum >= 10 ? $this->sum($sum) : $sum);
    }

    /**
     * Formatting a phone number.
     *
     * @param mixed $phone
     * @param array $phone_code
     *
     * @return array
     */
    private function format($phone, array $phone_code): array
    {
        if (Str::length($phone) <= 4) {
            return \compact('phone');
        }

        if (Str::length($phone) == 5) {
            $arr = \str_split(\substr($phone, 1), 2);

            $phone = $phone[0] . '-' . \implode('-', $arr);

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        if (Str::length($phone) == 6) {
            $divider = $this->isBeauty($phone) ? 3 : 2;
            $phone   = \implode('-', \str_split($phone, $divider));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        if (Str::length($phone) < 10) {
            $phone = \implode('-', \str_split($phone, 3));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        // Mobile phones.
        $prefix = ($phone_code['region'] ?? null) . ($phone_code['city'] ?? null);
        $phone  = Str::substr($phone, Str::length($prefix));

        if ($this->isBeauty($phone)) {
            $phone = \implode('-', \str_split($phone, 3));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        $phone_code['phone'] = $this->split($phone);

        return $phone_code;
    }

    private function config($key, $default = null)
    {
        return Config::get($key, $default);
    }
}
