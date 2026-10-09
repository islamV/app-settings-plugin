<?php

declare(strict_types=1);

namespace Islamv\AppSettingsPlugin\Tests\Unit;

use Filament\Facades\Filament;
use Islamv\AppSettingsPlugin\AppSettingsPlugin;
use Islamv\AppSettingsPlugin\Enums\SettingsLayout;
use Islamv\AppSettingsPlugin\Pages\Settings;
use Islamv\AppSettingsPlugin\Tests\TestCase;
use Islamv\AppSettingsPlugin\Tabs\SettingsTab;
use Livewire\Livewire;
use Filament\Panel;

class SettingsPageLayoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $panel = Panel::make()
            ->id('admin')
            ->default()
            ->plugin(AppSettingsPlugin::make()->withoutDefaultTabs());
            
        Filament::registerPanel($panel);
        
        // Filament panels must be set as the current panel
        Filament::setCurrentPanel($panel);
    }
    public function test_default_layout_is_tabs()
    {
        $plugin = AppSettingsPlugin::make();
        $this->assertEquals(SettingsLayout::Tabs, $plugin->getLayout());
    }

    public function test_sidebar_layout_can_be_configured()
    {
        $plugin = AppSettingsPlugin::make()->layout('sidebar');
        $this->assertEquals(SettingsLayout::Sidebar, $plugin->getLayout());
    }

    public function test_page_view_changes_based_on_layout()
    {
        $page = new Settings();
        
        $plugin = filament()->getCurrentPanel()->getPlugin('app-settings');

        $plugin->layout('tabs');
        $this->assertStringContainsString('filament-panels::pages.page', $page->getView());

        $plugin->layout('sidebar');
        $this->assertEquals('app-settings::layouts.sidebar', $page->getView());
    }

    public function test_sidebar_renders_correctly()
    {
        $plugin = filament()->getCurrentPanel()->getPlugin('app-settings');
        $plugin->layout('sidebar')->withoutDefaultTabs();
        
        $tab = $this->makeFakeTab('general', 10);
        $plugin->tab($tab);
        
        $this->bootPlugin($plugin);

        Livewire::test(Settings::class)
            ->assertViewIs('app-settings::layouts.sidebar')
            ->assertSee('Settings') // title in sidebar
            ->assertSee('General') // default tab
            ->assertSet('activeTab', 'general');
    }

    public function test_active_section_syncs_with_url()
    {
        $plugin = filament()->getCurrentPanel()->getPlugin('app-settings');
        $plugin->layout('sidebar')->withoutDefaultTabs();
        
        $plugin->tab($this->makeFakeTab('general', 10));
        $plugin->tab($this->makeFakeTab('social-links', 20));
        
        $this->bootPlugin($plugin);

        Livewire::withQueryParams(['tab' => 'social-links'])
            ->test(Settings::class)
            ->assertSet('activeTab', 'social-links');
    }

    public function test_hidden_or_unauthorized_tabs_do_not_appear()
    {
        $plugin = filament()->getCurrentPanel()->getPlugin('app-settings');
        $plugin->layout('sidebar')->withoutDefaultTabs();

        $tab = $this->makeFakeTab('general', 10)->visible(false);
        $plugin->tab($tab);

        $this->bootPlugin($plugin);

        Livewire::test(Settings::class)
            ->assertDontSeeHtml('>General<');
    }

    private function bootPlugin(AppSettingsPlugin $plugin): void
    {
        app(\Islamv\AppSettingsPlugin\Registry\SettingsRegistry::class)->flush();
        $reflection = new \ReflectionClass($plugin);
        $method = $reflection->getMethod('resolveAndRegisterTabs');
        $method->setAccessible(true);
        $method->invoke($plugin);
    }

    private function makeFakeTab(string $key, int $sort): SettingsTab
    {
        return new class($key, $sort) extends SettingsTab
        {
            public function __construct(
                private readonly string $k,
                private readonly int $s,
            ) {
                $this->sort = $s;
            }

            public function getKey(): string
            {
                return $this->k;
            }

            public function getLabel(): string
            {
                return ucfirst(str_replace('-', ' ', $this->k));
            }

            public function schema(): array
            {
                return [];
            }
            
            public function getSettingsClass(): ?string
            {
                return null;
            }
        };
    }
}
