<div class="p-6 rounded-lg shadow-lg w-full max-w-md">
    <form wire:submit.prevent='{{ $method }}'>
        @foreach ($fields as $key => $value)
        <div class="mb-4">
            @if ($key == 'search')
                <livewire:search-option
                    :myAttribute="[
                        'placeholder' => $value['placeholder'],
                        'default' => $value['default'] ?? '',
                    ]"
                />
            @else
                <label for="{{ $key }}" class="block font-medium">{{ Str::ucfirst($key) }}</label>
                <input
                    type="{{ $value['type'] }}"
                    id="{{ $key }}"
                    name="{{ $key }}"
                    autocomplete="off"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ $value['placeholder'] }}"
                    required
                    {{ $value['directive'] }} />

            @endif
        </div>
        @endforeach
        <button type="submit" class="w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition">Submit</button>
    </form>
</div>
