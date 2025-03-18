@props(['type' => 'text', 'name', 'label' => '', 'placeholder' => '', 'hidden' => false])

<div>
    <label
        for="{{ $name }}"
        class="font-medium text-sm {{ $hidden ? 'hidden' : 'block' }}">
        {{ ucfirst($label) }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        {{ $hidden ? 'hidden' : '' }}
        {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-[.8em] w-full']) }}>
</div>