<div>
    <h2 class="mx-5 md:mx-0 font-bold text-black uppercase text-lg">Pulihkan variant🎯🎯</h2>
    <x-table :hasContent="($products->count() > 0)"
            :thead="['#', 'name', 'color', 'size', 'stock', 'price', 'pulihkan']">
        @php
            $row = 1;
        @endphp
        @foreach ($products as $variant)
        <tr>
            <td>{{ $row++ }}</td>
            <td>{{ $variant->product->name }}</td>
            <td>{{ $variant->color }}</td>
            <td>{{ $variant->size }}</td>
            <td>{{ $variant->stock }}</td>
            <td>Rp. {{ $variant->price }}</td>
            <td>
                <x-action-button
                    btnType="btn btn-sm btn-error"
                    wire:click="restoreVariant({{ $variant->id }})">
                    Pulihkan
                </x-action-button>
            </td>
        </tr>
        @endforeach
    </x-table>
</div>

