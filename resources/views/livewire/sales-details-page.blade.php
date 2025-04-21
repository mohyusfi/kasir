<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100">
    <div class="py-10">
        <div class="flex justify-between">
            <h1 class="font-bold text-gray-600 text-xl">Penjualan success Pada Bulan {{ $month }}</h1>
            <button
                type="button"
                class="bg-gray-300 hover:bg-slate-400 text-black rounded-md px-3 py-1 cursor-pointer"
                onclick="window.history.back()"
            >back</button>
        </div>

        <div class="mt-10">
            <x-table
                :thead="['#', 'product name', 'Harga beli','Harga Jual', 'QTY']"
                :hasContent="$transactionDatas->isNotEmpty()"
                whenEmpty="no transactions on this month"
            >
            @foreach ($transactionDatas as $item)
                <tr class="border-2 border-gray-500" wire:key='{{ uniqid() }}'>
                    <td class="w-[50px] font-bold text-xl text-gray-800">{{ $loop->index+1 }}</td>
                    <td colspan="3">
                        <h1 class="font-bold text-gray-600">ID TRANSACTION -> {{ $item->first()->transaction_id }} ⬇️</h1>
                    </td>
                </tr>
                @foreach ($item as $product)
                    <tr class="border-y-0 border-x-2 border-gray-400 " wire:key='{{ uniqid() }}'>
                        <td class="bg-slate-300 text-gray-900"></td>
                        <td class="bg-slate-300 text-gray-900">{{ $product?->productVariant?->product?->name }}</td>
                        <td class="bg-slate-300 text-gray-900">Rp. {{ number_format($product->productVariant?->purchasePrice, 2) }}</td>
                        <td class="bg-slate-300 text-gray-900">Rp. {{ number_format($product->productVariant?->price, 2) }}</td>
                        <td class="bg-slate-300 text-gray-900">{{ $product->quantity }}</td>
                    </tr>
                @endforeach
            @endforeach
            </x-table>

            <x-pagination/>

            <div class="my-8">
                <p class="font-bold text-xl text-gray-400">Total keutungan: <span>Rp. 100,000</span></p>
            </div>
        </div>
    </div>
</div>