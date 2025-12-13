<?php


namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Member;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

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
            'categories' => Category::where('type', 'donation')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'donation_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        Donation::create($request->all());

        return redirect()
            ->route('donations.index')
            ->with('success', 'Doação registrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            'categories' => Category::where('type', 'donation')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'donation_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        $donation->update($request->all());

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
