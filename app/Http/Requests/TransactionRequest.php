<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Models\Operator;
use App\Models\Outlet;
use App\Models\Product;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        $status = $this->input('status');

        return [
            'operator_id' => [
                'required',
                Rule::in(Operator::all()->pluck('id'))
            ],
            'outlet_id' => [
                'required',
                Rule::in(Outlet::all()->pluck('id'))
            ],
            'date' => [
                'required',
                'date'
            ],
            'status' => [
                'required',
                Rule::in(["in", "out"])
            ],
            "products.*.product_id" => [
                'required',
                'distinct',
                Rule::in(Product::all()->pluck('id'))
            ],
            "products.*.price" => [
                Rule::requiredIf(function() use($status){
                    return $status == "in";
                }),
            ],
            "products.*.avg_price" => 'required',
            "products.*.quantity" => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'operator_id' => 'Operator',
            'outlet_id' => 'Outlet',
            'date' => 'Date',
            'products.*.product_id' => 'Item',
            'products.*.price' => 'Price',
            'products.*.avg_price' => 'Average Price',
            'products.*.quantity' => 'Quantity',
        ];
    }
}
