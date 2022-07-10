<div class="flex justify-center">
    @if($data)
        <span
            class="inline-flex items-center px-1.5 py-0.5 rounded-sm font-medium text-xs leading-5 bg-primary-100 text-primary-700 whitespace-nowrap"
            @if(method_exists($data, 'color')) style="background-color: {{ $data->color() }}30 !important; color: {{ $data->color() }}!important;" @endif
        >
            {{ method_exists($data, 'label') ? $data->label() : $data }}
        </span>
    @endif
</div>
