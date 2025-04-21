@props(['placeholder' => 'Enter New Category', 'type', 'result' => null, 'label' => 'category'])

<div>
    <label for="category" class="block">{{ ucfirst($label) }}</label>
    <input
        id="category"
        type="text"
        placeholder="{{ $placeholder }}"
        wire:model.live.debounce.250ms="search"
        autocomplete="off"
        class="w-[15em] mt-1 py-2 px-8 text-gray-700 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-[1px]" />

    <div class="w-[15em] rounded-lg  bg-slate-400 absolute">
        @foreach ($result ?? [] as $index => $item)
            @if ($index >= 3)
                @break
            @endif
            <div
                wire:key='{{ $index }}'
                wire:click="sendValue('{{ $item['name'] }}')"
                class="text-center py-2 border-2 border-gray-200 text-slate-50 font-bold rounded-md hover:bg-slate-500 transition-all duration-[0.3s] cursor-pointer">
                {{ $item['name'] }}</div>
        @endforeach
    </div>
</div>