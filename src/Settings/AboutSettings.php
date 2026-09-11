<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Settings;

use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{
    public array $content = [];

    public static function group(): string
    {
        return 'static_pages_about';
    }
}
