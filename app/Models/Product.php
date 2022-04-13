<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ["category_id", "unit_id", "name", "quantity"];
    protected $appends = ['avg_price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function transaction_detail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getAvgPriceAttribute()
    {
        $product_id = $this->attributes['id'];

        $sumPrice = TransactionDetail::with(['transaction' => function($q){
            $q->whereBetween('date', [Carbon::today()->subDays(30), Carbon::today()]);
        }])->where('product_id', $product_id)->sum('price');

        $totalTransaction = Transaction::whereHas('transaction_detail', function($q) use($product_id){
            $q->where('product_id', $product_id);
        })->whereBetween('date', [Carbon::today()->subDays(30), Carbon::today()])->count();

        return round($sumPrice / ($totalTransaction ?: 1));
    }
}
