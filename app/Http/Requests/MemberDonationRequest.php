<?php

namespace App\Http\Requests;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class MemberDonationRequest extends FormRequest
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
            'category_id'        => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'donation_date'      => ['required', 'date', 'before_or_equal:today'],
            'amount'            => 'required|numeric|min:0.01',
            'notes'             => 'nullable|string',
            'receipt'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Selecione a categoria da doação.',
            'payment_method_id.required' => 'Selecione a forma de pagamento.',
            'donation_date.required' => 'Informe a data da doação.',
            'amount.required' => 'Informe o valor da doação.',
            'amount.min' => 'O valor deve ser maior que zero.',
            'receipt.mimes' => 'O comprovante deve ser PDF ou imagem.',
            'receipt.max' => 'O comprovante pode ter no máximo 2MB.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $donationDate = $this->input('donation_date');

            if (!$donationDate) {
                return;
            }

            $member = auth()->user()?->member;

            if (!$member) {
                return;
            }

            $donationDate = Carbon::parse($donationDate);

            if ($donationDate->lt($member->created_at->startOfDay())) {
                $validator->errors()->add(
                    'donation_date',
                    'A data da colaboração não pode ser anterior ao cadastro do membro.'
                );
            }
        });
    }
}
