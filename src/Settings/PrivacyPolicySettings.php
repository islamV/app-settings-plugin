<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Settings;

use Spatie\LaravelSettings\Settings;

class PrivacyPolicySettings extends Settings
{
    public array $content = [];

    public static function group(): string
    {
        return 'static_pages_privacy_policy';
    }
}
