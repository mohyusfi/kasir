<div class="md:mt-20 min-h-[100vh]">
    <div class="bg-white shadow-lg rounded-lg p-6 w-96">
        <h2 class="receipt text-xl font-semibold text-gray-800 mb-4 text-center">Konfirmasi Transaksi</h2>
        <div class="receipt border-t border-b py-4 mb-4">
            <div class="flex justify-between text-gray-600">
                <span>Cashier:</span>
                <span class="font-medium">{{ auth()->user()->name }}</span>
            </div>
            <div class="flex justify-between text-gray-600 mt-2">
                <span class="font-bold">Items :</span>
                {{-- <span class="font-medium">1234-5678-9101</span> --}}
            </div>
            @foreach ($transactionDetails as $item)
                <div class="block text-gray-600 mt-2">
                    <div class="w-full flex justify-between">
                        <span>{{ $item->productVariant->product->name  }}</span>
                        <span class="text-[12px]">Rp. {{ number_format($item->productVariant->price, 2) }}</span>
                    </div>
                    <div class="w-full flex justify-between items-center">
                        <div class="text-[12px] text-gray-400">
                            <span>{{ $item->productVariant->size . " "}}</span>
                            <span>{{ $item->productVariant->color . " "}}</span>
                        </div>
                        <span class="font-medium">x{{ $item->quantity }}</span>
                    </div>
                </div>
            @endforeach
            <div class="flex justify-between text-gray-600 mt-2">
                <span>Total Price:</span>
                <span class="font-medium text-green-600">Rp {{ number_format($transaction->totalPrice, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600 mt-2">
                <span>Date:</span>
                <span class="font-medium">{{ $transaction->created_at }}</span>
            </div>
            <div class="flex justify-between text-gray-600 mt-2">
                <span>Status:</span>
                <span
                    class="font-medium  px-2 rounded-md {{ $transaction->status == "completed" ? 'bg-green-500' : 'bg-orange-300' }}">{{ $transaction->status }}</span>
            </div>
        </div>
        <h2 class="salam text-xl font-semibold text-gray-800 uppercase mb-4 text-center">Terima Kasih Telah Belanja di
            YUSFI SHOP</h2>
        <div class="flex gap-2">
            <button
                type="button"
                class="w-full  text-white py-2 rounded-md {{ $transaction->status == 'completed' ? 'bg-blue-300 hover:bg-blue-300' : 'bg-blue-600 hover:bg-blue-700' }}"
                wire:click="confirmTransaction({{ $transaction->id }})"
                @disabled($transaction->status == 'completed')>Konfirmasi</button>
            @if ($transaction->status === "completed")
            <button class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700"
                onclick="window.print()">PRINT</button>
            @endif
        </div>
        <a href="{{ route('dashboard') }}">
            <button class="w-full my-2 bg-red-600 text-white py-2 rounded-md hover:bg-red-700">BACK</button>
        </a>
    </div>
</div>