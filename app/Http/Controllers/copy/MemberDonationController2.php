<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Requests\MemberDonationRequest;
use App\Models\Category;
use App\Models\Donation;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

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

    public function store(MemberDonationRequest $request)
    {

        $data = $request->validated();

        $user = Auth::user();
        $data['donor_name'] = $user->member->name;

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

        Log::info('Doação cadastrada', ['user_id' => $user->id]);

        return redirect()
            ->route('dashboard.member')
            ->with('success', 'Doação registrada com sucesso.');
    }

    public function edit(Donation $donation)
    {
        // Verifica se o usuário pode editar esta doação
        // $this->authorize('update', $donation);

        // Verifica se a doação está confirmada
        if ($donation->is_confirmed) {
            return redirect()->route('dashboard.member')
                ->with('error', 'Doações confirmadas não podem ser editadas.');
        }

        $categories = Category::where('type', 'income')->get();
        $paymentMethods = PaymentMethod::get();

        return view('members.edit_donation', compact('donation', 'categories', 'paymentMethods'));
    }

    /**
     * Atualiza a doação
     */
    public function update(Request $request, Donation $donation)
    {
        // Verifica se o usuário pode editar esta doação
        // $this->authorize('update', $donation);

        // Verifica se a doação está confirmada
        if ($donation->is_confirmed) {
            return back()->with('error', 'Doações confirmadas não podem ser editadas.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'donation_date' => 'required|date',
            'payment_method' => 'nullable|string|max:50',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Atualiza a doação
        $donation->update($validated);

        // Atualiza o comprovante se foi enviado
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $donation->receipt_path = $path;
            $donation->save();
        }

        return redirect()->route('dashboard.member')
            ->with('success', 'Doação atualizada com sucesso!');
    }
}