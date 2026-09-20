<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.app_name', '');
        $this->migrator->add('general.app_description', '');
        $this->migrator->add('general.app_name', 'Demo App');
        $this->migrator->add('general.app_description', 'Demo App Description');
        $this->migrator->add('general.logo', null);
        $this->migrator->add('general.favicon', null);
        $this->migrator->add('general.support_email', '');
        $this->migrator->add('general.support_phone', '');
        $this->migrator->add('general.support_email', 'demo@gmail.com');
        $this->migrator->add('general.support_phone', '+20 100 000 0000');
    }

    public function down(): void
    {
        $this->migrator->delete('general.app_name');
        $this->migrator->delete('general.app_description');
        $this->migrator->delete('general.logo');
        $this->migrator->delete('general.favicon');
        $this->migrator->delete('general.support_email');
        $this->migrator->delete('general.support_phone');
    }
};
