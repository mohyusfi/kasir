<?php

namespace App\Services;

use App\Livewire\Forms\TransactionRequest;

interface TransactionService {
    public function makeTransaction(int $cashierId, int $variant_id): void;
}