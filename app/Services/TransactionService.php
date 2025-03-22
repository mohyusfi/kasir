<?php

namespace App\Services;

use App\Livewire\Forms\TransactionRequest;

interface TransactionService {
    public function makeTransaction(int $cashierId, int $variant_id): void;
    public function deleteItem(int $transaction_id, int $variant_id): void;
    public function updateItemQty(int $transaction_id, int $variant_id, int $quantity): void;
    public function cancelTransaction(int $transaction_id): void;
}