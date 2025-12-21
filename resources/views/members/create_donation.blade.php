@extends('layouts.admin')

@section('title', 'Nova Doação')

@section('content')

    <x-alert />

    <h1 class="text-2xl font-bold mb-6">Nova Doação</h1><br>
    <p class="text-sm text-gray-500 mt-1">
        Esta doação será vinculada automaticamente ao seu perfil
    </p>

    <form method="POST" enctype="multipart/form-data" action="{{ route('member.donation.store') }}"
        class="bg-white rounded-xl shadow p-6 space-y-4">

        @csrf
        @method('POST')

        <div>
            <label class="form-label">Membro</label>
            <input name="member_name" class="form-input" value="{{ $user->member->name }}" readonly>

        </div>

        <div>
            <label class="form-label">Categoria</label>
            <select name="category_id" class="form-input">
                <option value="">Selecione</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="form-label">Forma de Pagamento</label>
            <select name="payment_method_id" class="form-input">
                <option value="">Selecione</option>
                @foreach ($paymentMethods as $method)
                    <option value="{{ $method->id }}">
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
            @error('payment_method_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="form-label">Data</label>
            <input type="date" name="donation_date" class="form-input" value="{{ now()->toDateString() }}">
            @error('donation_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="form-label">Valor</label>
            <input type="number" step="0.01" name="amount" class="form-input">
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="form-label">Observações</label>
            <textarea name="notes" class="form-input"></textarea>
        </div>

        <div>
            <label class="form-label">Comprovante</label>
            <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png"
                class="block w-full text-sm text-gray-600
                      file:mr-4 file:py-2 file:px-4
                      file:rounded file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
            <p class="text-xs text-gray-400 mt-1">
                Tamanho máximo: 2MB
            </p>
            @error('receipt')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="btn-md-div">
            <button class="btn-success-md ">
                @include('components.icons.save')
                Salvar Doação
            </button>
        </div>
    </form>

@endsection
