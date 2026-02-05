<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('viewAny', Expense::class);

        $users = User::whereHas('expenses')
            ->orderBy('name')
            ->get();


        $expenses = Expense::query()
            ->with(['category', 'paymentMethod', 'user'])

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
                fn($q) => $q->where('user_id', $request->user_id)
            )

            ->when(
                !empty($request->date_start),
                fn($q) => $q->whereDate('expense_date', '>=', $request->date_start)
            )

            ->when(
                !empty($request->date_end),
                fn($q) => $q->whereDate('expense_date', '<=', $request->date_end)
            )

            ->when(
                $request->filled('amount_min'),
                fn($q) => $q->where('amount', '>=', $request->amount_min)
            )

            ->when(
                $request->filled('amount_max'),
                fn($q) => $q->where('amount', '<=', $request->amount_max)
            )

            ->orderByDesc('expense_date')
            ->paginate(10)
            ->withQueryString();

        $filters = [
            [
                'type' => 'select',
                'name' => 'category_id',
                'label' => 'Categoria',
                'options' => Category::where('type', 'expense')->orderBy('name')->get(),
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
                'options' => $users,
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
            [
                'type' => 'number',
                'name' => 'amount_min',
                'label' => 'Valor mínimo',
            ],
            [
                'type' => 'number',
                'name' => 'amount_max',
                'label' => 'Valor máximo',
            ],
        ];

        return view('expenses.index', [
            'expenses' => $expenses,
            'filters'  => $filters,
            'menu'     => 'expenses',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $this->authorize('create', Expense::class);

        return view('expenses.create', [
            'menu' => 'expenses',
            'categories' => Category::where('type', 'expense')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(ExpenseRequest $request)
    {
        $this->authorize('create', Expense::class);

        $data = $request->validated();

        $data['user_id'] = Auth::id();

        // Upload do comprovante
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')
                ->store('receipts/expenses', 'public');
        }

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
        $this->authorize('update', $expense);

        return view('expenses.edit', [
            'expense' => $expense,
            'menu' => 'expenses',
            'categories' => Category::where('type', 'expense')->orderBy('name')->get(),
            'paymentMethods' => PaymentMethod::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.s
     */
    public function update(ExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);

        $data = $request->validated();

        $data['user_id'] = Auth::id();

        // Apaga comprovante anterior quando enviado um novo
        if ($request->hasFile('receipt') && $expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }

        // Upload do comprovante
        if ($request->hasFile('receipt')) {
            $data['receipt_path'] = $request->file('receipt')
                ->store('receipts/expenses', 'public');
        }

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
        $this->authorize('delete', $expense);

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->with('success', 'Despesa removida com sucesso.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
        $this->authorize('view', $expense);

        return view('expenses.show', ['expense' => $expense, 'menu' => 'expenses']);
    }

    public function pending()
    {
        $expenses = Expense::pending()
            ->with(['category', 'user'])
            ->latest()
            ->paginate(10);

        return view('expenses.pending', compact('expenses'));
    }

    public function confirm(Expense $expense)
    {
        $expense->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Despesa confirmada com sucesso.');
    }
}