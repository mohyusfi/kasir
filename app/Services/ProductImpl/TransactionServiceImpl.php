<?php

namespace App\Services\ProductImpl;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\TransactionService;

class TransactionServiceImpl implements TransactionService {
    public function makeTransaction(int $cashierId, int $variant_id): void
    {
        $transaction = Transaction::where('cashier_id', $cashierId)
                                    ->where('status', 'pending')->first();
        $productVariant = ProductVariant::find($variant_id);
        $currentQty = $productVariant->stock;
        if ($transaction === null) {
            $transaction = Transaction::create([
                'cashier_id' => $cashierId,
                'totalPrice' => $productVariant->price,
                'status' => 'pending',
            ]);
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'variant_id' => $productVariant->id,
                'quantity' => 1,
                'sub_total' => $productVariant->price,
            ]);
            $productVariant->update([
                'stock' => $currentQty - 1,
            ]);
        } else {
            $details = $transaction->details()->where('transaction_id', $transaction->id)
                                                ->where('variant_id', $productVariant->id)
                                                ->first();
            if ($details === null) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'variant_id' => $productVariant->id,
                    'quantity' => 1,
                    'sub_total' => $productVariant->price,
                ]);
                $productVariant->update([
                    'stock' => $currentQty - 1,
                ]);
                $totalPrice = $transaction->details()->get()->sum('sub_total');
                $transaction->update([
                    'totalPrice' => $totalPrice
                ]);
            } else {
                $qty = $details->quantity + 1;
                $details->update([
                    'quantity' => $qty,
                    'sub_total' => $productVariant->price * $qty,
                ]);
                $productVariant->update([
                    'stock' => $currentQty - 1,
                ]);
                $totalPrice = $transaction->details()->get()->sum('sub_total');
                $transaction->update([
                    'totalPrice' => $totalPrice,
                ]);
            }
        }
    }
}