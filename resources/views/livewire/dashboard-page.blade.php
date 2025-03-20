<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-input-search-product/>
    <x-table
        :thead="['#', 'name', 'description', 'category', 'stock', 'size', 'color', 'price', 'added_at', 'order']"
        :hasContent="count($products) > 0 ? true : false">
        @php
            $row = 1;
        @endphp
        @foreach ($products ?? [] as $index => $product)
            @foreach ($product->variants as $variant)
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
                    <td class="text-nowrap">Rp. {{ number_format($variant->price, 0) }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center w-full justify-center">
                            <x-action-button
                                wire:click='createTransaction({{ $variant->id }})'
                                btnType="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-10 text-blue-500 hover:text-blue-700 transition-all duration-[.2s]">
                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd"/>
                                      </svg>
                            </x-action-button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </x-table>

    <div class="mt-4">
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>

    <div class="container mx-auto">
        <!-- Layout Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Section -->
            <div class="bg-white shadow-lg p-6 rounded-2xl">
                <h2 class="text-xl font-semibold mb-4">Produk yang Dipesan</h2>
                <div class="space-y-4">
                    @foreach ($transaction_details ?? [] as $item)
                    {{-- @php
                    var_dump($item->quantity);
                    @endphp --}}
                    <div class="flex items-center border-b pb-4">
                        <div class="flex items-center justify-center gap-2">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-blue-500">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                  </svg>
                            </button>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-black">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                  </svg>
                            </button>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="font-medium text-gray-800">{{ $item->productVariant->product->name ?? '' }}</p>
                            <p class="text-sm">
                                <span>size: {{$item->productVariant?->size ?? '' }}, </span>
                                <span>color: {{ $item->productVariant?->color ?? ''}}, </span>
                                <span>price/unit: Rp. {{ $item->productVariant?->price ?? ''}}, </span>
                            </p>
                            <p class="text-gray-500 text-sm">Rp {{ number_format($item->sub_total) }}</p>
                        </div>
                        <p class="font-semibold">x{{ $item->quantity }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Section -->
            <div class="bg-white shadow-lg p-6 rounded-2xl">
                <h2 class="text-xl font-semibold mb-4">Konfirmasi Pembayaran</h2>
                <div class="mb-4">
                    <p class="text-gray-600">Total Pembayaran</p>
                    <p class="text-2xl font-bold">Rp {{ $transactions?->totalPrice }}</p>
                </div>
                <button class="w-full bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>
