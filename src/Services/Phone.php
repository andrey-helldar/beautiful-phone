<?php

namespace Helldar\BeautifulPhone\Services;

class Phone
{
    /**
     * @var \Helldar\BeautifulPhone\Services\Config
     */
    private $config;

    /**
     * Phone constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * Конвертация буквенных значений номера в цифровые.
     *
     * @param string $phone
     *
     * @return string
     */
    private function convertWords($phone = '')
    {
        $phone   = str_lower($phone);
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
     * Удаление из номера всех символов, кроме цифр.
     *
     * @param string $phone
     *
     * @return string
     */
    private function clear($phone)
    {
        $phone = $this->convertWords($phone);

        return (string) preg_replace("/\D/", '', trim($phone));
    }

    /**
     * Если в телефонном номере найден код города из списка, возвращаем его,
     * иначе думаем что код города состоит из трех цифр.
     *
     * @param $phone
     * @param $region
     *
     * @return bool|string
     */
    private function code($phone, $region)
    {
        foreach ($this->config->get('codes', []) as $code) {
            $len_region = strlen($region);
            $len_code   = strlen((string) $code);

            if (substr($phone, $len_region, $len_code) === (string) $code) {
                return (string) $code;
            }
        }

        return substr($phone, 1, 3);
    }

    /**
     * Получение кода региона (страны).
     *
     * @param $phone
     *
     * @return bool|int|string
     */
    private function region($phone)
    {
        $codes = $this->config->get('countries', []);
        $code  = substr($phone, 0, 1);
        $key   = array_search($code, $codes);

        return $key ? $codes[$key] : $code;
    }

    /**
     * Разбиение телефонного номера на группы.
     *
     * @param $phone
     *
     * @return string
     */
    private function split($phone)
    {
        $length = strlen((string) $phone);

        if ($length <= 4) {
            return $phone;
        }

        if ($length == 7) {
            $tmp = [substr($phone, 0, 3)];
            $tmp = array_merge($tmp, str_split(substr($phone, 3), 2));

            return implode('-', $tmp);
        }

        return implode('-', str_split($phone, 3));
    }

    /**
     * Проверяем параметр шаблона вывода форматированного телефонного номера.
     *
     * @return string
     */
    private function template()
    {
        $default  = '+%s (%s) %s';
        $template = $this->config->get('template', $default);

        if (substr_count($template, '%s') !== 3) {
            return $default;
        }

        return $template;
    }

    /**
     * Проверяем параметр шаблона вывода форматированного телефонного номера.
     *
     * @return string
     */
    private function templateHtml()
    {
        $default  = '<small>+%s (%s)</small> %s';
        $template = $this->config->get('template_html', $default);

        if (substr_count($template, '%s') !== 3) {
            return $default;
        }

        return $template;
    }

    /**
     * Прикрепление телефонного кода города.
     *
     * @param string $phone
     * @param int    $code
     * @param bool   $is_html
     * @param bool   $is_link
     *
     * @return string
     */
    private function phoneCode($phone, $code = 0, $is_html = true, $is_link = false)
    {
        if (!$code || strlen($phone) > 7) {
            return $is_link ? $phone : '';
        }

        $default_country = $this->config->get('country_default', '7');
        $template        = !$is_link ? ($is_html ? '<small>+%s (%s)</small> ' : '+%s (%s) ') : '+%s%s';

        return sprintf($template, $default_country, $code) . ($is_link ? $phone : '');
    }

    /**
     * Проверка "красоты" телефонного номера.
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
     * Вычисление суммы цифр строки.
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
     * Запуск функции форматирования номера.
     *
     * @param      $phone
     * @param int  $phone_code
     * @param bool $is_html
     *
     * @return bool|string
     */
    private function format($phone, $phone_code = 0, $is_html = true)
    {
        $phone      = $this->clear((string) $phone);
        $phone_code = $this->phoneCode($phone, $phone_code, $is_html);

        if (strlen($phone) <= 4) {
            return $phone;
        }

        if (strlen($phone) == 5) {
            $arr   = str_split(substr($phone, 1), 2);
            $phone = $phone[0] . '-' . implode('-', $arr);

            return $phone_code . $phone;
        }

        if (strlen($phone) == 6) {
            $divider = $this->isBeauty($phone) ? 3 : 2;

            return $phone_code . implode('-', str_split($phone, $divider));
        }

        if (strlen($phone) < 10) {
            return $phone_code . implode('-', str_split($phone, 3));
        }

        // Мобильные.
        $region = $this->region($phone);
        $code   = $this->code($phone, $region);
        $phone  = substr($phone, strlen($region . $code));

        $template = $is_html ? $this->templateHtml() : $this->template();

        return sprintf($template, $region, $code, $this->split($phone));
    }

    /**
     * @param mixed $phone
     * @param int   $phone_code
     * @param bool  $is_html
     *
     * @return bool|string
     */
    public function get($phone, $phone_code = 0, $is_html = true)
    {
        if (!$is_html) {
            return $this->format((string) $phone, (string) $phone_code, $is_html);
        }

        $phone_clean = $this->clear((string) $phone);
        $phone_link  = $this->phoneCode($phone_clean, $phone_code, false, true);
        $formatted   = $this->format((string) $phone, $phone_code, $is_html);

        return sprintf($this->config->get('link'), $phone_link, $formatted);
    }
}
