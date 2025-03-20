<?php

namespace App\Services\ProductImpl;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Services\TransactionService;

class TransactionServiceImpl implements TransactionService {
    public function makeTransaction(int $cashierId, int $productId, int $variant_id): void
    {
        $transaction = Transaction::where("cashier_id", $cashierId)
                                            ->where("status", "pending")
                                            ->first();
        $variant = ProductVariant::find($variant_id);
        if ($transaction !== null) {
            $isExists = $transaction->products()->where("product_id", $productId)->first();
            if ($isExists === null) {
                $transaction->products()->syncWithoutDetaching([$productId => [
                    "quantity" => 1,
                    "sub_total" => $variant->price,
                ]]);
                $transaction->update(['totalPrice' => $transaction->totalPrice + $variant->price]);
            } else {
                $data = $transaction->products;
                $totalPrice = 0;
                foreach ($data as $value) {
                    $totalPrice += $value->pivot->get()->sum('sub_total');
                    break;
                }
                $quantity = $isExists->pivot->quantity + 1;
                $sub_total = $variant->price * $quantity;
                $transaction->update(['totalPrice' => $totalPrice]);
                $transaction->products()->syncWithoutDetaching([$productId => [
                    'quantity' => $quantity,
                    'sub_total' => $sub_total,
                ]]);
            }
        } else {
            // exceuted
            $result = Transaction::create([
                'cashier_id' => $cashierId,
                'totalPrice' => $variant->price,
            ]);
            $result->products()->syncWithoutDetaching([$productId => [
                'quantity' => 1,
                'sub_total' => $variant->price,
            ]]);
        }
    }
}