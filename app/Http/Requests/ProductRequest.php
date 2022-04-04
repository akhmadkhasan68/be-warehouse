<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'category_id' => [
                'required',
                Rule::in(Category::all()->pluck("id"))
            ],
            'unit_id' => [
                'required',
                Rule::in(Unit::all()->pluck("id"))
            ],
            'name' => [
                'required',
                Rule::unique("products")
            ],
            // 'quantity' => [
            //     'required',
            //     'numeric'
            // ],
        ];
    }
}
