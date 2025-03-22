<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Services\TransactionService;
use Livewire\Attributes\Layout;

class ConfirmTransactionPage extends Component
{
    public int $transactionId;

    public function mount(int $id): void
    {
        $this->transactionId = $id;
    }

    public function confirmTransaction(int $transaction_id, TransactionService $transactionService): void
    {
        try {
            DB::beginTransaction();
            $transactionService->confirmTransaction($transaction_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    #[Layout('layouts.transaction')]
    public function render()
    {
        $transaction = Transaction::find($this->transactionId);
        $transactionDetails = $transaction->details;
        return view('livewire.confirm-transaction-page', [
            'transaction' => $transaction,
            'transactionDetails' => $transactionDetails,
        ]);
    }
}
