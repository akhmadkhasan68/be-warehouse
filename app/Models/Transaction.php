<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable = ["operator_id", "outlet_id", "date", "status"];

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function transaction_detail()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
