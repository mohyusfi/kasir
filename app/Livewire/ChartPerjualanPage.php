<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\Attributes\Layout;
use App\Models\TransactionDetail;
use Livewire\Attributes\Computed;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class ChartPerjualanPage extends Component
{
    public array $productSales = [];
    public array $months = [];
    public function mount()
    {
        $data = TransactionDetail::selectRaw('
                    MONTH(transaction_details.created_at) as month_number,
                    SUM(transaction_details.quantity) as sales
            ')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereYear('transaction_details.created_at', now()->year)
            ->where('transactions.status', 'completed') // ⬅️ ambil yg sukses aja
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->pluck('sales', 'month_number'); // [1 => 10, 2 => 12, dst]

        // Siapkan array bulan
        $months = [];
        $sales = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = Carbon::create()->month($i)->format('F'); // "January", "February", etc
            $sales[] = $data->get($i, 0); // ambil penjualan, kalau kosong isi 0
        }

        $this->months = $months;
        $this->productSales = $sales;
    }

    public function getDataStatusTransactions(): array
    {
        // Ambil data hanya status completed dan failed, dikelompokkan per bulan dan status
        $data = Transaction::selectRaw('
                MONTH(created_at) as bulan,
                status,
                COUNT(*) as jumlah
            ')
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['completed', 'failed'])
            ->groupBy('bulan', 'status')
            ->get();

        // Siapkan array hasil awal untuk 12 bulan
        $hasil = [];

        for ($i = 1; $i <= 12; $i++) {
            $hasil[$i] = [
                'completed' => 0,
                'failed' => 0,
            ];
        }

        // Isi hasil dari data query
        foreach ($data as $item) {
            $bulan = $item->bulan;
            $status = $item->status;
            $hasil[$bulan][$status] = $item->jumlah;
        }

        // Ubah index jadi array numerik
        return array_values($hasil);
    }
    public function render()
    {
        return view('livewire.chart-perjualan-page')
            ->with('transactionStatus', $this->getDataStatusTransactions());
    }
}
