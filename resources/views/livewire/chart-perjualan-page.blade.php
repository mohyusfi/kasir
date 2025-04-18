<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Charts Penjualan Tahun Ini') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <canvas id="productChart"></canvas>
        <div class="mt-10">
            <div class="mb-2">
                <h1 class="ml-3 font-bold text-gray-800">Detail Transaction status tahun {{ now()->year }}</h1>
            </div>
            <x-table
                :thead="['bulan', 'total success', 'total gagal']"
                :hasContent="true"
                whenEmpty="tidak ada transaksi tahun ini"
            >

            @foreach ($productSales as $item)
                <tr>
                    <td>{{ $months[$loop->index] }}</td>
                    <td>{{ $transactionStatus[$loop->index]['completed'] }}</td>
                    <td>{{ $transactionStatus[$loop->index]['failed'] }}</td>
                </tr>
            @endforeach

            </x-table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('productChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Product Terjual',
                        data: @json($productSales),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }
                }
            });
        });
    </script>
</div>


