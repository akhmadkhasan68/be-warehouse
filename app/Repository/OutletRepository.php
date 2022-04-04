<?php
namespace App\Repository;

use App\Models\Outlet;
use App\Traits\DatatableTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OutletRepository
{
    public function paginate($request)
    {
        try {
            $query = Outlet::with(['transactions']);

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
            $query = Outlet::with(['transactions'])->get();

            return $query;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function create($request)
    {
        try {
            return Outlet::create($request->toArray());
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function update($id, $request)
    {
        try {
            return Outlet::findOrFail($id)->update($request->toArray());
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function delete($id)
    {
        try {
            return Outlet::findOrFail($id)->delete();
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }
}
