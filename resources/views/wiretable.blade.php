<div {{ $attributes->class('flex flex-col') }}>
    <div
        @if(method_exists($this, 'mountWithFiltering'))
            x-data="{ filtersCount: {{ $this->allowedFilters?->count() ?? 0 }}, filtersAreShown: false }"
            x-init="filtersAreShown = {{ $this->filter ? 'true' : 'false' }}"
            @toggle-filter.window="filtersAreShown = !filtersAreShown"
        @endif
    >
        <div class="flex justify-between items-center">
            @if(method_exists($this, 'bootWithSearching') && !$this->disableSearch)
                <div class="lg:max-w-sm flex items-center p-2">
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

            @isset($actions)
                {{ $actions }}
            @endif
        </div>

        @if(method_exists($this, 'mountWithFiltering'))
            <div
                class="flex justify-between bg-white border border-gray-200 px-4 py-2 mb-2 whitespace-nowrap text-gray-700 grid gap-4 grid-cols-12 align-center items-center rounded-sm"
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
                    <div class="cols-span-12 sm:col-span-{{ $filter->getSize() }}">
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


    <div class="overflow-x-auto align-middle inline-block w-full">
        <table class="w-full overflow-x-scroll rounded-sm"
               x-data="{ moving: false }"
        >
            @if($this->withHeader)
                <thead class="border border-gray-200">
                <tr>
                    @foreach($this->columns as $column)
                        <th class="p-2 md:px-4 md:py-3 xl:px-6 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                            @if($column->getWidth())style="width: {{ $column->getWidth() }}%;"@endif
                            wire:key="title-{{ $loop->index }}"
                        >
                            {!! $column->renderTitle() !!}
                        </th>
                    @endforeach
                </tr>
                </thead>
            @endif
            <tbody class="bg-white leading-6 md:leading-5 text-gray-700 border-gray-200 border-x"
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
                    wire:key="row-{{ $row->id }}"
                    class="odd:bg-gray-50"
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
                        <td @class(['p-2 md:px-4 md:py-3 xl:py-4', $column->getClass($row)])
                            wire:key="column-{{ $row->id }}-{{ $loop->index }}"
                        >
                            @if($column->canDisplay($row))
                                {!! $column->renderIt($row) !!}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="p-2 md:px-4 md:py-3 xl:py-4 xl:px-6 whitespace-nowrap border-b border-gray-200" colspan="100">
                        <div class="flex items-center text-gray-500 justify-center">
                            @lang('wiretables::table.table_is_empty')
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="w-full overflow-x-auto">
        {{ $this->data->links() }}
    </div>
</div>
