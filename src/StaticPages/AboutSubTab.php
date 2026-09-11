<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\StaticPages;

use Filament\Forms\Components\RichEditor;
use Filament\Support\Icons\Heroicon;
use Islamv\AppSettingsPlugin\Settings\AboutSettings;
use Islamv\AppSettingsPlugin\Tabs\SettingsSubTab;

class AboutSubTab extends SettingsSubTab
{
    protected int $sort = 30;

    protected bool $translatable = true;

    public function getKey(): string
    {
        return 'about';
    }

    public function getLabel(): string
    {
        return __('app-settings::tabs.static_pages.about');
    }

    public function getIcon(): string|\BackedEnum
    {
        return Heroicon::OutlinedInformationCircle;
    }

    public static function getParentTabKeyStatic(): string
    {
        return 'static-pages';
    }

    public function getSettingsClass(): string
    {
        return AboutSettings::class;
    }

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

    public function loadSettings(): array
    {
        /** @var AboutSettings $settings */
        $settings = app(AboutSettings::class);

        return ['content' => $settings->content];
    }

    public function saveSettings(array $data): void
    {
        /** @var AboutSettings $settings */
        $settings = app(AboutSettings::class);
        $settings->content = $data['content'] ?? [];
        $settings->save();
    }
}
