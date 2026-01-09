<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'user_name'  => 'required|string|max:255',
            'member_name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'phone' => 'nullable|string|min:10|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'user.name.required'  => 'O nome de usuário é obrigatório',
            'member.name.required'  => 'O nome de membro é obrigatório',
            'user.email.required' => 'O e-mail é obrigatório',
            'user.email.email'    => 'Informe um e-mail válido',
            'user.email.unique'   => 'Este e-mail já está em uso',
        ];
    }
}
