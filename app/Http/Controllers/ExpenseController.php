<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $expenses = Expense::with(['category', 'paymentMethod'])
            ->orderByDesc('expense_date')
            ->paginate(10);

        return view('expenses.index', [
            'expenses' => $expenses,
            'menu' => 'expenses',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('expenses.create', [
            'menu' => 'expenses',
            'categories' => Category::where('type', 'expense')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        Expense::create($data);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa registrada com sucesso.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Expense $expense)
    {
        return view('expenses.edit', [
            'expense' => $expense,
            'menu' => 'expenses',
            'categories' => Category::where('type', 'expense')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        $expense->update($data);

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa removida com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
