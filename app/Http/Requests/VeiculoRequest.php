<?php

namespace App\Http\Requests;

use App\Models\Veiculo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** RN-01: aceita "abc-1d23" e grava "ABC1D23". */
    protected function prepareForValidation(): void
    {
        $placa = preg_replace('/[^A-Za-z0-9]/', '', (string) $this->input('placa'));

        $this->merge(['placa' => strtoupper($placa)]);
    }

    public function rules(): array
    {
        $veiculo = $this->route('veiculo');

        return [
            'placa' => [
                'required',
                'regex:/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/',          // RN-01
                Rule::unique('veiculos', 'placa')->ignore($veiculo?->id), // RN-02
            ],
            'modelo' => ['required', 'string', 'max:80'],                   // RN-05
            'capacidade_kg' => ['required', 'integer', 'min:500', 'max:30000'], // RN-03
            'status' => ['required', Rule::in(array_keys(Veiculo::STATUS))], // RN-04
        ];
    }

    public function messages(): array
    {
        return [
            'placa.required' => 'Informe a placa.',
            'placa.regex' => 'Use o padrão antigo (ABC1234) ou Mercosul (ABC1D23).',
            'placa.unique' => 'Já existe um veículo com essa placa.',
            'modelo.required' => 'Informe o modelo.',
            'modelo.max' => 'O modelo pode ter no máximo :max caracteres.',
            'capacidade_kg.required' => 'Informe a capacidade de carga.',
            'capacidade_kg.integer' => 'A capacidade deve ser um número inteiro de kg.',
            'capacidade_kg.min' => 'A capacidade mínima é :min kg.',
            'capacidade_kg.max' => 'A capacidade máxima é :max kg.',
            'status.required' => 'Escolha a situação.',
            'status.in' => 'Escolha uma situação da lista.',
        ];
    }
}
