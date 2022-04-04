<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Repository\TransactionRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function index(Request $request)
    {
        try {
            $data = $this->transactionRepository->paginate($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function detail($id)
    {
        try {
            $data = $this->transactionRepository->detail($id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function create(TransactionRequest $request)
    {
        try {
            $data = $this->transactionRepository->create($request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function update($id, TransactionRequest $request)
    {
        try {
            $data = $this->transactionRepository->update($id, $request);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteTransactionDetail($transaction_id, $id)
    {
        try {
            $data = $this->transactionRepository->deleteTransactionDetail($transaction_id, $id);
            return response()->success($data, "OK");
        } catch (\Exception $e) {
            return response()->error($e->getMessage(), $e->getCode());
        }
    }
}
