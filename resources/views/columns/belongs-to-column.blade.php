<div class="flex">
    @if($data)
        @if(method_exists($data, 'getRoute') && $data->hasRoute('show'))
            <a href="{{ route($data->getRoute('show'), $data) }}" class="group inline-flex space-x-2 truncate text-sm leading-5">
                @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-5 w-5 text-cool-gray-400 group-hover:text-cool-gray-500 transition ease-in-out duration-150')
                <p class="text-cool-gray-600 truncate group-hover:text-cool-gray-900 transition ease-in-out duration-150">
                    {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
                </p>
            </a>
        @else
            <span class="group inline-flex space-x-2 truncate text-sm leading-5">
                @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-5 w-5 text-cool-gray-400')
                <p class="text-cool-gray-500 truncate">
                    {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
                </p>
            </span>
        @endif
    @else
        <span class="text-center">-</span>
    @endif
</div>
