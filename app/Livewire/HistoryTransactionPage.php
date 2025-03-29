<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class HistoryTransactionPage extends Component
{
    use WithPagination, WithoutUrlPagination;

    public string  $timezone = 'UTC';

    public function setTimezone(string $data)
    {
        $this->timezone = $data;
        session(['user_timezone' => $data]); // Simpan sementara di session
    }

    public function render()
    {
        $transactions = Transaction::select(['id', 'totalPrice', 'status', 'created_at'])
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(5, pageName: 'orderToday_page');
        $transactionToday = Transaction::select(['id', 'totalPrice', 'status', 'created_at'])
                            ->whereDate('created_at', Carbon::today())
                            ->orderBy('created_at', 'desc')
                            ->paginate(5, pageName: 'order_page');
        return view('livewire.history-transaction-page', [
            'transactionAll' => $transactions,
            'transactionToday' => $transactionToday
        ]);
    }
}
