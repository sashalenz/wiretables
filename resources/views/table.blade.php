@if($this->createButton)
    @push('actions')
        <button
            type="button"
            class="inline-flex items-center md:px-4 p-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:ring-primary-500 focus:ring-2 focus:ring-offset-2 focus:border-primary-500 active:text-gray-800 active:bg-gray-50 transition duration-150 ease-in-out"
            x-data="{ url: '{{ route($this->createButton) }}' }"
            @click.prevent="$dispatch('open-modal', url)"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="hidden md:inline-block ml-2">
                @lang('wiretable::add')
            </span>
        </button>
    @endpush
@endif

<div class="flex flex-col space-y-3">
    <div class="sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8" x-data="{ filtersCount: {{ $this->filters->count() }}, filtersAreShown: false }" x-init="filtersAreShown = {{ $this->filter ? 'true' : 'false' }}">
        <div class="py-2 flex justify-between items-center">
            @if(!$this->disableSearch)
                <div class="lg:max-w-xs">
                    <label for="search" class="sr-only">{{ __('wiretable::table.search') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="search" class="block w-full pl-10 pr-3 py-1 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-primary-300  focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out" placeholder="{{ __('wiretable::table.search') }}" type="search" value="{{  $this->search }}" wire:input.debounce.500ms="searchBy($event.target.value)">
                    </div>
                </div>
            @endif
            <div class="content-center flex items-center h-6 space-x-3">
                <a href="#"
                   class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                   x-show="filtersCount"
                   @click.prevent="filtersAreShown = !filtersAreShown"
                   x-cloak
                >
                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </a>
                <a href="#"
                   class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                   wire:click.prevent="resetTable"
                >
                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        <path d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                    </svg>
                </a>
                <a href="#"
                   class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500"
                   wire:click.prevent="refresh"
                   @refresh-table.window="@this.call('refresh')"
                >
                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div
            class="flex justify-between bg-white shadow sm:rounded-lg px-4 py-2 whitespace-nowrap last:border-0 text-gray-700 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 align-center items-center"
            x-show.transition.opacity="filtersCount && filtersAreShown"
            x-cloak
        >
            @foreach($this->filters as $filter)
                {!! $filter->renderIt() !!}
            @endforeach
        </div>

        <div
            x-data="window.toggleHandler()"
            x-show="checked.length"
            x-cloak
            @toggle-check.window="toggleCheck($event.detail)"
            class="flex justify-between bg-white px-6 py-4 whitespace-nowrap border-t border-gray-200 last:border-0 text-gray-700 flex flex-wrap w-full align-center items-center"
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
    </div>

    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            <table class="min-w-full"
                   x-data="{ moving: false }"
            >
                <thead>
                <tr>
                    @foreach($this->columns as $column)
                        <th class="px-3 py-2 md:px-6 md:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" @if($column->getWidth())style="width: {{ $column->getWidth() }}%;" @endif>
                            {!! $column->renderTitle() !!}
                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody class="bg-white xl:text-base text-sm leading-6 md:leading-5 text-gray-700"
                       @if(method_exists($this, 'getUseSortProperty') && $this->useSort)
                           x-on:drop="
                            moving = false
                            const id = event.dataTransfer.getData('text/plain');
                            const target = event.target.closest('tr');
                            $wire.call('updateRowSort', id, target.dataset.id);
                       "
                       x-on:drop.prevent="
                            const id = event.dataTransfer.getData('text/plain');
                            const target = event.target.closest('tr');
                            const element = document.getElementById('row-'+id);
                            target.before(element);
                       "
                       x-on:dragover.prevent="moving = true"
                       x-on:dragleave.prevent="moving = false"
                    @endif
                >
                @forelse($this->data->items() as $row)
                    <tr id="row-{{ $row->id }}"
                        @if(method_exists($this, 'getUseSortProperty') && $this->useSort)
                            draggable="true"
                            data-id="{{ $row->id }}"
                            x-data="{ dragging: false }"
                            x-on:dragend="dragging = false"
                            x-on:dragstart.self="
                                dragging = true;
                                event.dataTransfer.effectAllowed = 'move';
                                event.dataTransfer.setData('text/plain', event.target.dataset.id);
                            "
                        @endif
                    >
                        @foreach($this->columns as $column)
                            <td class="p-2 md:p-4 xl:px-6 border-b border-gray-200 {{ $column->getClass($row) }}">
                                {!! $column->renderIt($row) !!}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200" colspan="100">
                            <div class="flex items-center text-gray-500 justify-center">
                                @lang('wiretable::table_is_empty')
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $this->data->links() }}
        </div>
    </div>
</div>
