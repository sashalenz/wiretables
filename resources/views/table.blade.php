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
        <x-wiretables-wiretable class="py-2 sm:px-4">
            <x-slot name="actions">
                <div class="content-center flex items-center h-6 space-x-2 p-2">
                    @if(method_exists($this, 'mountWithFiltering'))
                        <button
                            class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                            x-show="filtersCount"
                            @click.prevent="filtersAreShown = !filtersAreShown"
                            x-cloak
                        >
                            <svg class="w-5 h-5 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </button>
                    @endif
                    <button
                        class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                        @click.prevent="$wire.call('resetTable')"
                    >
                        <svg class="w-6 h-6 group-hover:text-gray-500 group-focus:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path d="M15.8411 2.66117C14.9679 1.77057 13.5369 1.76012 12.6509 2.63787L3.05249 12.1464C2.16109 13.0295 2.16423 14.4711 3.05948 15.3502L8.15853 20.3577C9.04271 21.226 10.4626 21.2159 11.3343 20.3351L13.1189 18.5317C13.0411 18.2003 13 17.8547 13 17.4995C13 17.1119 13.049 16.7357 13.1412 16.3768L12.7914 16.7303L6.70279 10.6417L13.7066 3.70351C14.0019 3.41093 14.4789 3.41441 14.7699 3.71128L19.68 8.71954C19.9669 9.01216 19.9658 9.48088 19.6775 9.77216L16.3321 13.1526C16.7045 13.0528 17.096 12.9995 17.5 12.9995C17.8389 12.9995 18.1691 13.037 18.4865 13.108L20.7437 10.8273C21.6085 9.95347 21.6118 8.54731 20.7511 7.66943L15.8411 2.66117ZM5.63714 11.6974L11.7362 17.7965L10.2681 19.2799C9.97755 19.5735 9.50426 19.5769 9.20954 19.2875L4.11048 14.28C3.81207 13.9869 3.81102 13.5064 4.10816 13.2121L5.63714 11.6974ZM17.6028 14.001C19.4882 14.0554 21 15.6009 21 17.4995C21 19.4325 19.433 20.9995 17.5 20.9995C15.6136 20.9995 14.0758 19.5072 14.0027 17.6387C14.0011 17.5964 14.0002 17.5538 14 17.5111C14 17.5073 14 17.5034 14 17.4995C14 15.5665 15.567 13.9995 17.5 13.9995C17.5344 13.9995 17.5686 14 17.6028 14.001Z" fill="currentColor"></path>
                        </svg>
                    </button>
                    <button
                        class="p-2 text-gray-400 rounded-full group hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-200 transition ease-in-out duration-150"
                        wire:click.prevent="$refresh"
                        @refresh-table.window="@this.call('$refresh')"
                    >
                        <svg class="w-5 h-5 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                </div>
            </x-slot>
        </x-wiretables-wiretable>
    </div>
</div>
