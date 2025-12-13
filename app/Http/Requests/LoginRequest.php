<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $login = $this->route('login');

        return [

            'email' => [
                'required',
                'email',
            ],
            'password' => 'required',
        ];
    }


    public function messages(): array
    {
        return [

            'email.required' => 'Campo EMAIL é obrigatório',
            'email.email' => 'Insira um EMAIL válido',

            'password.required' => 'Campo SENHA é obrigatório',

        ];
    }
}
