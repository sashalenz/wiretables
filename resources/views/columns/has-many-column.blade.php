<a
    class="inline-flex items-center rounded-sm border border-gray-300 bg-white px-2 py-1.5 -my-2 text-xs font-semibold leading-4 text-gray-700 hover:bg-gray-50 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
    @if($route)
        href="{{ $filterKey ? route($route, ['filter' => implode(':', [$filterKey, $id])]) : route($route) }}"
        target="_blank"
    @endif
    @disabled(!$route)
>
    {{ $data }}
</a>
