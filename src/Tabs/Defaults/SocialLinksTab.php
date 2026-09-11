<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Tabs\Defaults;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Islamv\AppSettingsPlugin\Settings\SocialLinksSettings;
use Islamv\AppSettingsPlugin\Tabs\SettingsTab;

class SocialLinksTab extends SettingsTab
{
    protected int $sort = 20;

    public function getKey(): string
    {
        return 'social-links';
    }

    public function getLabel(): string
    {
        return __('app-settings::tabs.social_links.label');
    }

    public function getIcon(): string|\BackedEnum
    {
        return Heroicon::OutlinedShare;
    }

    public function getSettingsClass(): string
    {
        return SocialLinksSettings::class;
    }

    public function schema(): array
    {
        return [
            Repeater::make('links')
                ->label(__('app-settings::tabs.social_links.fields.links'))
                ->addActionLabel(__('app-settings::tabs.social_links.add_link'))
                ->schema([
                    Select::make('name')
                        ->label(__('app-settings::tabs.social_links.fields.name'))
                        ->options($this->getPlatformOptions())
                        ->searchable()
                        ->required(),

                    TextInput::make('url')
                        ->label(__('app-settings::tabs.social_links.fields.url'))
                        ->url()
                        ->required()
                        ->maxLength(2048),
                ])
                ->columns(2)
                ->defaultItems(0)
                ->collapsible()
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function getPlatformOptions(): array
    {
        return [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'whatsapp' => 'WhatsApp',
            'x' => 'X (Twitter)',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube',
            'linkedin' => 'LinkedIn',
            'telegram' => 'Telegram',
            'snapchat' => 'Snapchat',
            'pinterest' => 'Pinterest',
            'threads' => 'Threads',
            'discord' => 'Discord',
        ];
    }
}
