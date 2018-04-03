<?php

namespace Helldar\BeautifulPhone\Services;

class Config
{
    /**
     * An array with city codes.
     *
     * @var array
     */
    private $codes = [];

    /**
     * An array with country codes from which telephone numbers can begin.
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
     * Loading the configuration section.
     *
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
