<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateArmaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'index' => 'required|unique:armas',
            'nome' => 'required',
            'alcance' => 'required',
            'dano' => 'required',
            'tipo_de_dano' => 'required',
            'propriedade' => 'required',
        ];

        if ($this->method() == 'PUT') {
            $rules['index'] = "nullable|unique:armas,index,{$this->index},index";
        }

        return $rules;
    }
}
