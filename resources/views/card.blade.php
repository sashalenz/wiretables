<x-admin.card>
    <x-slot name="header">
        {{ $this->title }}
    </x-slot>

    <x-slot name="actions">
        @if(method_exists($this, 'mountWithFiltering') && $this->allowedFilters?->count())
            <button
                class="group h-full px-4 text-gray-400"
                @click.prevent="$dispatch('toggle-filter')"
            >
                <svg class="w-4 h-4 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        @endif
        <button
            class="group h-full px-4 text-gray-400"
            @click.prevent="$wire.call('resetTable')"
        >
            <svg class="w-4 h-4 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                <path d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
            </svg>
        </button>
        <button
            class="group h-full px-4 text-gray-400 !rounded-none"
            wire:click.prevent="$refresh"
            @refresh-table.window="@this.call('$refresh')"
        >
            <svg class="w-4 h-4 group-hover:text-gray-500 group-focus:text-gray-500" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </button>
        @if($this->globalButtons)
            @foreach($this->globalButtons as $button)
                {!! $button->renderIt() !!}
            @endforeach
        @endif
    </x-slot>
    <x-wiretables-wiretable />
</x-admin.card>
