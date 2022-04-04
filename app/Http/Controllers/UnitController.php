<?php

namespace App\Http\Controllers;

use App\Repository\UnitRepository;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    private $unitRepository;
    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function index()
    {
        try {
            $data = $this->unitRepository->index();

            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function paginate(Request $request)
    {
        try {
            $data = $this->unitRepository->paginate($request);

            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
