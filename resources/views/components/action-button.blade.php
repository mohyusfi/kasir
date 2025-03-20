@props(['btnType' => 'btn btn-error btn-xs'])


<div>
    <button
        type="button"
        class="{{ $btnType }}"
        {{ $attributes }}
        >{{ $slot }}</button>
</div>