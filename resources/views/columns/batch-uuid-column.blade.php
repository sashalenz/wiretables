@if($value)
    <span @if($filter) class="cursor-pointer" @click.prevent="$wire.addFilterOutside('{{ $filter }}', '{{ $value }}')" @endif>
    @svg($icon ?? 'heroicon-o-filter', 'flex-shrink-0 h-4 w-4 text-gray-300 transition ease-in-out duration-150')
</span>
@endif
