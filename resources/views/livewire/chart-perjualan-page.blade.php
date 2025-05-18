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
            <x-table :thead="['Bulan', 'Total Success', 'Total Gagal', 'Menu']" :hasContent="true" center="text-center"
                whenEmpty="tidak ada transaksi tahun ini">

                @foreach ($productSales as $item)
                    <tr>
                        <td class="text-center">{{ $months[$loop->index] }}</td>
                        <td class="text-center">{{ $transactionStatus[$loop->index]['completed'] }}</td>
                        <td class="text-center">{{ $transactionStatus[$loop->index]['failed'] }}</td>
                        <td align="center">
                            <a type="button" class="bg-gray-400 text-black rounded-md px-3 py-1 cursor-pointer"
                                href="{{ route('SalesDetails', ['month' => $months[$loop->index]]) }}" wire:navigate>show
                                detail</a>
                        </td>
                    </tr>
                @endforeach

            </x-table>
        </div>
    </div>

    <script>
        // Cek apakah MyCart belum dideklarasikan
        if (typeof MyCart === 'undefined') {
            class MyCart {
                constructor() {
                    this.productChartInstance = null;
                }

                renderProductChart() {
                    const ctx = document.getElementById('productChart')?.getContext('2d');
                    if (!ctx) return;

                    if (this.productChartInstance) {
                        this.productChartInstance.destroy();
                    }

                    this.productChartInstance = new Chart(ctx, {
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
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                }
            }

            // Buat instance hanya sekali
            window.productCart = new MyCart();
        }

        // Event listener tidak perlu didaftarkan berkali-kali
        document.addEventListener('DOMContentLoaded', () => window.productCart.renderProductChart());
        document.addEventListener("livewire:navigated", () => {
            console.log("-------------------------------------------------");
            console.log("Livewire navigate selesai, rerender chart...");
            window.productCart.renderProductChart();
        });

    </script>
</div>