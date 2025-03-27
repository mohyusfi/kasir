<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    public $fillable = [
        'cashier_id',
        'totalPrice',
        'status',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
