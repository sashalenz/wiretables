<div class="bg-white px-4 py-3 flex items-center justify-between sm:px-6">
    <div class="hidden sm:block">
        <p class="text-sm leading-5 text-gray-700">
            @lang('wiretable::table.total', ['from' => $paginator->firstItem() ?? 0, 'to' => $paginator->lastItem() ?? 0, 'total' => $paginator->total()])
        </p>
    </div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="relative z-0 inline-flex shadow-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 text-sm leading-5 font-medium text-gray-500 bg-gray-100 cursor-not-allowed"
                      aria-hidden="true"
                      aria-label="@lang('wiretable::table.previous')"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <button wire:click="previousPage"
                        rel="prev"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        aria-label="@lang('wiretable::table.previous')"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page === $paginator->currentPage())
                            <span class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm leading-5 font-medium text-gray-700 cursor-not-allowed">{{ $page }}</span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                    class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                    aria-label="@lang('wiretable::table.goto_page', ['page' => $page])"
                            >
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button wire:click="previousPage"
                        rel="prev"
                        class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring-primary-500 focus:border-primary-500 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        aria-label="@lang('wiretable::table.next')"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 text-sm leading-5 font-medium text-gray-500 bg-gray-100 cursor-not-allowed"
                      aria-hidden="true"
                      aria-label="@lang('wiretable::table.next')"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </nav>
    @endif
</div>
