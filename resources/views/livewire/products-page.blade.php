<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <x-table
        :thead="['#', 'name', 'description', 'category', 'stock', 'size', 'color', 'price', 'added_at', 'action']"
        :hasContent="count($products) > 0 ? true : false">
        @php
            $row = 1;
        @endphp
        @foreach ($products as $index => $product)
            @forelse ($product->variants as $variant)
                <tr wire:key="{{ $product->id }}"
                    x-data="{
                        hidden : 'overflow-hidden block max-h-[10em]',
                        show : false
                    }"
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
                    <td class="text-nowrap">Rp. {{ number_format($variant->price, 2) }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center">
                            <x-action-button
                                btnType=""
                                wire:click="setProduct({{ $variant->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 {{ $showEdit == $variant->id ? 'text-black' : 'text-orange-400' }}">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                  </svg>
                            </x-action-button>
                            <x-action-button
                                btnType=""
                                wire:click="deleteProductVariant({{ $product->id }}, {{ $variant->id }})"
                                wire:confirm="Are you sure delete {{ $product->name }}. variant: {{ $variant->size . ',' . $variant->color . ',' . 'Rp.' . $variant->price }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-red-600">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                  </svg>

                            </x-action-button>
                            <x-daisy-modal
                                btnType=""
                                title="insert new variant {{ $product->name }}"
                                key="{{ $product->id.'_'.$variant->id }}">
                                <x-slot:btnName>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 text-blue-600">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                      </svg>
                                </x-slot:btnName>
                                <x-form-input
                                method="createProductVariant({{ $variant->product_id }})"
                                btnName="create"
                                :fields="[
                                    'stock' => [
                                        'type' => 'number',
                                        'directive' => 'productVariantRequest.stock',
                                        'placeholder' => '100',
                                    ],
                                    'price' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.price',
                                        'placeholder' => '200000'
                                    ],
                                    'color' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.color',
                                        'placeholder' => 'red',
                                    ],
                                    'size' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.size',
                                        'placeholder' => '60ml',
                                    ],
                                ]" />
                            </x-daisy-modal>
                        </div>
                    </td>
                </tr>
            @empty
                <tr wire:key="{{ $product->id }}"
                    x-data="{
                        hidden : 'overflow-hidden block max-h-[10em]',
                        show : false
                    }"
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
                    <td colspan="3" class="text-center"> No Variant</td>
                    <td>0</td>
                    <td class="text-nowrap">{{ $product->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center">
                            <x-daisy-modal
                                btnType=""
                                title="insert new variant {{ $product->name }}"
                                key="{{ $product->id.'_' }}">
                                <x-slot:btnName>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 text-blue-600">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                    </svg>
                                </x-slot:btnName>
                                <x-form-input
                                method="createProductVariant({{ $product->id }})"
                                btnName="create"
                                :fields="[
                                    'stock' => [
                                        'type' => 'number',
                                        'directive' => 'productVariantRequest.stock',
                                        'placeholder' => '100',
                                    ],
                                    'price' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.price',
                                        'placeholder' => '200000'
                                    ],
                                    'color' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.color',
                                        'placeholder' => 'red',
                                    ],
                                    'size' => [
                                        'type' => 'text',
                                        'directive' => 'productVariantRequest.size',
                                        'placeholder' => '60ml',
                                    ],
                                ]" />
                            </x-daisy-modal>
                        </div>
                    </td>
                </tr>
            @endforelse
        @endforeach
    </x-table>

    <div class="mt-4">
        {{ $products->links('vendor.livewire.tailwind', data: ['scrollTo' => false]) }}
    </div>

    <div class="flex {{ $showEdit !== null ? 'justify-evenly md:justify-normal gap-2' : 'justify-evenly' }}">
        <x-daisy-modal
            btnType="btn btn-sm md:btn-sm mt-4 md:mt-0"
            key="1">
            <x-slot:btnName>
                create new product
            </x-slot:btnName>
            <x-form-input
                method="createProduct"
                btnName="create"
                :fields="[
                    'name' => [
                        'type' => 'text',
                        'directive' => 'productRequest.name',
                        'placeholder' => 'Jayrose Gray'
                    ],
                    'stock' => [
                        'type' => 'number',
                        'directive' => 'productRequest.quantity',
                        'placeholder' => '100',
                    ],
                    'price' => [
                        'type' => 'text',
                        'directive' => 'productRequest.price',
                        'placeholder' => '100,000.00'
                    ],
                    'color' => [
                        'type' => 'text',
                        'directive' => 'productRequest.color',
                        'placeholder' => 'red',
                    ],
                    'description' => [
                        'type' => 'textarea',
                        'directive' => 'productRequest.description',
                        'placeholder' => 'Jayrose Gray Adalah prefume'
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
            title="update product"
            btnType="btn btn-sm btn-success md:btn-sm mt-4 md:mt-0"
            key="2">
            <x-slot:btnName>
                update_{{ $productRequest->name }}
            </x-slot:btnName>
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
                        'directive' => 'productRequest.quantity',
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

    @if ($deletedVariant > 0)
        <div class="mt-5">
                <livewire:deleted-product-variant/>
        </div>
    @endif
    </div>
</div>