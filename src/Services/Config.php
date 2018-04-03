<?php

namespace Helldar\BeautifulPhone\Services;

class Config
{
    /**
     * Массив с кодами городов.
     *
     * @var array
     */
    private $codes = [];

    /**
     * Массив с кодами стран, с которых могут начинаться телефонные номера.
     *
     * @var array
     */
    private $countries = [];

    /**
     * @var string
     */
    private $template = '';

    /**
     * @var string
     */
    private $template_html = '';

    /**
     * @var string
     */
    private $link = '';

    /**
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (!isset($this->{$name}) || !$this->{$name}) {
            $this->{$name} = config('beautiful_phone.' . $name, $default);

            if (is_array($this->{$name})) {
                $this->{$name} = array_values($this->{$name});
            }
        }

        return $this->{$name};
    }
}
