<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-[100vh]">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="flex gap-2 justify-around md:justify-between px-2">
        <x-input-search-product/>
        <x-select-options
            :categories="$productCategory"
            property="selectedCategory"
            :selected="$selectedCategory"/>
    </div>
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
                    <td class="text-nowrap">Rp. {{ number_format($variant->price, 2) }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center w-full justify-center">
                            <x-action-button
                                wire:click='createTransaction({{ $variant->id }})'
                                {{-- x-bind:disabled="{{ $variant->stock <= 0 }}" --}}
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

    <div class="container mx-auto mt-4">
        <!-- Layout Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Section -->
            <div class="bg-white shadow-lg p-6 rounded-2xl">
                <h2 class="text-xl font-semibold mb-4">Produk yang Dipesan</h2>
                <div class="space-y-4">
                    @foreach ($transaction_details ?? [] as $item)
                    <div class="flex items-center border-b pb-4" x-data="{ hidden: false, success: true }">
                        <div class="flex items-center justify-center gap-2">
                            <button
                                wire:click="deleteOrderedItem({{ $item->transaction_id }}, {{ $item->variant_id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-blue-500 hover:text-red-500">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                  </svg>
                            </button>
                            <button
                                x-on:click="hidden = ! hidden; console.log(hidden);">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8"
                                :class="hidden ? 'text-green-800' : 'text-green-500'">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                  </svg>
                            </button>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="font-medium text-gray-800">{{ $item->productVariant->product->name ?? '' }}</p>
                            <p class="text-sm">
                                <span x-show="hidden == false">
                                    size: {{$item->productVariant?->size ?? '' }},
                                </span>
                                <span x-show="hidden == false">
                                    color: {{ $item->productVariant?->color ?? ''}},
                                </span>
                                <span>price/unit: Rp. {{ $item->productVariant?->price ?? ''}}, </span>
                            </p>
                            <p
                                class="text-gray-500 text-sm"
                                x-show="hidden == false">Rp {{ number_format($item->sub_total, 2) }}</p>
                        </div>
                        <p class="font-semibold" x-show="hidden == false">x{{ $item->quantity }}</p>
                        <form
                            class="flex gap-2 items-center" x-show="hidden == true">
                            <div>
                                @error('productQty')
                                    <p class="text-red-600 text-[10px]">{{ $message }}</p>
                                @enderror

                                <x-input
                                    type="text"
                                    name="qty"
                                    :label="false"
                                    placeholder="qty"
                                    wire:model="productQty"
                                    class="w-[5em]"/>
                            </div>
                            <button type="button" x-on:click="
                                const isSuccess = $wire.updateItemQty({{ $item->transaction_id }}, {{ $item->variant_id }});
                                isSuccess.then(data => {
                                    if(data === true) hidden = false;
                                });
                            ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-blue-500 hover:text-blue-700">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                  </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Section -->
            <div class="bg-white shadow-lg p-6 rounded-2xl max-h-[17em]">
                <h2 class="text-xl font-semibold mb-4">Konfirmasi Pembayaran</h2>
                <div class="mb-4">
                    <p class="text-gray-600">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($transactions?->totalPrice, 2) }}</p>
                </div>
                @if ($transactions?->id)
                <a href="{{ route('confirm.transaction', ['id' => $transactions->id]) }}" wire:wire:navigate>
                    <button class="w-full m-1 bg-blue-500 text-white py-2 rounded-xl hover:bg-blue-600 transition">
                        Bayar Sekarang
                    </button>
                </a>
                @endif
                <button
                    class="w-full m-1 bg-red-500 text-white py-2 rounded-xl hover:bg-red-700 transition {{ count($transaction_details ?? []) > 0 ? '' : 'hidden' }}"
                    wire:click="cancelTransaction({{ $transactions?->id }})">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
