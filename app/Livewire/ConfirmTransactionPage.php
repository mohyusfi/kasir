<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class ConfirmTransactionPage extends Component
{
    public int $transactionId;

    public function mount(int $id): void
    {
        $this->transactionId = $id;
    }
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
