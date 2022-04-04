<?php
namespace App\Repository;

use App\Models\Operator;
use App\Traits\DatatableTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OperatorRepository
{
    public function index($request)
    {
        try {
            $query = Operator::with(['transactions'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
    
    public function paginate($request)
    {
        try {
            $query = Operator::with(['transactions']);

            return DatatableTrait::make([
                'name'
            ], $request, $query);
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function get()
    {
        try {
            $query = Operator::with(['transactions'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function create($request)
    {
        try {
            return Operator::create($request->toArray());
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function update($id, $request)
    {
        try {
            return Operator::findOrFail($id)->update($request->toArray());
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function delete($id)
    {
        try {
            return Operator::findOrFail($id)->delete();
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
}
