<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use SoftDeletes;
    protected $fillable = ["name"];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
