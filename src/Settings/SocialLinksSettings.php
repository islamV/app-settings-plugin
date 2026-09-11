<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Settings;

use Spatie\LaravelSettings\Settings;

class SocialLinksSettings extends Settings
{
    public array $links = [];

    public static function group(): string
    {
        return 'social_links';
    }
}
