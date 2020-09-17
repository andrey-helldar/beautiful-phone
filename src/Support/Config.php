<?php

namespace Helldar\BeautifulPhone\Support;

use Illuminate\Support\Facades\Config as IlluminateConfig;

final class Config
{
    protected static $instance;

    public static function isEnabled(): bool
    {
        return self::get('enabled', true);
    }

    public static function countries(array $default = []): array
    {
        return self::get('countries', $default);
    }

    public static function replacesCountry(array $default = []): array
    {
        return self::get('replaces_country', $default);
    }

    public static function codes(array $default = []): array
    {
        return self::get('codes', $default);
    }

    public static function defaultCountry(int $default = 7): int
    {
        return self::get('default_country', $default);
    }

    public static function defaultCity(int $default = 812): int
    {
        return self::get('default_city', $default);
    }

    public static function templatePrefixText(string $default = '+%s (%s) %s'): string
    {
        return self::get('template_prefix_text', $default);
    }

    public static function templatePrefixHtml(string $default = '<span>+%s (%s)</span> %s'): string
    {
        return self::get('template_prefix_html', $default);
    }

    public static function templateLink(string $default = '<a href="tel:%s"%s>%s</a>'): string
    {
        return self::get('template_link', $default);
    }

    public static function get($key, $default = null)
    {
        return self::instance()[$key] ?? $default;
    }

    public static function set($key, $value = null): void
    {
        if (empty(self::$instance)) {
            self::$instance = self::load();
        }

        self::$instance[$key] = $value;
    }

    protected static function instance(): array
    {
        if (empty(self::$instance)) {
            self::$instance = self::load();
        }

        return self::$instance;
    }

    protected static function load(): ?array
    {
        if (self::illuminateExists() && $config = self::illuminate()) {
            return $config;
        }

        return self::local();
    }

    protected static function local(): ?array
    {
        return require realpath(__DIR__ . '/../../config/beautiful_phone.php');
    }

    protected static function illuminate(): ?array
    {
        return IlluminateConfig::get('beautiful_phone');
    }

    protected static function illuminateExists(): bool
    {
        return class_exists(IlluminateConfig::class) && IlluminateConfig::getFacadeApplication();
    }
}
