<?php

namespace App\Services\ServiceImpl;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\ProductVariant;
use App\Models\TransactionDetail;
use App\Services\TransactionService;
use Exception ;

class TransactionServiceImpl implements TransactionService {
    public function makeTransaction(int $cashierId, int $variant_id): void
    {
        $transaction = Transaction::where('cashier_id', $cashierId)
                                    ->where('status', 'pending')->first();
        $productVariant = ProductVariant::find($variant_id);
        $currentQty = $productVariant->stock;
        if ($transaction === null && $productVariant->stock > 0) {
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
            if ($productVariant->stock > 0) {

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

    public function confirmTransaction(int $transaction_id): void
    {
        $transaction = Transaction::find($transaction_id);
        if ($transaction !== null) {
            $transaction->update(['status' => 'completed']);
        }
    }

    public function deleteItem(int $transaction_id, int $variant_id): void
    {
        $transaction = Transaction::find($transaction_id);
        if ($transaction !== null) {
            $item = $transaction->details()->where('variant_id', $variant_id);
            $variantProduct = ProductVariant::find($variant_id);

            $stock = $variantProduct->stock;
            $qty = $item->first()->quantity;
            $sub_total = $item->first()->sub_total;
            $totalPrice = $transaction->totalPrice;

            $item->delete();
            $transaction->update(['totalPrice' => $totalPrice - $sub_total]);
            $variantProduct->update(['stock' => $stock + $qty]);
        }
    }

    public function updateItemQty(int $transaction_id, int $variant_id, int $quantity): void
    {
        $transaction = Transaction::find($transaction_id);
        $variantProduct = ProductVariant::find($variant_id);
        if ($transaction !== null && $transaction->details()->where('variant_id', $variantProduct->id)
        ->first()->quantity !== $quantity)
        {
            $previousStock = $transaction->details()->where('variant_id', $variantProduct->id)
                                    ->first()->quantity + $variantProduct->stock;

            // dd($previousStock);

            if ($previousStock < $quantity) { throw new Exception("stock is not enough"); }

            $sub_total = $variantProduct->price * $quantity;
            // $previousStock = $transaction->details()
            //     ->where('variant_id', $variant_id)
            //     ->first()->quantity + $variantProduct->stock - $quantity;

            $transaction->details()->where('variant_id', $variant_id)->update([
                'quantity' => $quantity,
                'sub_total' => $sub_total,
            ]);

            $totalPrice = $transaction->details->sum('sub_total');

            $variantProduct->update([
                'stock' => $previousStock - $quantity,
            ]);
            $transaction->update([
                'totalPrice' => $totalPrice,
            ]);
        }
    }

    public function cancelTransaction(int $transaction_id): void
    {
        $transaction = Transaction::find($transaction_id);
        if ($transaction !== null) {
            $details = $transaction->details;
            foreach ($details as $item) {
                $productVariant = ProductVariant::find($item->variant_id);
                $productVariant->update([
                    'stock' => $productVariant->stock + $item->quantity
                ]);
            }
            $transaction->update([
                'status' => 'failed',
            ]);
        }
    }
}