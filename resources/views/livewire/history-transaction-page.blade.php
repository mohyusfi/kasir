<div class="container mx-auto p-6 py-0 min-h-[100vh] md:px-10" x-data="{ timezone : '' }"
    x-init="timezone = Intl.DateTimeFormat().resolvedOptions().timeZone; $wire.setTimezone(timezone);">

    <h2 class="text-2xl font-semibold mb-4 text-center">Today</h2>
    <div class="space-y-4">
        @php
            $index = 1;
        @endphp
        @forelse ($transactionToday as $data)
        @php
            $statusColor = [
                'completed' => 'bg-green-500 text-white',
                'failed' => 'bg-red-500 text-white',
                'pending' => 'bg-yellow-500 text-white'];
            $delay = ($index++ - 1) * 300 - 100;
            $animation = $index % 2 === 0 ? 'fade-right' : 'fade-left';
        @endphp
        <div class="bg-white p-4 rounded-lg shadow-md border" data-aos="{{ $animation }}" data-aos-delay="{{ $delay }}">
            <div class="flex justify-between">
                <span class="text-gray-700 font-semibold">ID: {{ $data->id }}</span>
                <span class="text-gray-500 text-sm">
                    {{ $data->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="flex justify-between">
                <div class="mt-2 text-gray-600">
                    <span>Total Harga: </span>
                    <span class="font-bold text-sm">Rp {{ number_format($data->totalPrice, 2) }}</span>
                </div>
                <div class="mt-2">
                    <span class="px-3 py-1 rounded-md {{ $statusColor[$data->status] }}">
                        {{ $data->status }}
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <a href="#"
                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">
                    Detail
                </a>
            </div>
        </div>
        @empty
        <div>
            <h3 class="uppercase text-center">no Transaction Today</h3>
        </div>
        @endforelse
        {{ $transactionToday->links(data: ['scrollTo' => false]) }}
    </div>

    <h2 class="text-2xl font-semibold mb-4 mt-7 text-center">List Transaction</h2>
    <div class="space-y-4">
        @foreach ($transactionAll as $data)
        @php
            $statusColor = [
                'completed' => 'bg-green-500 text-white',
                'failed' => 'bg-red-500 text-white',
                'pending' => 'bg-yellow-500 text-white'];
        @endphp
        <div class="bg-white p-4 rounded-lg shadow-md border" data-aos="fade-up">
            <div class="flex justify-between">
                <span class="text-gray-700 font-semibold">ID: {{ $data->id }}</span>
                <span class="text-gray-500 text-sm">
                    {{ $data->created_at->toFormattedDayDateString() }}
                </span>
            </div>
            <div class="flex justify-between">
                <div class="mt-2 text-gray-600">
                    <span>Total Harga: </span>
                    <span class="font-bold text-sm">Rp {{ number_format($data->totalPrice, 2) }}</span>
                </div>
                <div class="mt-2">
                    <span class="px-3 py-1 rounded-md {{ $statusColor[$data->status] }}">
                        {{ $data->status }}
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <a href="#"
                   class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">
                    Detail
                </a>
            </div>
        </div>
        @endforeach
        {{ $transactionAll->links(data: ['scrollTo' => false]) }}
    </div>
</div>


