<div class="flex items-center justify-start">
    @if($route)
        <a
            class="group inline-flex items-center space-x-1 truncate text-sm leading-5"
            href="{{ route($route, $data) }}"
            target="_blank"
        >
            @if($icon !== false)
                <span @if($filter)class="cursor-pointer" @click.prevent="$wire.addFilterOutside('{{ $filter }}', {{ is_object($data) ? $data->id : $data }})" @endif>
                    @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-4 w-4 text-gray-300 transition ease-in-out duration-150')
                </span>
            @endif
            <p class="font-medium truncate transition ease-in-out duration-150">
                @if(is_object($data))
                    {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
                @else
                    {{ $data }}
                @endif
            </p>
        </a>
    @else
        <span
            class="inline-flex items-center space-x-1 truncate text-sm leading-5"
        >
            @if($icon !== false)
                <span @if($filter)class="cursor-pointer" @click.prevent="$wire.addFilterOutside('{{ $filter }}', {{ is_object($data) ? $data->id : $data }})" @endif>
                     @svg($icon ?? 'heroicon-o-link', 'flex-shrink-0 h-4 w-4 text-gray-300')
                </span>
            @endif
            <p class="font-medium truncate">
                @if(is_object($data))
                    {{ method_exists($data, 'getDisplayName') ? $data->getDisplayName() : $data->id }}
                @else
                    {{ $data }}
                @endif
            </p>
        </span>
    @endif
</div>
