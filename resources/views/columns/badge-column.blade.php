<div class="flex justify-center">
    @if($data)
        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5 bg-{{ $data->color() ?? 'gray' }}-100 text-{{ $data->color() ?? 'gray' }}-800">
            {{ $data->title() }}
        </span>
    @endif
</div>
