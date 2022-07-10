<div class="flex justify-center">
    @foreach($data as $file)
        <a class="inline-flex items-center font-medium text-xs leading-5 text-primary-700" href="{{ $file->getUrl() }}" target="_blank">
             {{ $file->file_name }}
        </a>
    @endforeach
</div>
