<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Donation;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberDonationController extends Controller
{
    public function create()
    {
        $user = Auth::User();

        return view('members.create_donation', [
            'user' => $user,
            'categories' => Category::where('type', 'income')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'donation_date' => 'required|date',
                'amount' => 'required|numeric|min:0.01',
                'notes' => 'nullable|string',
                'receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $user = Auth::user();

            // Upload do comprovante
            if ($request->hasFile('receipt')) {
                $data['receipt_path'] = $request->file('receipt')
                    ->store('receipts/donations', 'public');
            }

            Donation::create([
                ...$data,
                'member_id' => $user->member->id,
                'user_id'   => $user->id,
            ]);

            return redirect()
                ->route('members.dashboard')
                ->with('success', 'Doação registrada com sucesso.');
        } catch (Exception $e) {
            return redirect()
                ->route('members.dashboard')
                ->with('error', 'Doação não registrada. Tente novamente.');
        }
    }
}
