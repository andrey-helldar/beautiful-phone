<?php

namespace Helldar\BeautifulPhone\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Phone
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $config;

    public function __construct()
    {
        $config = Config::get('beautiful_phone', []);

        $this->config = Collection::make($config);
    }

    public function get($phone, $city_code = 0, $is_html = true, $is_link = true)
    {
        $phone_clean = $this->clear($phone);
        $phone_code  = $this->phoneCode($phone_clean, $city_code);
        $formatted   = $this->format($phone_clean, $phone_code);

        $template = $is_html ? 'template_prefix_html' : 'template_prefix_text';
        $template = $this->config->get($template, '+%s (%s) %s');
        $result   = sprintf($template, $formatted->get('region'), $formatted->get('city'), $formatted->get('phone'));

        if ($is_link) {
            $template   = $this->config->get('template_link', '<a href="%s">%s</a>');
            $phone_link = $this->clear($phone_code->implode(''));
            $result     = sprintf($template, $phone_link, $result);
        }

        return $result;
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
            $phone = str_ireplace($letters, $digit, $phone);
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
    private function clear($phone)
    {
        $phone = $this->convertWords($phone);

        return (string) preg_replace("/\D/", '', $phone);
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

        foreach ($this->config->get('codes', []) as $code) {
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
        $codes = $this->config->get('countries', []);
        $code  = Str::substr($phone, 0, 1);

        foreach ($codes as $item) {
            if (Str::startsWith($phone, $item)) {
                return $item;
            }
        }

        return $code;
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
            $tmp = array_merge($tmp, str_split(Str::substr($phone, 3), 2));

            return implode('-', $tmp);
        }

        return implode('-', str_split($phone, 3));
    }

    /**
     * Attaching the phone code of the city.
     *
     * @param string $phone
     * @param null|int $code
     *
     * @return Collection
     */
    private function phoneCode($phone, $code = null)
    {
        if (Str::length($phone) <= 4) {
            return collect();
        }

        if (Str::length($phone) <= 7) {
            $region = $this->config->get('default_country', 7);
            $city   = $code ?: $this->config->get('default_city', 7);

            return collect(compact('region', 'city'));
        }

        $region = $this->region($phone);
        $city   = $this->code($phone, $region, $code);

        return collect(compact('region', 'city'));
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
        $arr       = str_split((string) $phone, 3);
        $is_beauty = $arr[0] === $arr[1];

        if (!$is_beauty) {
            $is_beauty = ($arr[0] % 10 == 0 || $arr[1] % 10 == 0);
        }

        if (!$is_beauty) {
            $sum0   = $this->sum($arr[0]);
            $sum1   = $this->sum($arr[1]);
            $count0 = sizeof(array_unique(str_split((string) $arr[0])));
            $count1 = sizeof(array_unique(str_split((string) $arr[1])));

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

        $sum = array_sum(str_split((string) $digit, 1));

        return (int) ($sum >= 10 ? $this->sum($sum) : $sum);
    }

    /**
     * Formatting a phone number.
     *
     * @param mixed $phone
     * @param \Illuminate\Support\Collection $phone_code
     *
     * @return \Illuminate\Support\Collection
     */
    private function format($phone, $phone_code)
    {
        if (Str::length($phone) <= 4) {
            return collect(compact('phone'));
        }

        if (Str::length($phone) == 5) {
            $arr   = str_split(substr($phone, 1), 2);
            $phone = $phone[0] . '-' . implode('-', $arr);

            return $phone_code->put('phone', $phone);
        }

        if (Str::length($phone) == 6) {
            $divider = $this->isBeauty($phone) ? 3 : 2;
            $phone   = implode('-', str_split($phone, $divider));

            return $phone_code->put('phone', $phone);
        }

        if (Str::length($phone) < 10) {
            $phone = implode('-', str_split($phone, 3));

            return $phone_code->put('phone', $phone);
        }

        // Mobile phones.
        $prefix = $phone_code->get('region') . $phone_code->get('city');
        $phone  = Str::substr($phone, Str::length($prefix));

        if ($this->isBeauty($phone)) {
            $phone = implode('-', str_split($phone, 3));

            return $phone_code->put('phone', $phone);
        }

        return $phone_code->put('phone', $this->split($phone));
    }
}
