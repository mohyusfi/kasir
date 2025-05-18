<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaginateTest extends TestCase
{

    public function getDate(): Carbon|null
    {
        $stringDate = '1 ' . 'April' . ' ' . '2025';
        Carbon::setLocale('id');
        return Carbon::createFromFormat('j F Y', $stringDate);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $data = TransactionDetail::select(['id', 'transaction_id', 'created_at'])
            ->whereYear('created_at', $this->getDate()->year)
            ->whereMonth('created_at', $this->getDate()->month)
            ->with(['transaction' => function (BelongsTo $query) {
                $query->select(['id', 'status'])
                        ->where('status', 'completed');
            }
        ])->get()->count();

        dump($data / 5);
        self::assertTrue(true);
    }
}
