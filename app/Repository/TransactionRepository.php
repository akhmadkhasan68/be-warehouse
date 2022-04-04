<?php
namespace App\Repository;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Traits\DatatableTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    const TRANSACTION_IN = "in";
    const TRANSACTION_OUT = "out";

    public function paginate($request)
    {
        try {
            $query = Transaction::with(['operator', 'outlet', 'transaction_detail', 'transaction_detail.product'])->whereHas('transaction_detail.product', function($q) use($request){
                $keyword = $request->keyword;
                $q->when(!empty($keyword), function($q) use($keyword){
                    $q->where('id', $keyword);
                });
            });

            return DatatableTrait::make([
                
            ], $request, $query);
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function get()
    {
        try {
            return Transaction::with(['operator', 'outlet', 'transaction_detail', 'transaction_detail.product'])->get();
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function detail($id)
    {
        try {
            return Transaction::with(['operator', 'outlet', 'transaction_detail', 'transaction_detail.product'])->where('id', $id)->firstOrFail();
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::create([
                'operator_id' => $request->operator_id,
                'outlet_id' => $request->outlet_id,
                'date' => $request->date,
                'status' => $request->status
            ]);

            $products = $request->products;
            foreach ($products as $product) {
                $transactionDetailData = [
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['product_id'],
                    'avg_price' => $product['avg_price'],
                    'quantity' => $product['quantity'],
                    'original_quantity' => $product['quantity'],
                ];
                if($request->status == self::TRANSACTION_IN) $transactionDetailData = array_merge($transactionDetailData, ["price" => $product['price']]);

                TransactionDetail::create($transactionDetailData);
                if($request->status == self::TRANSACTION_IN){
                    Product::find($product['product_id'])->increment('quantity', $product['quantity']);
                }else{
                    Product::find($product['product_id'])->decrement('quantity', $product['quantity']);
                }
            }

            DB::commit();

            return $this->detail($transaction->id);
        } catch(ModelNotFoundException $e){
            DB::rollBack();
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; report($e); return false;
        }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            $transaction = Transaction::findOrFail($id);
            $transaction->update([
                'operator_id' => $request->operator_id,
                'outlet_id' => $request->outlet_id,
                'date' => $request->date
            ]);

            $products = $request->products;
            foreach ($products as $product) {
                $transactionDetailData = [
                    'product_id' => $product['product_id'],
                    'avg_price' => $product['avg_price'],
                    'quantity' => $product['quantity'],
                ];
                if($request->status == self::TRANSACTION_IN) $transactionDetailData = array_merge($transactionDetailData, ["price" => $product['price']]);

                $transactionDetailUpdate = TransactionDetail::where([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['product_id']
                ])->firstOrFail();
                $transactionDetailUpdate->update($transactionDetailData);

                if($transaction->status == self::TRANSACTION_IN){
                    Product::findOrFail($product['product_id'])->decrement('quantity', $transactionDetailUpdate->original_quantity);
                    Product::findOrFail($product['product_id'])->increment('quantity', $product['quantity']);
                }else{
                    Product::findOrFail($product['product_id'])->increment('quantity', $transactionDetailUpdate->original_quantity);
                    Product::findOrFail($product['product_id'])->decrement('quantity', $product['quantity']);
                }
                $transactionDetailUpdate->update(['original_quantity' => $product['quantity']]);
            }

            DB::commit();

            return $this->detail($transaction->id);
        } catch(ModelNotFoundException $e){
            DB::rollBack();
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; report($e); return false;
        }
    }

    public function delete($id)
    {
        try {
            return Transaction::findOrFail($id)->delete();
        } catch(ModelNotFoundException $e){
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            throw $e; report($e); return false;
        }
    }

    public function deleteTransactionDetail($transaction_id, $id)
    {
        try {
            DB::beginTransaction();
            $transactionDetail = TransactionDetail::with(['transaction'])->where('transaction_id', $transaction_id)->where('id', $id)->firstOrFail();
            if($transactionDetail->transaction->status == self::TRANSACTION_IN){
                Product::findOrFail($transactionDetail->product_id)->decrement('quantity', $transactionDetail->original_quantity);
            }else{
                Product::findOrFail($transactionDetail->product_id)->increment('quantity', $transactionDetail->original_quantity);
            }
            DB::commit();
        } catch(ModelNotFoundException $e){
            DB::rollBack();
            throw new Exception("Not Found", 404); report($e); return false;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; report($e); return false;
        }
    }
}
