@props(['fields', 'btnName', 'method'])

<div class="p-6 rounded-lg shadow-lg w-full max-w-md" >
    @if (session()->has('message'))
        <x-alert
            :message="session('message')"
            type="alert-success" />
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $index => $message)
            @if ($index === 0)
            <x-alert
                :message="$message"
                type="alert-error" />
            @endif
        @endforeach
    @endif

    <form wire:submit.prevent='{{ $method }}' {{ $attributes->merge() }} >
        @foreach ($fields as $key => $value)
            <div class="mb-4" wire:key='{{ $key }}'>
                @if ($key == 'search')
                    <x-search-category
                        :placeholder="$value['placeholder']"
                        type="text"
                        :result="$value['default']"/>
                @elseif ($value['type'] == 'textarea')
                    <label for="{{ $key }}" class="block font-medium">{{ Str::ucfirst($key) }}</label>
                    <textarea
                        name="{{ $key }}"
                        id="{{ $key }}" rows="3"
                        wire:model="{{ $value['directive'] }}"
                        {{-- wire:key="{{ $key }}" --}}
                        placeholder="{{ $value['placeholder'] ?? '' }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                @else
                    <x-input
                        :name="$key"
                        :label="$key"
                        :placeholder="$value['placeholder']"
                        :type="$value['type']"
                        wire:model="{{ $value['directive'] }}" />
                @endif
            </div>
        @endforeach
        <button
            type="submit"
            class="w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition"
            >{{ $btnName }}</button>
    </form>
</div>