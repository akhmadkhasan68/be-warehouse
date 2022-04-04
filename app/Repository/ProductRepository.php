<?php
namespace App\Repository;

use App\Models\Product;
use App\Traits\DatatableTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository
{
    public function index()
    {
        try {
            $query = Product::with(['category', 'unit', 'transaction_detail'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
    
    public function paginate($request)
    {
        try {
            $query = Product::with(['category', 'unit', 'transaction_detail']);

            return DatatableTrait::make([
                'name',
                'category.name'
            ], $request, $query);
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function get()
    {
        try {
            $query = Product::with(['category', 'unit', 'transaction_detail'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function create($request)
    {
        try {
            if(empty($request->quantity)) $request->merge(['quantity' => '0']);

            return Product::create($request->toArray());
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function update($id, $request)
    {
        try {
            return Product::findOrFail($id)->update($request->toArray());
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function delete($id)
    {
        try {
            return Product::findOrFail($id)->delete();
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
}
