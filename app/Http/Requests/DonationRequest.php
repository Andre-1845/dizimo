<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationRequest extends FormRequest
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
            //
            'member_id'         => ['nullable', 'exists:members,id'],
            'category_id'       => ['required', 'exists:categories,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'donation_date'      => ['required', 'date', 'before_or_equal:today'],
            'amount'            => ['required', 'numeric', 'min:0.01'],
            'notes'             => ['nullable', 'string'],
            'receipt'           => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [


            'category_id.required' => 'Selecione a categoria da despesa.',
            'category_id.exists'   => 'Categoria inválida.',

            'payment_method_id.required' => 'Selecione a forma de pagamento.',
            'payment_method_id.exists'   => 'Forma de pagamento inválida.',

            'donation_date.required' => 'Informe a data da despesa.',
            'donation_date.before_or_equal' => 'A data da despesa não pode ser futura.',

            'amount.required' => 'Informe o valor da despesa.',
            'amount.min'      => 'O valor deve ser maior que zero.',

            'receipt.mimes' => 'O comprovante deve ser PDF ou imagem.',
            'receipt.max'   => 'O comprovante pode ter no máximo 2MB.',
        ];
    }
}
