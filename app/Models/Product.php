<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'created_at' => 'datetime',
    //     ];
    // }
}
