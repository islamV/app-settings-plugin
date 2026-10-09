<x-filament-panels::page>
    <div class="flex flex-col md:flex-row gap-6 md:items-start">
        <!-- Sidebar navigation -->
        <div class="w-full md:w-64 lg:w-72 shrink-0">
            <!-- Mobile Select Navigation -->
            <div class="md:hidden mb-6">
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
            <div class="hidden md:flex sticky top-6 flex-col gap-6">
                <!-- Grouped tabs -->
                @php
                    $groups = $this->getGroupedTabs();
                @endphp
                @foreach($groups as $group => $tabs)
                    <div class="flex flex-col gap-1">
                        @if($group)
                            <h3 class="px-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">
                                {{ $group }}
                            </h3>
                        @endif
                        <ul class="flex flex-col gap-1">
                            @foreach($tabs as $tab)
                                <li>
                                    <button 
                                        type="button" 
                                        wire:click="$set('activeTab', '{{ $tab->getKey() }}')"
                                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium w-full text-left transition-colors {{ $activeTab === $tab->getKey() ? 'bg-gray-100 dark:bg-white/5 text-primary-600 dark:text-primary-500' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-white/10' }}"
                                    >
                                        @if($tab->getIcon())
                                            <x-filament::icon 
                                                :icon="$tab->getIcon()" 
                                                class="w-5 h-5 {{ $activeTab === $tab->getKey() ? 'text-primary-600 dark:text-primary-500' : 'text-gray-400 dark:text-gray-500' }}" 
                                            />
                                        @endif
                                        <span class="flex-1">{{ $tab->getLabel() }}</span>
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
