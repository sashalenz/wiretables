<div class="relative flex justify-end items-center -m-2">
    @foreach($buttons as $button)
        {!! $button->renderIt($row) !!}
    @endforeach
</div>
