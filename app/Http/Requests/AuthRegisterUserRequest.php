<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthRegisterUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/[0-9]/',           // Pelo menos um número
                'regex:/[@$!%*#?&]/',      // Pelo menos um caractere especial
            ],
            'church_id' => 'required|exists:churches,id',
        ];
    }


    public function messages(): array
    {
        return [

            'name.required' => 'Campo NOME é obrigatório',
            'email.required' => 'Campo EMAIL é obrigatório',
            'email.email' => 'Insira um EMAIL válido',
            'email.unique' => 'EMAIL já cadastrado',
            'password.required' => 'Campo SENHA é obrigatório',
            'password.confirmed' => 'As SENHAS não são iguais !',
            'password.min' => 'Campo SENHA deve ter :min caracteres ou mais',
            'password.regex' => 'A senha deve conter pelo menos um número e um caracter especial.',
        ];
    }
}
