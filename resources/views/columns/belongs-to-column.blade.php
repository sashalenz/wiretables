@if(method_exists($data, 'getRoute') && $data->hasRoute('show'))
    <a href="{{ route($data->getRoute('show'), $data) }}" class="group inline-flex items-center space-x-1 truncate text-sm leading-5">
        @if($icon !== false)
            @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-4 w-4 text-gray-300 group-hover:text-gray-500 transition ease-in-out duration-150')
        @endif
        <p class="text-cool-gray-600 truncate group-hover:text-cool-gray-900 transition ease-in-out duration-150">
            {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
        </p>
    </a>
@else
    <span class="group inline-flex items-center space-x-1 truncate text-sm leading-5">
        @if($icon !== false)
            @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-4 w-4 text-gray-300')
        @endif
        <p class="text-cool-gray-500 truncate">
            {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
        </p>
    </span>
@endif
