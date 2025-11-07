<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SesioncronogramaRequest extends FormRequest
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
        return [
			'sesion_id' => 'required',
			'fecha' => 'required',
			'observaciones' => 'string',
			'monto_entregado' => 'required',
			'procesado' => 'required',
        ];
    }
}
