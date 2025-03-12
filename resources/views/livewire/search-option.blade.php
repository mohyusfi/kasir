<div>
    <label for="category">Category</label>
    <br>
    <input
        id="category"
        type="text"
        wire:key='{{ $key }}'
        placeholder="{{ $myAttribute['placeholder'] }}"
        wire:model.live.debounce.500ms="search"
        wire:ignore
        class="w-[15em] mt-1 py-2 px-8 text-gray-700 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-[1px]" />

    <div class="w-[15em] rounded-lg  bg-slate-400 absolute">
        @foreach ($result ?? [] as $index => $item)
            @if ($index >= 3)
                @break
            @endif
            <div
                wire:click="sendValue('{{ $item['name'] }}')"
                class="text-center py-2 border-2 border-gray-200 text-slate-50 font-bold rounded-md hover:bg-slate-500 transition-all duration-[0.3s] cursor-pointer">
                {{ $item['name'] }}</div>
        @endforeach
    </div>
</div>