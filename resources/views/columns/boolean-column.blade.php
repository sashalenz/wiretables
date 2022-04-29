<div class="flex justify-center">
    @if((bool) $data === true)
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="check-circle w-6 h-6 text-green-400">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    @else
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="x-circle w-6 h-6 text-gray-300">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
    @endif
</div>
