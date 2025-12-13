<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[0-9]/',           // Pelo menos um número
                'regex:/[@$!%*#?&]/',      // Pelo menos um caractere especial
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Campo SENHA é obrigatório',
            'password.confirmed' => 'As SENHAS não são iguais !',
            'password.min' => 'Campo SENHA deve ter :min caracteres ou mais',
            'password.regex' => 'A senha deve conter pelo menos um número e um caracter especial.'
        ];
    }
}
