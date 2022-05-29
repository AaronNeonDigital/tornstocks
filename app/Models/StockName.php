<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockName extends Model
{
    use HasFactory;

    protected $casts = [
        'benefit' => 'array'
    ];

    public function stock ()
    {
        return $this->hasMany(Stock::class, 'stock_id', 'id');
    }

    public function latest()
    {
        return $this->hasOne(Stock::class, 'stock_id', 'id')->latest();
    }
    public function latestFive()
    {
        return $this->hasMany(Stock::class, 'stock_id', 'id')->orderBy('created_at', 'desc')->limit(60)->pluck('current_price');
    }
}
