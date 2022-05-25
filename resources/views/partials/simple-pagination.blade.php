<nav class="bg-white px-4 py-3 flex border border-gray-200 items-center justify-between sm:px-6">
    <div class="hidden sm:block">
        <p class="text-sm leading-5 text-gray-700">
            @lang('wiretables::table.total', ['from' => $paginator->firstItem() ?? 0, 'to' => $paginator->lastItem(), 'total' => $paginator->total()])
        </p>
    </div>
    @if ($paginator->hasPages())
        <div class="flex-1 flex justify-between sm:justify-end">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">@lang('wiretables::table.previous')</span>
            @else
                <button wire:click="previousPage" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none  focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    @lang('wiretables::table.previous')
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                    @lang('wiretables::table.next')
                </button>
            @else
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">@lang('wiretables::table.next')</span>
            @endif
        </div>
    @endif
</nav>
