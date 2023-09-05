<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'base_pair_price' => 'float',
        'pair_traded_price' => 'float',

        'trade_size' => 'float',
        'trade_price' => 'float',
    ];
}
