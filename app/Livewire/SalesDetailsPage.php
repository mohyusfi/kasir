<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class SalesDetailsPage extends Component
{
    public string $month = '';
    public int $currentPage;
    public int $offset = 0;
    public int $perPage = 5;
    public int $maxPage;
    public function mount(string $month): void
    {
        $this->month = $month;
        $this->currentPage = 1;

        $totalData = Transaction::select(['id', 'status'])
                                    ->where('status', 'completed')
                                    ->get()->count();

        $this->maxPage = ceil($totalData / $this->perPage);
    }


    public function previousPage()
    {
        $newPage = $this->currentPage - 1;
        $this->currentPage = $newPage <= 0 ? 1 : $newPage;
    }

    public function nextPage()
    {
        $newPage = $this->currentPage + 1;
        $this->currentPage = $newPage >= $this->maxPage ? $this->maxPage : $newPage;
    }

    public function getOffset()
    {
        $offset = ($this->currentPage - 1) * $this->perPage;

        return $offset;
    }

    public function getDataProducts()
    {
        $data = TransactionDetail::select(['id', 'transaction_id', 'variant_id', 'quantity', 'sub_total', 'created_at'])
            ->whereYear('created_at', $this->getDate()->year)
            ->whereMonth('created_at', $this->getDate()->month)
            ->with(['transaction' => function (BelongsTo $query) {
                $query->select(['id', 'cashier_id','totalPrice', 'status'])
                        ->where('status', 'completed');
            }, 'productVariant' => function (BelongsTo $query) {
                $query->select('id', 'product_id', 'color', 'size', 'purchasePrice', 'price');
            }
        ])->get()
            ->whereNotNull('transaction')
            ->groupBy('transaction_id')
            ->skip($this->getOffset())
            ->take($this->perPage);

        return $data;
    }

    public function getDate(): Carbon|null
    {
        $stringDate = '1 ' . $this->month . ' ' . '2025';
        Carbon::setLocale('id');
        return Carbon::createFromFormat('j F Y', $stringDate);
    }

    public function render()
    {
        return view('livewire.sales-details-page')
                    ->with('transactionDatas', $this->getDataProducts());
    }
}
