<div class="flex space-x-1">
    @if(method_exists($this, 'getUseSortProperty') && $this->useSort)
        <div class="flex flex-col">
            <button class="focus:outline-none"
                    x-on:click.prevent="$wire.call('moveOrderUp', {{ $id }})"
            >
                <svg class="text-gray-400 w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <button class="focus:outline-none"
                    x-on:click.prevent="$wire.call('moveOrderDown', {{ $id }})"
            >
                <svg class="text-gray-400 w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        <button class="cursor-move focus:outline-none">
            <svg class="text-gray-400 w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
            </svg>
        </button>
    @else
        {{ $data }}
    @endif
</div>
