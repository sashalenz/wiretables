<div @class(["flex justify-end items-center"])>
    @foreach($buttons as $button)
        {!! $button->renderIt($row) !!}
    @endforeach
</div>
