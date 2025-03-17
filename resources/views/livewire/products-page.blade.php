<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- @dd($products) --}}
    <x-table :thead="['#', 'name', 'description', 'category', 'stock', 'size', 'color', 'price', 'added_at', 'action']">
        @php
            $row = 1;
        @endphp
        @foreach ($products as $index => $product)
            @foreach ($product->variants as $variant)
                <tr wire:key="{{ $product->id }}">
                    <td>{{ $row++ }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-justify">{{ $product->description }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $variant->stock }}</td>
                    <td>{{ $variant->size }}</td>
                    <td>{{ $variant->color }}</td>
                    <td>Rp. {{ $variant->price }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2">
                            <x-action-button
                                content="edit"
                                btnType="{{ $showEdit == $variant->id ? 'btn btn-xs' : 'btn btn-warning btn-xs' }}"
                                wire:click="setProduct({{ $variant->id }})"/>
                            <x-action-button
                                content="delete"
                                wire:click="deleteProduct({{ $product->id }}, {{ $variant->id }})"
                                wire:confirm="Are you sure delete {{ $product->name }}" />
                        </div>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </x-table>

    <div class="mt-4">
        {{ $products->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
    </div>


    <div class="flex {{ $showEdit !== null ? 'justify-evenly md:justify-normal gap-2' : '' }}">
        <x-daisy-modal
            btnType="btn-md btn-info md:btn-sm mt-2"
            btnName="create new product"
            key="1">
            <x-form-input
                method="createProduct"
                btnName="create"
                :fields="[
                    'name' => [
                        'type' => 'text',
                        'directive' => 'productRequest.name',
                        'placeholder' => 'Lux'
                    ],
                    'stock' => [
                        'type' => 'number',
                        'directive' => 'productRequest.stock',
                        'placeholder' => '100',
                    ],
                    'price' => [
                        'type' => 'text',
                        'directive' => 'productRequest.price',
                        'placeholder' => '200000'
                    ],
                    'color' => [
                        'type' => 'text',
                        'directive' => 'productRequest.color',
                        'placeholder' => 'red',
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'directive' => 'productRequest.description',
                        'placeholder' => 'Lux Adalah sabun mandi'
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
            btnType="btn-md btn-success mt-2 md:btn-sm"
            key="2"
            btnName="update_{{ $productRequest->name }}">
            <x-form-input
                method="updateProduct"
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
</>