<div wire:poll>
    <!-- Checkbox Pilih Semua -->
    <label>
        <input type="checkbox" wire:model="selectAll">
        Pilih Semua
    </label>
    <hr>
    <!-- Daftar Checkbox -->
    @foreach ($items as $index => $item)
     @php
         if (count($selected) > 0) {
            $checked = $item['id'] === $selected[$index] ? 'checked' : '';
         }
     @endphp
        <div>
            <label>
                <input
                    type="checkbox"
                    wire:model="selected"
                    value="{{ $item['id'] }}"
                    wire:key='{{ $checked ?? '' }}'
                    {{ $checked ?? '' }}
                    >
                {{ $item['name'] }}
            </label>
            {{-- {{$is = $item['id'] == $selected[$index] ? 'selected' : ''  }} --}}
        </div>
    @endforeach

    <hr>
    <!-- Daftar ID yang Dipilih -->
    <p>Yang dipilih: {{ implode(', ', $selected) }}</p>
</div>
