<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Tabs\Defaults;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Islamv\AppSettingsPlugin\Settings\GeneralSettings;
use Islamv\AppSettingsPlugin\Tabs\SettingsTab;

class GeneralSettingsTab extends SettingsTab
{
    protected int $sort = 10;

    public function getKey(): string
    {
        return 'general';
    }

    public function getLabel(): string
    {
        return __('app-settings::tabs.general.label');
    }

    public function getIcon(): string|\BackedEnum
    {
        return Heroicon::OutlinedCog6Tooth;
    }

    public function getSettingsClass(): string
    {
        return GeneralSettings::class;
    }

    public function schema(): array
    {
        return [
            TextInput::make('app_name')
                ->label(__('app-settings::tabs.general.fields.app_name'))
                ->required()
                ->maxLength(255)
                ->columnSpan(1),

            TextInput::make('support_email')
                ->label(__('app-settings::tabs.general.fields.support_email'))
                ->email()
                ->maxLength(255)
                ->columnSpan(1),

            TextInput::make('support_phone')
                ->label(__('app-settings::tabs.general.fields.support_phone'))
                ->tel()
                ->maxLength(50)
                ->columnSpan(1),

            Textarea::make('app_description')
                ->label(__('app-settings::tabs.general.fields.app_description'))
                ->rows(3)
                ->columnSpanFull(),

            FileUpload::make('logo')
                ->label(__('app-settings::tabs.general.fields.logo'))
                ->image()
                ->disk(config('app-settings.uploads.disk', 'public'))
                ->directory(config('app-settings.uploads.directory', 'settings'))
                ->visibility('public')
                ->columnSpan(1),

            FileUpload::make('favicon')
                ->label(__('app-settings::tabs.general.fields.favicon'))
                ->image()
                ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon', 'image/png', 'image/svg+xml'])
                ->disk(config('app-settings.uploads.disk', 'public'))
                ->directory(config('app-settings.uploads.directory', 'settings'))
                ->visibility('public')
                ->columnSpan(1),
        ];
    }
}
