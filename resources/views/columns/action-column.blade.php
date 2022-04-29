<div class="relative flex justify-end items-center -m-2">
    @foreach($buttons as $button)
        {!! $button->title(null)->renderIt($row) !!}
    @endforeach
</div>
