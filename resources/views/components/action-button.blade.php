@props(['content', 'btnType' => 'btn btn-error btn-xs'])


<div>
    <button
        type="button"
        class="{{ $btnType }}"
        {{ $attributes }}
        >{{ $content }}</button>
</div>