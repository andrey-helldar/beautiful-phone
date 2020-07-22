<?php

namespace Helldar\BeautifulPhone\Services;

use function array_keys;
use function array_map;
use function array_merge;

use function array_sum;
use function array_unique;
use function array_values;
use function compact;
use Helldar\BeautifulPhone\Traits\HasConfigurable;
use Helldar\Support\Facades\Arr;
use Helldar\Support\Facades\Str;
use function implode;
use function preg_replace;
use function sprintf;
use function str_ireplace;
use function str_split;
use function substr;
use function substr_count;

class Phone
{
    use HasConfigurable;

    /**
     * @param $phone
     * @param  int  $city_code
     * @param  bool  $is_html
     * @param  bool  $is_link
     * @param  array  $attributes
     * @param  bool  $clear
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool|string
     */
    public function get($phone, int $city_code = 0, bool $is_html = true, bool $is_link = true, array $attributes = [], bool $clear = false): string
    {
        $phone_clean = $this->clear($phone);
        $phone_code  = $this->phoneCode($phone_clean, $city_code);
        $formatted   = $this->format($phone_clean, $phone_code, $clear);

        if ($result = $this->getShortPhone($formatted, $is_html, $is_link, $attributes)) {
            return $result;
        }

        $result = $this->formatPhone($formatted, $is_html, $clear);

        if ($is_link) {
            return $this->convertToLink($result, $formatted, $attributes);
        }

        return $result;
    }

    protected function convertToLink(string $result, array $formatted, array $attributes = []): string
    {
        $template   = $this->getTemplateLink();
        $phone_link = $this->clear(implode('', $formatted));
        $phone_link = Str::start($phone_link, '+');
        $attr       = $this->compileAttributes($attributes);

        return sprintf($template, $phone_link, $attr, $result);
    }

    protected function formatPhone(array $formatted = [], bool $is_html = true, bool $clear = false): string
    {
        $template = $this->getTemplate($is_html);
        $region   = Arr::get($formatted, 'region');
        $city     = Arr::get($formatted, 'city');
        $phone    = Arr::get($formatted, 'phone');

        return $clear
            ? '+' . $region . $city . $phone
            : sprintf($template, $region, $city, $phone);
    }

    protected function getShortPhone(array $formatted, bool $is_html = true, bool $is_link = true, array $attributes = []): string
    {
        $phone = (string) Arr::get($formatted, 'phone');

        if (Str::length($phone) > 4) {
            return '';
        }

        if (($is_html && $is_link) || (empty($is_html) && $is_link)) {
            $template = $this->getTemplateLink('%s%s');
            $attr     = $this->compileAttributes($attributes);

            return sprintf($template, $phone, $attr, $phone);
        }

        return $phone;
    }

    /**
     * Conversion of letter numbers into digital numbers.
     *
     * @param  string  $phone
     *
     * @return string
     */
    protected function convertWords(string $phone = ''): string
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
     * @param  string  $phone
     *
     * @return string
     */
    protected function clear($phone): string
    {
        $phone = $this->convertWords((string) $phone);

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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return string
     */
    protected function code($phone, $region, $city = null): string
    {
        if ($city && Str::startsWith($phone, ($region . $city))) {
            return (string) $city;
        }

        foreach ($this->config('codes', []) as $code) {
            $len_region = Str::length($region);
            $len_code   = Str::length((string) $code);

            if (Str::substr($phone, $len_region, $len_code) === (string) $code) {
                return (string) $code;
            }
        }

        return Str::substr((string) $phone, 1, 3);
    }

    /**
     * Obtain the region code (country).
     *
     * @param $phone
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return bool|int|string
     */
    protected function region($phone)
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
     * @param  int|string  $value
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return int
     */
    protected function replaceRegion($value)
    {
        $regions = $this->config('replaces_country', []);

        return (int) Arr::get($regions, $value, $value);
    }

    /**
     * Splitting a phone number into groups.
     *
     * @param  string  $phone
     * @param  string  $divider
     *
     * @return string
     */
    protected function split(string $phone, string $divider = '-'): string
    {
        $length = Str::length((string) $phone);

        if ($length <= 4) {
            return $phone;
        }

        if ($length == 7) {
            $tmp = [Str::substr($phone, 0, 3)];
            $tmp = array_merge($tmp, str_split(Str::substr($phone, 3), 2));

            return implode($divider, $tmp);
        }

        return implode($divider, str_split($phone, 3));
    }

    /**
     * Attaching the phone code of the city.
     *
     * @param  int|null  $code
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function phoneCode(string $phone, $code = null): array
    {
        if (Str::length($phone) <= 4) {
            return [];
        }

        if (Str::length($phone) <= 7) {
            $region = $this->config('default_country', 7);
            $city   = $code ?: $this->config('default_city', 7);

            return compact('region', 'city');
        }

        $region = $this->region($phone);
        $city   = $this->code($phone, $region, $code);

        return compact('region', 'city');
    }

    /**
     * Checking the "beauty" of the phone number.
     *
     * @return bool
     */
    protected function isBeauty(string $phone)
    {
        $arr = str_split($phone, 3);

        $is_beauty = $arr[0] === $arr[1];

        if (empty($is_beauty)) {
            $is_beauty = ($arr[0] % 10 == 0 || $arr[1] % 10 == 0);
        }

        if (empty($is_beauty)) {
            $sum0 = $this->sum($arr[0]);
            $sum1 = $this->sum($arr[1]);

            $count0 = count(array_unique(str_split((string) $arr[0])));
            $count1 = count(array_unique(str_split((string) $arr[1])));

            $is_beauty = ($sum0 == $sum1) || ($count0 === 1 && $count1 === 1);
        }

        return $is_beauty;
    }

    /**
     * Calculation of the sum of the digits of a string.
     */
    protected function sum(string $digit = ''): int
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
     * @param  string  $phone
     * @param  array  $phone_code
     * @param  bool  $clear
     *
     * @return array
     */
    protected function format(string $phone, array $phone_code, bool $clear = false): array
    {
        $divider = $clear ? '' : '-';

        if (Str::length($phone) <= 4) {
            return compact('phone');
        }

        if (Str::length($phone) == 5) {
            $arr = str_split(substr($phone, 1), 2);

            $phone = $phone[0] . $divider . implode($divider, $arr);

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        if (Str::length($phone) == 6) {
            $num   = $this->isBeauty($phone) ? 3 : 2;
            $phone = implode($divider, str_split($phone, $num));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        if (Str::length($phone) < 10) {
            $phone = implode($divider, str_split($phone, 3));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        // Mobile phones.
        $prefix = ($phone_code['region'] ?? null) . ($phone_code['city'] ?? null);
        $phone  = Str::substr($phone, Str::length($prefix));

        if ($this->isBeauty($phone)) {
            $phone = implode($divider, str_split($phone, 3));

            $phone_code['phone'] = $phone;

            return $phone_code;
        }

        $phone_code['phone'] = $this->split($phone, $divider);

        return $phone_code;
    }

    protected function compileAttributes(array $attributes = []): string
    {
        if (empty($attributes)) {
            return '';
        }

        $attributes = array_map(function ($key, $value) {
            return sprintf('%s="%s"', $key, $value);
        }, array_keys($attributes), array_values($attributes));

        return ' ' . implode(' ', $attributes);
    }

    protected function getTemplate(bool $is_html = true): string
    {
        $key = $is_html ? 'template_prefix_html' : 'template_prefix_text';

        $template = $this->config($key, '+%s (%s) %s');

        return $this->fixTemplate($template, '+%s (%s) %s');
    }

    protected function getTemplateLink(string $default = '<a href="%s"%s>%s</a>')
    {
        $template = $this->config('template_link', $default);

        return $this->fixTemplate($template, $default);
    }

    protected function fixTemplate(string $template, string $default): string
    {
        return substr_count($template, '%s') == 3
            ? $template
            : $default;
    }
}
