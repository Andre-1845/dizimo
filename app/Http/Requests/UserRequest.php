<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     $user = $this->route('user');
    //     return [
    //         //
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,' . ($user ? $user->id : null),
    //         'password' => 'required|min:6',
    //     ];
    // }



    public function rules(): array
    {
        $user = $this->route('user'); /* ?: auth()->user()*/

        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => $this->isMethod('POST')
                ? 'required|confirmed|min:6'
                : 'nullable|confirmed|min:6',
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
        ];
    }
}
