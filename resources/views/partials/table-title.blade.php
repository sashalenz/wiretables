<span wire:click="sortBy('{{ $name }}')" class="cursor-pointer flex justify-between whitespace-nowrap">
    {!! $title !!}
    @unless($isCurrentSort)
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 ml-2 text-gray-300">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
    @else
        @if($isSortUp)
            <svg class="w-4 h-4 ml-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
            </svg>
        @else
            <svg class="w-4 h-4 ml-2" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"></path>
                </svg>
        @endif
    @endunless
</span>
