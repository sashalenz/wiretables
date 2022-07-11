@if($data)
    <a href="tel:{{ $data->formatE164() }}" class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium leading-5">
        {{ $data->formatInternational() }}
    </a>
@endif
