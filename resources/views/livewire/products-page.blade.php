<div class="max-w-7xl mx-auto sm:px-6 lg:px-8"
        x-data="{
            hidden : 'overflow-hidden block max-h-[10em]',
            show : false
        }">
    <x-table :thead="['#', 'name', 'description', 'category', 'stock', 'size', 'color', 'price', 'added_at', 'action']">
        @php
            $row = 1;
        @endphp
        @foreach ($products as $index => $product)
            @foreach ($product->variants as $variant)
                <tr wire:key="{{ $product->id }}"
                    {{-- class="cursor-pointer" --}}
                    >
                    <td>{{ $row++ }}</td>
                    <td>{{ $product->name }}</td>
                    <td
                        class="text-start md:text-justify leading-6 transition-all duration-[.2] cursor-pointer"
                        x-bind:class="hidden"
                        x-on:click="show = ! show;
                                    console.log(show);
                                    show ? hidden='block max-h-[25em] overflow-y-auto' : hidden='overflow-hidden block max-h-[10em]';"
                    >{{ $product->description }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $variant->stock }}</td>
                    <td>{{ $variant->size }}</td>
                    <td>{{ $variant->color }}</td>
                    <td>Rp. {{ $variant->price }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center">
                            <x-action-button
                                content="edit"
                                btnType="{{ $showEdit == $variant->id ? 'btn btn-xs' : 'btn btn-warning btn-xs' }}"
                                wire:click="setProduct({{ $variant->id }})"/>
                            <x-action-button
                                content="delete"
                                wire:click="deleteProduct({{ $product->id }}, {{ $variant->id }})"
                                wire:confirm="Are you sure delete {{ $product->name }}" />
                            <x-daisy-modal
                                btnType="btn-xs btn-info text-nowrap"
                                btnName="new variant"
                                title="insert new {{ $product->name }}"
                            >
                            <x-form-input
                            method="createProduct"
                            btnName="create"
                            :fields="[
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
                                'size' => [
                                    'type' => 'text',
                                    'directive' => 'productRequest.size',
                                    'placeholder' => '60ml',
                                ],
                            ]" />
                            </x-daisy-modal>
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