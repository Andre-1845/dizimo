<?php


namespace App\Http\Controllers;

use App\Http\Requests\DonationRequest;
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
    public function index(Request $request)
    {

        $this->authorize('viewAny', Donation::class);

        $registrars = User::whereHas('roles', function ($q) {
            $q->where('name', '!=', 'Membro');
        })
            // ->whereHas('donations')
            ->orderBy('name')
            ->get();

        $donations = Donation::query()
            ->with(['member', 'category', 'paymentMethod', 'user'])

            ->when(
                $request->filled('donor_name'),
                fn($q) => $q->where('donor_name', 'like', "%{$request->donor_name}%")
            )

            ->when(
                $request->filled('category_id'),
                fn($q) => $q->where('category_id', $request->category_id)
            )

            ->when(
                $request->filled('payment_method_id'),
                fn($q) => $q->where('payment_method_id', $request->payment_method_id)
            )

            ->when(
                $request->filled('user_id'),
                fn($q) => $q->where('donations.user_id', $request->user_id)
            )

            ->when(
                $request->filled('date_start'),
                fn($q) => $q->whereDate('donation_date', '>=', $request->date_start)
            )

            ->when(
                $request->filled('date_end'),
                fn($q) => $q->whereDate('donation_date', '<=', $request->date_end)
            )

            ->when(
                $request->filled('amount_min'),
                fn($q) => $q->where('amount', '>=', $request->amount_min)
            )

            ->when(
                $request->filled('amount_max'),
                fn($q) => $q->where('amount', '<=', $request->amount_max)
            )

            ->when($request->filled('registered_type'), function ($q) use ($request) {

                if ($request->registered_type === 'self') {
                    $q->whereHas('member', function ($m) {
                        $m->whereColumn('members.user_id', 'donations.user_id');
                    });
                }

                if ($request->registered_type === 'third_party') {
                    $q->whereHas('member', function ($m) {
                        $m->whereColumn('members.user_id', '!=', 'donations.user_id');
                    });
                }

                if ($request->registered_type === 'system') {
                    $q->whereNull('member_id');
                }
            })


            ->orderByDesc('donation_date')
            ->paginate(10)
            ->withQueryString();

        $filters = [
            [
                'type' => 'text',
                'name' => 'donor_name',
                'label' => 'Colaborador',
                'placeholder' => 'Nome do colaborador',
            ],
            [
                'type' => 'select',
                'name' => 'category_id',
                'label' => 'Categoria',
                'options' => Category::where('type', 'income')->orderBy('name')->get(),
                'value' => 'id',
                'labelField' => 'name',
            ],
            [
                'type' => 'select',
                'name' => 'payment_method_id',
                'label' => 'Forma de pagamento',
                'options' => PaymentMethod::orderBy('name')->get(),
                'value' => 'id',
                'labelField' => 'name',
            ],
            [
                'type' => 'select',
                'name' => 'user_id',
                'label' => 'Cadastrado por',
                'options' => $registrars,
                'value' => 'id',
                'labelField' => 'name',
            ],
            [
                'type' => 'select',
                'name' => 'registered_type',
                'label' => 'Tipo de registro',
                'options' => collect([
                    ['id' => 'self', 'name' => 'Pelo próprio membro'],
                    ['id' => 'third_party', 'name' => 'Por terceiro'],
                    ['id' => 'system', 'name' => 'Administração'],
                ]),
                'value' => 'id',
                'labelField' => 'name',
            ],
            [
                'type' => 'date',
                'name' => 'date_start',
                'label' => 'Data inicial',
            ],
            [
                'type' => 'date',
                'name' => 'date_end',
                'label' => 'Data final',
            ],
        ];

        return view('donations.index', compact('donations', 'filters') + [
            'menu' => 'donations',
        ]);
    }




    public function create()
    {

        $this->authorize('create', Donation::class);

        return view('donations.create', [
            'menu' => 'donations',
            'members' => Member::orderBy('name')->get(),
            'categories' => Category::where('type', 'income')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    public function store(DonationRequest $request)
    {

        $this->authorize('create', Donation::class);

        $data = $request->validated();

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
            'donor_name'        => $member?->name ?? 'Administração',

            'amount'            => $data['amount'],
            'donation_date'     => $data['donation_date'],
            'notes'             => $data['notes'] ?? null,
            'receipt_path'      => $receiptPath,
            'is_confirmed' => false,
        ]);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Colaboração registrada com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //

        $this->authorize('view', $donation);

        return view('donations.show', ['donation' => $donation, 'menu' => 'donations']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
        $this->authorize('update', $donation);

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

    public function update(DonationRequest $request, Donation $donation)
    {
        $this->authorize('update', $donation);

        $data = $request->validated();

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
        $data['donor_name'] = $member?->name ?? 'Administração';

        $donation->update($data);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Colaboração atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {

        $this->authorize('delete', $donation);

        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Colaboração excluída com sucesso.');
    }

    // app/Http/Controllers/DonationController.php

    public function pending()
    {
        $this->authorize('viewAny', Donation::class);

        $donations = Donation::where('is_confirmed', false)
            ->with(['member', 'category', 'paymentMethod'])
            ->orderBy('donation_date', 'asc')
            ->paginate(15);

        return view('donations.pending', compact('donations') + ['menu' => 'confirm']);
    }

    public function confirm(Donation $donation)
    {
        $this->authorize('confirm', $donation);

        if ($donation->is_confirmed) {
            return back()->with('warning', 'Esta receita já foi confirmada.');
        }

        $donation->update([
            'is_confirmed' => true,
            'confirmed_at' => now(),
            'confirmed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Receita confirmada com sucesso.');
    }
}