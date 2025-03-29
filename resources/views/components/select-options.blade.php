@props(['categories' => [], 'selected' => null, 'property'])

<div class="relative w-64">
    <select
        class="appearance-none w-full bg-white border border-gray-300 text-gray-900 px-4 pr-10 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        wire:model.live.debounce='{{ $property }}'
        wire:key='{{ $selected }}'>
        <option value="">Pilih Kategori</option>
        @forelse ($categories as $category)
            @php
                $category = (object)$category;
            @endphp
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @empty
            <option selected>No Category</option>
        @endforelse
    </select>
    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
        🔽
    </div>
</div>