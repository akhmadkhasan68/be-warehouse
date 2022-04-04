<?php
namespace App\Repository;

use App\Models\Category;
use App\Traits\DatatableTrait;

class CategoryRepository
{
    public function index(){
        try {
            $query = Category::with(['products'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function paginate($request)
    {
        try {
            $query = Category::with(['products']);

            return DatatableTrait::make([
                'name'
            ], $request, $query);
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
}
