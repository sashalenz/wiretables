<x-admin.card>
    <x-slot name="header">
        {{ $this->title }}
    </x-slot>

    <x-slot name="actions">
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
