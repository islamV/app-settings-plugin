<x-filament-panels::page>
    <div class="app-settings-sidebar-wrapper">
        <!-- Sidebar navigation -->
        <div class="app-settings-sidebar-col">
            <!-- Mobile Select Navigation -->
            <div class="app-settings-mobile-dropdown">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="activeTab">
                        @foreach($this->getGroupedTabs() as $group => $tabs)
                            @if($group)
                                <optgroup label="{{ $group }}">
                            @endif
                            @foreach($tabs as $tab)
                                <option value="{{ $tab->getKey() }}">{{ $tab->getLabel() }}</option>
                            @endforeach
                            @if($group)
                                </optgroup>
                            @endif
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <!-- Desktop Vertical Navigation -->
            <div class="app-settings-desktop-nav">
                <!-- Grouped tabs -->
                @php
                    $groups = $this->getGroupedTabs();
                @endphp
                @foreach($groups as $group => $tabs)
                    <div class="app-settings-nav-group">
                        @if($group)
                            <h3 class="app-settings-nav-title">
                                {{ $group }}
                            </h3>
                        @endif
                        <ul class="app-settings-nav-list">
                            @foreach($tabs as $tab)
                                <li>
                                    <button 
                                        type="button" 
                                        wire:click="$set('activeTab', '{{ $tab->getKey() }}')"
                                        class="app-settings-nav-btn {{ $activeTab === $tab->getKey() ? 'is-active' : '' }}"
                                    >
                                        @if($tab->getIcon())
                                            <x-filament::icon 
                                                :icon="$tab->getIcon()" 
                                                class="app-settings-nav-icon" 
                                            />
                                        @endif
                                        <span class="app-settings-nav-text">{{ $tab->getLabel() }}</span>
                                        @if($tab->getBadge())
                                            <x-filament::badge size="sm" :color="$tab->getBadgeColor() ?? 'primary'">
                                                {{ $tab->getBadge() }}
                                            </x-filament::badge>
                                        @endif
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            @php
                $activeTabInstance = collect($this->getAccessibleTabs())->firstWhere(fn ($t) => $t->getKey() === $activeTab);
            @endphp
            @if($activeTabInstance)
                <div class="mb-6">
                    <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-2xl">
                        {{ $activeTabInstance->getLabel() }}
                    </h2>
                    <!-- You could add description to SettingsTab and show it here if desired -->
                </div>
                <hr class="mb-6 border-gray-200 dark:border-white/10" />
            @endif

            <form wire:submit.prevent="save" class="flex flex-col gap-6">
                {{ $this->form }}
            </form>
        </div>
    </div>
</x-filament-panels::page>
