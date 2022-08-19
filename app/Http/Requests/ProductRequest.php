<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'condition' => 'required',
            'category_id' => 'required',
            'price' => 'required'
        ];
    }

    /**
     * Custom rule messages.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'title.required' => 'Título é de preenchimento obrigatório',
            'description.required' => 'Descrição é de preenchimento obrigatório',
            'condition.required' => 'Condição é de preenchimento obrigatório',
            'category_id.required' => 'Categoria é de preenchimento obrigatório',
            'price.required' => 'Preço é de preenchimento obrigatório'
        ];
    }
}
