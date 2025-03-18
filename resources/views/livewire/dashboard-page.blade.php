<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-input-search-product/>
    <x-table :thead="['#', 'name', 'description', 'category', 'stock', 'size', 'color', 'price', 'added_at', 'make transaction']">
        @php
            $row = 1;
        @endphp
        @foreach ($products as $index => $product)
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
                    <td>Rp. {{ $variant->price }}</td>
                    <td class="text-nowrap">{{ $variant->created_at->diffForHumans() }}</td>
                    <td>
                        <div class="flex gap-2 items-center w-full justify-center">
                            <x-action-button
                                btnType="btn btn-sm btn-warning text-gray-600"
                                content="add"
                            />
                        </div>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </x-table>

    <div class="mt-4">
        {{ $products->links(data: ['scrollTo' => false]) }}
    </div>
</div>
