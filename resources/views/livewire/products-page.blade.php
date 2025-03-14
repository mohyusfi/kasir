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
                    <div class="flex gap-2">
                        <x-action-button
                            content="edit"
                            btnType="btn btn-warning btn-xs"
                            wire:click='editProduct({{ $product->id }})'/>

                        <x-action-button
                            content="delete"
                            btnType="btn btn-error btn-xs"
                            wire:click='deleteProduct({{ $product->id }})'
                            wire:confirm='ARE YOU SURE TO DELETE {{ $product->name }} ?'/>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>

    <x-daisy-modal
        btnType="btn-sm"
    >
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
            btnName="create"
        />
    </x-daisy-modal>
</div>