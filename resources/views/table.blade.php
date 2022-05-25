<div class="max-w-full mx-auto px-4 pt-4">
    <div class="flex flex-wrap w-full justify-between items-center">
        <x-breadcrumbs wire:key="breadcrumbs" wire:ignore />

        @if($this->globalButtons)
            <div class="flex space-x-1 items-center sm:pr-4">
                @foreach($this->globalButtons as $button)
                    {!! $button->renderIt() !!}
                @endforeach
            </div>
        @endif
    </div>
    <div class="mx-auto py-2 animated fadeIn">
        <div class="flex flex-col py-2 sm:px-4">
            <div
                x-data="{ filtersCount: {{ $this->allowedFilters?->count() ?? 0 }}, filtersAreShown: false }"
                x-init="filtersAreShown = {{ $this->filter ? 'true' : 'false' }}"
            >
                <div class="py-2 flex justify-between items-center">
                    @if(!method_exists($this, 'bootWithSearching') || !$this->disableSearch)
                        <div class="lg:max-w-sm flex items-center">
                            <label for="search" class="sr-only">{{ __('wiretables::table.search') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input
                                    id="search"
                                    placeholder="{{ __('wiretables::table.search') }}"
                                    type="search"
                                    value="{{  $this->search }}"
                                    wire:input.debounce.500ms="searchBy($event.target.value)"
                                    class="block w-60 px-8 py-1 border border-gray-200 leading-5 bg-white placeholder-gray-300 focus:outline-none focus:placeholder-gray-400 focus:border-primary-300 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out rounded-sm"
                                >
                                @unless($this->disableStrict)
                                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
                                        <input name="strict"
                                               type="checkbox"
                                               class="appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-primary-500 checked:border-primary-500 focus:outline-none transition duration-200 my-1 align-top bg-no-repeat bg-center bg-contain float-left cursor-pointer"
                                               wire:model="strict"
                                        >
                                    </div>
                                @endunless
                            </div>
                        </div>
                    @endif

                    <div class="content-center flex items-center h-6 space-x-2">
                        <a href="javascript:{}"
                           class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                           x-show="filtersCount"
                           @click.prevent="filtersAreShown = !filtersAreShown"
                           x-cloak
                        >
                            <svg class="w-5 h-5 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </a>
                        <a href="javascript:{}"
                           class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                           @click.prevent="$wire.call('resetTable')"
                        >
                            <svg class="w-5 h-5 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                <path d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                            </svg>
                        </a>
                        <a href="javascript:{}"
                           class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                           wire:click.prevent="$refresh"
                           @refresh-table.window="@this.call('$refresh')"
                        >
                            <svg class="w-5 h-5 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                @if(method_exists($this, 'mountWithFiltering'))
                    <div
                        class="flex justify-between bg-white border border-gray-200 px-4 py-2 mb-2 whitespace-nowrap text-gray-700 grid grid-cols-1 gap-4 sm:grid-cols-6 align-center items-center rounded-sm"
                        x-show="filtersCount && filtersAreShown"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        x-cloak
                    >
                        @foreach($this->allowedFilters as $filter)
                            <div
                                class="col-span-1"
                                @if($filter->isFillable())
                                    @update-{{ $filter->getKebabName() }}.window="event => { $el.querySelectorAll('div[wire\\:id]').forEach((el) => window.Livewire.find(el.getAttribute('wire:id')).emitSelf('fillParent', event.detail.value)) }"
                                @endif
                            >
                                {!! $filter->render() !!}
                            </div>
                        @endforeach
                    </div>
                @endif

                @if(method_exists($this, 'bootWithActions'))
                    <div
                        x-data="window.toggleHandler()"
                        x-show="checked.length"
                        x-cloak
                        @toggle-check.window="toggleCheck($event.detail)"
                        class="flex justify-between bg-white px-6 py-4 mb-2 whitespace-nowrap border-t border-gray-200 last:border-0 text-gray-700 flex flex-wrap w-full align-center items-center"
                        x-transition:enter="transition ease-linear duration-300 transform"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-linear duration-300 transform"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        @foreach($this->actions as $action)
                            @livewire($action->getName(), ['model' => $action->getModel(), 'icon' => $action->getIcon(), 'title' => $action->getTitle(), 'size' => $action->getSize()], key($loop->index))
                        @endforeach
                    </div>
                @endif
            </div>

            <x-wiretables-wiretable />

            <div class="w-full overflow-x-auto">
                {{ $this->data->links() }}
            </div>
        </div>
    </div>
</div>
