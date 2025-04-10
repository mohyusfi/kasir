<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Utils\SearchProduct;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class DashboardPage extends Component
{
    use SearchProduct, WithPagination, WithoutUrlPagination;

    public null|int|string $productQty = null;
    public int|string|null $selectedCategory = null;
    public array $productCategory = [];

    public function mount(): void
    {
        $this->productCategory = Category::select(['id', 'name'])->get()->toArray();
    }
    public function createTransaction(int $variant_id, TransactionService $transactionService)
    {
        try {
            DB::beginTransaction();

            $transactionService->makeTransaction(Auth::user()->id, $variant_id);
            $this->dispatch('$refresh');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function deleteOrderedItem(
        int $transaction_id,
        int $variant_id,
        TransactionService $transactionService
    ): void
    {
        try {
            DB::beginTransaction();
            $transactionService->deleteItem($transaction_id, $variant_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function updateItemQty(
        int $transaction_id,
        int $variant_id,
        TransactionService $transactionService
    ): bool
    {
        try {
            DB::beginTransaction();
            $this->validate([
                'productQty' => ['required', 'integer', 'min:1']
            ]);

            $transactionService->updateItemQty(
                $transaction_id,
                $variant_id,
                $this->productQty
            );
            $this->reset('productQty');
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            $this->addError('productQty', $e->getMessage());
            return false;
        }
    }

    public function cancelTransaction(int $transaction_id, TransactionService $transactionService): void
    {
        try {
            DB::beginTransaction();
            if ($transaction_id !== null) {
                $transactionService->cancelTransaction($transaction_id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function getProducts()
    {
        $product = [];

        if (empty($this->selectedCategory)) {
            $product = Product::select(['id', 'name', 'description', 'category_id'])
                                ->whereHas('variants')
                                ->with(['category', 'variants'])
                                ->paginate(2);
        } else {
            $product = Product::select(['id', 'name', 'description', 'category_id'])
                                ->filterByCategory()
                                ->whereHas('variants')
                                ->with(['category', 'variants'])
                                ->paginate(2);
        }

        return $product;
    }
    public function render()
    {
        Product::$categoryId = $this->selectedCategory;
        $resultSearch = $this->searchProduct();
        $products = !empty($this->inputSearchProduct) ? $resultSearch : $this->getProducts();
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
