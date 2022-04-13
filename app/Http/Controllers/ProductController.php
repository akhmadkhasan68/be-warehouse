<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        try {
            $data = $this->productRepository->index();
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function paginate(Request $request)
    {
        try {
            $data = $this->productRepository->paginate($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function detail($id)
    {
        try {
            $data = $this->productRepository->detail($id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function create(ProductRequest $request)
    {
        try {
            $data = $this->productRepository->create($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function update($id, ProductRequest $request)
    {
        try {
            $data = $this->productRepository->update($id, $request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
    
    public function delete($id)
    {
        try {
            $data = $this->productRepository->delete($id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
