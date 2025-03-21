<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Utils\SearchProduct;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class DashboardPage extends Component
{
    use SearchProduct, WithPagination, WithoutUrlPagination;

    public ?int $productQty = null;
    public function createTransaction(int $variant_id, TransactionService $transactionService)
    {
        $transactionService->makeTransaction(Auth::user()->id, $variant_id);
        $this->dispatch('$refresh');
    }

    public function deleteOrderedItem(
        int $transaction_id,
        int $variant_id,
        TransactionService $transactionService
    ): void
    {
        $transactionService->deleteItem($transaction_id, $variant_id);
    }

    public function updateItemQty(
        int $transaction_id,
        int $variant_id,
        TransactionService $transactionService
    ): void
    {
        try {
            $this->validate([
                'productQty' => ['required', 'integer', 'min:1']
            ]);

            $transactionService->updateItemQty(
                $transaction_id,
                $variant_id,
                $this->productQty
            );
        } catch (Exception $e) {
            $this->addError('productQty', $e->getMessage());
        }
    }
    public function render()
    {
        $resultSearch = $this->searchProduct();
        $products = !empty($this->inputSearchProduct) ? $resultSearch :
                    Product::select(['id', 'name', 'description', 'category_id'])
                                ->with(['category', 'variants'])
                                ->paginate(2);
        $transaction = Transaction::where("cashier_id", Auth::user()->id)
                                        ->where("status", "pending")->first();
        $transaction_details = $transaction?->details;
        return view('livewire.dashboard-page', [
            'products' => $products,
            'transactions' => $transaction,
            'transaction_details' => $transaction_details,
        ]);
    }
}
