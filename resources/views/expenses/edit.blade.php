@extends('layouts.admin')

@section('title', 'Editar Despesa')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Editar Despesa</h1>

    <form method="POST" action="{{ route('expenses.update', $expense) }}" class="bg-white rounded-xl shadow p-6 space-y-4">

        @csrf
        @method('PUT')

        {{-- <div>
            <label class="block font-semibold">Membro</label>
            <select name="member_id" class="w-full border rounded p-2">
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected($expense->member_id == $member->id)>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}

        <div>
            <label class="block font-semibold">Categoria</label>
            <select name="category_id" class="w-full border rounded p-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($expense->category_id == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Forma de Pagamento</label>
            <select name="payment_method_id" class="w-full border rounded p-2">
                @foreach ($paymentMethods as $method)
                    <option value="{{ $method->id }}" @selected($expense->payment_method_id == $method->id)>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Data</label>
            <input type="date" name="expense_date" value="{{ $expense->expense_date->format('Y-m-d') }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Valor</label>
            <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Observações</label>
            <textarea name="notes" class="w-full border rounded p-2">{{ $expense->notes }}</textarea>
        </div>

        <div class="flex gap-4">
            <button class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Atualizar
            </button>

            <a href="{{ route('expenses.index') }}" class="px-6 py-2 rounded border">
                Cancelar
            </a>
        </div>

    </form>

@endsection
