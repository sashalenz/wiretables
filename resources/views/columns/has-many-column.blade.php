<a
    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 -my-2 text-sm font-semibold leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
    @if($route)
        href="{{ $filterKey ? route($route, ['filter' => implode(':', [$filterKey, $row->id])]) : route($route) }}"
        target="_blank"
    @endif
    @disabled(!$route)
>
    {{ $data }}
</a>
