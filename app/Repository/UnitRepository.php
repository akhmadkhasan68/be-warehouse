<?php
namespace App\Repository;

use App\Models\Unit;
use App\Traits\DatatableTrait;

class UnitRepository
{
    public function index(){
        try {
            $query = Unit::with(['products'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function paginate($request)
    {
        try {
            $query = Unit::with(['products']);

            return DatatableTrait::make([
                'name'
            ], $request, $query);
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
}
