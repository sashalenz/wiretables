<div class="relative flex flex-col">
    @foreach($columns as $column)
        @if($column->canDisplay($row))
            <div @class([$column->getClass($row)]) wire:key="stack-{{ $row->id }}-{{ $loop->index }}">
                {!! $column->renderIt($row) !!}
            </div>
        @endif
    @endforeach
</div>
