<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-table :thead="['id', 'name', 'description', 'stock', 'price', 'added at', 'action']">
        @foreach ($products ?? [] as $product)
            <tr wire:key='product-{{ $product->id }}'>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->quantity }}</td>
                <td>Rp. {{ number_format($product->price) }}</td>
                <td>{{ $product->created_at?->diffForHumans() }}</td>
                <td>
                    <div class="flex gap-2">
                        <x-action-button content="edit"
                            btnType="btn {{ ($showEdit == $product->id) ? '' : 'btn-warning' }} btn-xs"
                            wire:click='setProduct({{ $product->id }})' wire:key='{{ uniqid() }}' />
                        <x-action-button content="delete" btnType="btn btn-error btn-xs"
                            wire:click='deleteProduct({{ $product->id }})'
                            wire:confirm='ARE YOU SURE TO DELETE {{ $product->name }} ?' />
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>



    <div class="flex">
        <x-daisy-modal btnType="btn-sm" btnName="create">
            <x-form-input
                method="createProduct"
                btnName="create"
                :fields="[
                    'name' => [
                        'type' => 'text',
                        'directive' => 'productRequest.name',
                        'placeholder' => 'Lux'
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'directive' => 'productRequest.description',
                        'placeholder' => 'Lux Adalah sabun mandi'
                    ],
                    'price' => [
                        'type' => 'text',
                        'directive' => 'productRequest.price',
                        'placeholder' => '200000'
                    ],
                    'stock' => [
                        'type' => 'number',
                        'directive' => 'productRequest.stock',
                        'placeholder' => '100',
                    ],
                    'color' => [
                        'type' => 'text',
                        'directive' => 'productRequest.color',
                        'placeholder' => 'red',
                    ],
                    'size' => [
                        'type' => 'text',
                        'directive' => 'productRequest.size',
                        'placeholder' => '60ml',
                    ],
                    'search' => [
                        'placeholder' => 'Enter Category',
                        'default' => $result,
                    ],
                ]" />
        </x-daisy-modal>

        @if ($showEdit)
        <x-daisy-modal
            btnType="btn-sm btn-success"
            btnName="update_{{ $productRequest->name }}">
            <x-form-input
                method="createProduct"
                wire:key="{{ $showEdit ?? 'nothing' }}"
                btnName="update"
                :fields="[
                    'name' => [
                        'type' => 'text',
                        'directive' => 'productRequest.name',
                        'placeholder' => 'Lux'
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'directive' => 'productRequest.description',
                        'placeholder' => 'Lux Adalah sabun mandi'
                    ],
                    'price' => [
                        'type' => 'text',
                        'directive' => 'productRequest.price',
                        'placeholder' => '200000'
                    ],
                    'stock' => [
                        'type' => 'number',
                        'directive' => 'productRequest.stock',
                        'placeholder' => '100',
                    ],
                    'color' => [
                        'type' => 'text',
                        'directive' => 'productRequest.color',
                        'placeholder' => 'red',
                    ],
                    'size' => [
                        'type' => 'text',
                        'directive' => 'productRequest.size',
                        'placeholder' => '60ml',
                    ],
                    'search' => [
                        'placeholder' => 'Enter Category',
                        'default' => $result,
                    ],
                ]" />
        </x-daisy-modal>
        @endif
    </div>
</div>