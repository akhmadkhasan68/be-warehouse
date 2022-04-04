<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletRequest;
use App\Repository\OutletRepository;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    private $outletRepository;

    public function __construct(OutletRepository $outletRepository)
    {
        $this->outletRepository = $outletRepository;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->outletRepository->paginate($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function create(OutletRequest $request)
    {
        try {
            $data = $this->outletRepository->create($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function update($id, OutletRequest $request)
    {
        try {
            $data = $this->outletRepository->update($id, $request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function delete($id)
    {
        try {
            $data = $this->outletRepository->delete($id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
