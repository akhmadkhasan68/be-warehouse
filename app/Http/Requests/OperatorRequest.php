<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Validation\Rule;

class OperatorRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('operators')->when($id != null, function($q)use($id){
                    $q->ignore($id);
                })
            ]
        ];
    }
}
