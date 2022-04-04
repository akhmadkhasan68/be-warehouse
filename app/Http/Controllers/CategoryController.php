<?php

namespace App\Http\Controllers;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $data = $this->categoryRepository->index();

            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function paginate(Request $request)
    {
        try {
            $data = $this->categoryRepository->paginate($request);

            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
