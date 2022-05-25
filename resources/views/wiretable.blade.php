<div class="overflow-x-auto align-middle inline-block w-full">
    <table class="w-full overflow-x-scroll rounded-sm"
           x-data="{ moving: false }"
    >
        @if($this->withHeader)
            <thead class="border border-gray-200">
            <tr>
                @foreach($this->columns as $column)
                    <th class="p-2 md:px-4 md:py-3 xl:px-6 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
                        @if($column->getWidth())style="width: {{ $column->getWidth() }}%;"@endif
                        wire:key="title-{{ $loop->index }}"
                    >
                        {!! $column->renderTitle() !!}
                    </th>
                @endforeach
            </tr>
            </thead>
        @endif
        <tbody class="bg-white leading-6 md:leading-5 text-gray-700"
               @if(method_exists($this, 'getUseSortProperty') && $this->useSort)
                   x-on:drop="
                            moving = false
                            const id = event.dataTransfer.getData('text/plain');
                            const target = event.target.closest('tr');
                            $wire.call('updateRowSort', id, target.dataset.id);
                       "
               x-on:drop.prevent="
                            const id = event.dataTransfer.getData('text/plain');
                            const target = event.target.closest('tr');
                            const element = document.getElementById('row-'+id);
                            target.before(element);
                       "
               x-on:dragover.prevent="moving = true"
               x-on:dragleave.prevent="moving = false"
            @endif
        >
        @forelse($this->data->items() as $row)
            <tr id="row-{{ $row->id }}"
                wire:key="row-{{ $row->id }}"
                class="odd:bg-gray-50"
                @if(method_exists($this, 'getUseSortProperty') && $this->useSort)
                    draggable="true"
                    data-id="{{ $row->id }}"
                    x-data="{ dragging: false }"
                    x-on:dragend="dragging = false"
                    x-on:dragstart.self="
                        dragging = true;
                        event.dataTransfer.effectAllowed = 'move';
                        event.dataTransfer.setData('text/plain', event.target.dataset.id);
                    "
                @endif
            >
                @foreach($this->columns as $column)
                    <td @class(['p-2 md:px-4 md:py-3 xl:py-4', $column->getClass($row)])
                        wire:key="column-{{ $row->id }}-{{ $loop->index }}"
                    >
                        @if($column->canDisplay($row))
                            {!! $column->renderIt($row) !!}
                        @endif
                    </td>
                @endforeach
            </tr>
        @empty
            <tr>
                <td class="p-2 md:px-4 md:py-3 xl:py-4 xl:px-6 whitespace-nowrap border-b border-gray-200" colspan="100">
                    <div class="flex items-center text-gray-500 justify-center">
                        @lang('wiretables::table.table_is_empty')
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
