<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperatorRequest;
use App\Repository\OperatorRepository;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    private $operatorRepository;

    public function __construct(OperatorRepository $operatorRepository)
    {
        $this->operatorRepository = $operatorRepository;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->operatorRepository->index($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function paginate(Request $request)
    {
        try {
            $data = $this->operatorRepository->paginate($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function create(OperatorRequest $request)
    {
        try {
            $data = $this->operatorRepository->create($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function update($id, OperatorRequest $request)
    {
        try {
            $data = $this->operatorRepository->update($id, $request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function delete($id)
    {
        try {
            $data = $this->operatorRepository->delete($id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
