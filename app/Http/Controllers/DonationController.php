<?php


namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Member;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['member', 'category', 'paymentMethod'])
            ->orderByDesc('donation_date')
            ->paginate(10);

        return view('donations.index', [
            'menu' => 'donations',
            'donations' => $donations,
        ]);
    }


    public function create()
    {
        return view('donations.create', [
            'menu' => 'donations',
            'members' => Member::orderBy('name')->get(),
            'categories' => Category::where('type', 'income')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id'         => 'nullable|exists:members,id',
            'category_id'       => 'required|exists:categories,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'donation_date'     => 'required|date',
            'amount'            => 'required|numeric|min:0.01',
            'notes'             => 'nullable|string',
            'receipt'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Busca explícita do membro (se houver)
        $member = null;
        if (!empty($data['member_id'])) {
            $member = Member::find($data['member_id']);
        }

        // Upload do comprovante
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')
                ->store('receipts', 'public');
        }

        Donation::create([
            'member_id'         => $member?->id,
            'user_id'           => Auth::id(),
            'category_id'       => $data['category_id'],
            'payment_method_id' => $data['payment_method_id'] ?? null,

            // 🔑 SNAPSHOT HISTÓRICO (FONTE DA VERDADE)
            'donor_name'        => $member?->name ?? 'Doação sem membro',

            'amount'            => $data['amount'],
            'donation_date'     => $data['donation_date'],
            'notes'             => $data['notes'] ?? null,
            'receipt_path'      => $receiptPath,
        ]);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Doação registrada com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //
        return view('donations.show', ['donation' => $donation, 'menu' => 'donations']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
        return view('donations.edit', [
            'menu' => 'donations',
            'donation' => $donation,
            'members' => Member::orderBy('name')->get(),
            'categories' => Category::where('type', 'income')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'member_id'         => 'nullable|exists:members,id',
            'category_id'       => 'required|exists:categories,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'donation_date'     => 'required|date',
            'amount'            => 'required|numeric|min:0.01',
            'notes'             => 'nullable|string',
            'receipt'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Resolve o membro (se houver)
        $member = null;
        if (!empty($data['member_id'])) {
            $member = Member::find($data['member_id']);
        }

        // Upload de novo comprovante (se enviado)
        if ($request->hasFile('receipt')) {

            // remove comprovante antigo (boa prática)
            if ($donation->receipt_path) {
                Storage::disk('public')->delete($donation->receipt_path);
            }

            $data['receipt_path'] = $request->file('receipt')
                ->store('receipts', 'public');
        }

        // 🔑 Atualiza snapshot histórico
        $data['donor_name'] = $member?->name ?? 'Doação sem membro';

        $donation->update($data);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Doação atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Doação removida com sucesso.');
    }
}
