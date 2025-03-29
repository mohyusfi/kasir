@props(['model' => 'inputSearchProduct', 'placeholder' => 'Cari sesuatu...'])

<div>
    <input
    type="text"
    id="search"
    placeholder="{{ $placeholder }}"
    wire:model.live.debounce.1000ms="{{ $model }}"
    class="w-[13em] md:w-[20em] px-4 py-2 pl-10 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 outline-none">
</div>