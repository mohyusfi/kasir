<div class="container mx-auto p-6 py-0 min-h-[100vh]" x-data="{ timezone : '' }"
    x-init="timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    $wire.setTimezone(timezone);">
    <h2 class="text-2xl font-semibold mb-4">Today</h2>
    <div class="space-y-4">
        @foreach ($transactionToday as $data)
        @php
            $statusColor = [
                'completed' => 'bg-green-500 text-white',
                'failed' => 'bg-red-500 text-white',
                'pending' => 'bg-yellow-500 text-white'];
        @endphp
        <div class="bg-white p-4 rounded-lg shadow-md border">
            <div class="flex justify-between">
                <span class="text-gray-700 font-semibold">ID: {{ $data->id }}</span>
                <span class="text-gray-500 text-sm">
                    {{ $data->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="flex justify-between">
                <div class="mt-2 text-gray-600">
                    <span>Total Harga: </span>
                    <span class="font-bold">Rp {{ $data->totalPrice }}</span>
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
    </div>

    <h2 class="text-2xl font-semibold mb-4 mt-7">List Transaction</h2>

    <div class="space-y-4">
        @foreach ($transactionAll as $data)
        @php
            $statusColor = [
                'completed' => 'bg-green-500 text-white',
                'failed' => 'bg-red-500 text-white',
                'pending' => 'bg-yellow-500 text-white'];
        @endphp
        <div class="bg-white p-4 rounded-lg shadow-md border">
            <div class="flex justify-between">
                <span class="text-gray-700 font-semibold">ID: {{ $data->id }}</span>
                <span class="text-gray-500 text-sm">
                    {{ $data->created_at->toFormattedDayDateString() }}
                </span>
            </div>
            <div class="flex justify-between">
                <div class="mt-2 text-gray-600">
                    <span>Total Harga: </span>
                    <span class="font-bold">Rp {{ $data->totalPrice }}</span>
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


