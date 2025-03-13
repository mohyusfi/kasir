<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-table :thead="['id', 'name', 'description', 'quantity', 'price', 'added at', 'action']">
        {{-- @dd($products->all()) --}}
        @foreach ($products->all() ?? [] as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->quantity }}</td>
                <td>Rp. {{ number_format($product->price) }}</td>
                <td>{{ $product->created_at?->diffForHumans() }}</td>
                <td>
                    <button type="button" class="btn">delete</button>
                </td>
            </tr>
        @endforeach
    </x-table>

    <x-daisy-modal>
        <livewire:form-input
            :fields="[
                'name' => [
                    'type' => 'text',
                    'directive' => 'wire:model.live=input.name',
                    'placeholder' => 'Lux'
                ],
                'description' => [
                    'type' => 'text',
                    'directive' => 'wire:model.live=input.description',
                    'placeholder' => 'Lux Adalah sabun mandi'
                ],
                'price' => [
                    'type' => 'text',
                    'directive' => 'wire:model.live=input.price',
                    'placeholder' => '200000'
                ],
                'quantity' => [
                    'type' => 'number',
                    'directive' => 'wire:model.live=input.quantity',
                    'placeholder' => '100'
                ],
                'search' => [
                    'placeholder' => 'Enter Category',
                    'default' => '',
                ]
            ]"
            method="createProduct"
        />
    </x-daisy-modal>
</div>