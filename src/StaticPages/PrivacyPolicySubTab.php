<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\StaticPages;

use Filament\Forms\Components\RichEditor;
use Filament\Support\Icons\Heroicon;
use Islamv\AppSettingsPlugin\Settings\PrivacyPolicySettings;
use Islamv\AppSettingsPlugin\Tabs\SettingsSubTab;

class PrivacyPolicySubTab extends SettingsSubTab
{
    protected int $sort = 10;

    protected bool $translatable = true;

    public function getKey(): string
    {
        return 'privacy-policy';
    }

    public function getLabel(): string
    {
        return __('app-settings::tabs.static_pages.privacy_policy');
    }

    public function getIcon(): string|\BackedEnum
    {
        return Heroicon::OutlinedShieldCheck;
    }

    public static function getParentTabKeyStatic(): string
    {
        return 'static-pages';
    }

    public function getSettingsClass(): string
    {
        return PrivacyPolicySettings::class;
    }

    /**
     * Schema for a single locale tab.
     * The field name 'content' will be mapped to settings->content[locale].
     */
    public function schema(): array
    {
        return [
            RichEditor::make('content')
                ->label(__('app-settings::tabs.static_pages.content'))
                ->fileAttachmentsDisk(config('app-settings.uploads.disk', 'public'))
                ->fileAttachmentsVisibility('public')
                ->columnSpanFull(),
        ];
    }

    /**
     * Load settings: returns array keyed by locale.
     *
     * @return array<string, mixed>
     */
    public function loadSettings(): array
    {
        /** @var PrivacyPolicySettings $settings */
        $settings = app(PrivacyPolicySettings::class);

        return ['content' => $settings->content];
    }

    /**
     * Save settings: data contains ['content' => ['ar' => '...', 'en' => '...']]
     *
     * @param  array<string, mixed>  $data
     */
    public function saveSettings(array $data): void
    {
        /** @var PrivacyPolicySettings $settings */
        $settings = app(PrivacyPolicySettings::class);
        $settings->content = $data['content'] ?? [];
        $settings->save();
    }
}
