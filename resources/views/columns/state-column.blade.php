<div class="flex items-center space-x-1">
    @if($data->color())
        <div class="rounded-full h-3 w-3 border-[3px] border-gray-500" style="border-color: {{ $data->color() }} !important;"></div>
    @endif
    <span class="group inline-flex items-center space-x-1 truncate text-sm leading-5 text-gray-700">
        {{ $data->title() }}
    </span>
</div>
