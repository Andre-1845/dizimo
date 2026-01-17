<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRequest;
use App\Http\Requests\MemberDonationRequest;
use App\Models\Category;
use App\Models\Donation;
use App\Models\PaymentMethod;
use Illuminate\Http\Request; // Corrigir: usar Illuminate\Http\Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Mostra os detalhes de uma doação
     */
    public function show(Donation $donation)
    {
        // Verifica se o usuário pode visualizar esta doação
        // $this->authorize('view', $donation);

        // Verifica se o membro é dono da doação
        if ($donation->member_id !== Auth::user()->member->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $donation->load(['category', 'paymentMethod', 'user', 'member']);

        return view('members.show_donation', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        // Verifica se o usuário pode editar esta doação
        // $this->authorize('update', $donation);

        // Verifica se o membro é dono da doação
        if ($donation->member_id !== Auth::user()->member->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Verifica se a doação está confirmada
        if ($donation->is_confirmed) {
            return redirect()->route('dashboard.member')
                ->with('error', 'Doações confirmadas não podem ser editadas.');
        }

        $categories = Category::where('type', 'income')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('members.edit_donation', compact('donation', 'categories', 'paymentMethods'));
    }

    /**
     * Atualiza a doação
     */
    public function update(Request $request, Donation $donation)
    {
        // Verifica se o membro é dono da doação
        if ($donation->member_id !== Auth::user()->member->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Verifica se a doação está confirmada
        if ($donation->is_confirmed) {
            return back()->with('error', 'Doações confirmadas não podem ser editadas.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'donation_date' => 'required|date',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Atualiza o comprovante se foi enviado
        if ($request->hasFile('receipt')) {
            // Remove o comprovante antigo se existir
            if ($donation->receipt_path && Storage::disk('public')->exists($donation->receipt_path)) {
                Storage::disk('public')->delete($donation->receipt_path);
            }

            $path = $request->file('receipt')->store('receipts/donations', 'public');
            $validated['receipt_path'] = $path;
        }

        // Atualiza a doação
        $donation->update($validated);

        Log::info('Doação atualizada pelo membro', [
            'donation_id' => $donation->id,
            'user_id' => Auth::id(),
            'member_id' => $donation->member_id
        ]);

        return redirect()->route('member.donations.show', $donation)
            ->with([
                'success' => 'Doação atualizada com sucesso!',
            ]);
    }

    /**
     * Exclui uma doação
     */
    public function destroy(Donation $donation)
    {
        // Verifica se o membro é dono da doação
        if ($donation->member_id !== Auth::user()->member->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Verifica se a doação está confirmada
        if ($donation->is_confirmed) {
            return back()->with('error', 'Doações confirmadas não podem ser excluídas.');
        }

        // Verifica se a doação foi criada a mais de 24 horas (opcional)
        $hoursSinceCreation = $donation->created_at->diffInHours(now());
        if ($hoursSinceCreation > 24) {
            return back()->with('error', 'Doações com mais de 24 horas não podem ser excluídas.');
        }

        // Remove o comprovante do storage se existir
        if ($donation->receipt_path && Storage::disk('public')->exists($donation->receipt_path)) {
            Storage::disk('public')->delete($donation->receipt_path);
        }

        $donationId = $donation->id;
        $memberName = $donation->member->name;

        // Exclui a doação
        $donation->delete();

        Log::info('Doação excluída pelo membro', [
            'donation_id' => $donationId,
            'member_name' => $memberName,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('dashboard.member')
            ->with('success', 'Doação excluída com sucesso!');
    }

    /**
     * Download do comprovante (método opcional)
     */
    public function downloadReceipt(Donation $donation)
    {
        // Verifica se o membro é dono da doação
        if ($donation->member_id !== Auth::user()->member->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Verifica se existe comprovante
        if (!$donation->receipt_path) {
            return back()->with('error', 'Comprovante não disponível.');
        }

        $path = storage_path('app/public/' . $donation->receipt_path);

        if (!file_exists($path)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        return response()->download($path, 'comprovante_' . $donation->id . '.' . pathinfo($path, PATHINFO_EXTENSION));
    }
}