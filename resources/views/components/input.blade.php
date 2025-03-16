@props(['type' => 'text', 'name', 'label', 'placeholder' => ''])

<div>
    <label for="{{ $name }}" class="block font-medium text-sm text-gray-700">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-[.8em] w-full']) }}>
</div>