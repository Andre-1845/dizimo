@extends('layouts.admin')

@section('title', 'Nova Doação')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Doações</h2>
            <x-smart-breadcrumb :items="[['label' => 'Minhas Doações']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"><!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Nova Doação</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">
                <!-- Botoes (com icones)  -->
                <x-action-buttons :list="route('dashboard.member')" list-label="Meu Painel" />
                <!-- Botoes (com icones)  -->
            </div>
        </div>

        <x-alert />

        @can('dashboard.member.view')
            <form method="POST" enctype="multipart/form-data" action="{{ route('member.donations.store') }}"
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
                            <option value="{{ $category->id }}" @selected(old('category_id', 1) == $category->id)>
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
                            <option value="{{ $method->id }}" @selected(old('payment_method_id') == $method->id)>
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
                    <input type="date" name="donation_date" class="form-input"
                        value="{{ old('donation_date', now()->toDateString()) }}">
                    @error('donation_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="amount" class="form-input" value="{{ old('amount') }}">
                    @error('amount')
                        <p class="text-red-600 text-sm
                        mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Observações</label>
                    <textarea name="notes" class="form-input">{{ old('notes') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Comprovante</label>
                    <input type="file" name="receipt" accept=".pdf,.jpg,.jpeg,.png" class="file-input">
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
        @endcan
    </div>
@endsection
