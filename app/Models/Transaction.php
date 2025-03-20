<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    public $timestamps = false;
    public $fillable = [
        'cashier_id',
        'totalPrice',
        'status',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
