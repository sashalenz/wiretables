<div class="flex items-center" x-data="{ checkAll: false }">
    <input type="checkbox"
           x-ref="checkbox"
           x-model="checkAll"
           @toggle-check.window="checkAll = false"
           @click="$dispatch('toggle-all-check', checkAll)"
           class="form-checkbox h-4 w-4 text-primary-600 transition duration-150 ease-in-out"
    >
</div>
