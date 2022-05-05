<div class="relative flex flex-col space-y-0.5">
    @foreach($columns as $column)
        @if($column->canDisplay($row))
            <div @class([$column->getClass($row)])>
                {!! $column->renderIt($row) !!}
            </div>
        @endif
    @endforeach
</div>
