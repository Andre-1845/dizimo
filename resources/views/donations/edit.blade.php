@extends('layouts.admin')

@section('title', 'Editar Doação')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Editar Doação</h1>

    <form method="POST" action="{{ route('donations.update', $donation) }}" class="bg-white rounded-xl shadow p-6 space-y-4">

        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold">Membro</label>
            <select name="member_id" class="w-full border rounded p-2">
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected($donation->member_id == $member->id)>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Categoria</label>
            <select name="category_id" class="w-full border rounded p-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($donation->category_id == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Forma de Pagamento</label>
            <select name="payment_method_id" class="w-full border rounded p-2">
                @foreach ($paymentMethods as $method)
                    <option value="{{ $method->id }}" @selected($donation->payment_method_id == $method->id)>
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Data</label>
            <input type="date" name="donation_date" value="{{ $donation->donation_date->format('Y-m-d') }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Valor</label>
            <input type="number" step="0.01" name="amount" value="{{ $donation->amount }}"
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Observações</label>
            <textarea name="notes" class="w-full border rounded p-2">{{ $donation->notes }}</textarea>
        </div>

        <div class="flex gap-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Atualizar
            </button>

            <a href="{{ route('donations.index') }}" class="px-6 py-2 rounded border">
                Cancelar
            </a>
        </div>

    </form>

@endsection
