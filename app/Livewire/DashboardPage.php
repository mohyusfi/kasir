<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Utils\SearchProduct;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class DashboardPage extends Component
{
    use SearchProduct, WithPagination, WithoutUrlPagination;
    public function createTransaction(int $producId, int $variant_id, TransactionService $transactionService)
    {
        $transactionService->makeTransaction(Auth::user()->id, $producId, $variant_id);
    }
    public function render()
    {
        $resultSearch = $this->searchProduct();
        $products = !empty($this->inputSearchProduct) ? $resultSearch :
                    Product::select(['id', 'name', 'description', 'category_id'])
                                ->with(['category', 'variants'])
                                ->paginate(2);
        $data_transaction = Transaction::where("cashier_id", Auth::user()->id)
                                        ->where("status", "pending")->first();
        return view('livewire.dashboard-page', [
            'products' => $products,
            'transactions' => $data_transaction
        ]);
    }
}
