<div class="whitespace-nowrap" x-data="{ value: false, id: '{{ $id }}' }" x-init="$watch('value', value => $dispatch('toggle-check', {id: id, value: value}) )">
    <label class="inline-flex items-center">
        <input
                type="checkbox"
                class="form-checkbox h-5 w-5 text-primary-500"
                x-model="value"
                @toggle-all-check.window="value = !$event.detail"
        >
    </label>
</div>
