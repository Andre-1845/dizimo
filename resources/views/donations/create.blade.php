@extends('layouts.admin')

@section('title', 'Nova Doação')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Nova Doação</h1>

    <form method="POST" action="{{ route('donations.store') }}" class="bg-white rounded-xl shadow p-6 space-y-4">

        @csrf

        <div>
            <label class="block font-semibold">Membro</label>
            <select name="member_id" class="w-full border rounded p-2">
                <option value="">Selecione</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Categoria</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">Selecione</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Forma de Pagamento</label>
            <select name="payment_method_id" class="w-full border rounded p-2">
                <option value="">Selecione</option>
                @foreach ($paymentMethods as $method)
                    <option value="{{ $method->id }}">
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Data</label>
            <input type="date" name="donation_date" class="w-full border rounded p-2"
                value="{{ now()->toDateString() }}">
        </div>

        <div>
            <label class="block font-semibold">Valor</label>
            <input type="number" step="0.01" name="amount" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Observações</label>
            <textarea name="notes" class="w-full border rounded p-2"></textarea>
        </div>

        <button class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Salvar Doação
        </button>
    </form>

@endsection
