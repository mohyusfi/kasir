@props(['content', 'btnType'])


<div>
    <button
        type="button"
        class="{{ $btnType }}"
        {{ $attributes->whereStartsWith('wire') }}
        >{{ $content }}</button>
</div>