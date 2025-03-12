<div>
    {{-- <h1>{{ $input['name'] }}</h1> --}}
    <form wire:submit.prevent='{{ $method }}'>
        @foreach ($fields as $key => $value)
        <div class="mb-4">
            @if ($key == 'search')
                <livewire:search-option/>
            @else
                <label for="{{ $key }}" class="block font-medium">{{ Str::ucfirst($key) }}</label>
                <input
                    type="text"
                    id="{{ $key }}"
                    name="{{ $key }}"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="{{ $value['placeholder'] }}"
                    required
                    {{ $value['directive'] }} />

            @endif
        </div>
        @endforeach
    </form>
</div>
