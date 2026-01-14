@extends('layouts.admin')

@section('title', 'Nova Doação')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Receitas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('donations.index') }}" class="breadcrumb-link">Receitas</a>
                <span>/</span>
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Nova Doacao</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('index-donation')
                    <a href="{{ route('donations.index') }}" class="btn-primary align-icon-btn" title="Listar">
                        @include('components.icons.list')

                        <span class="hide-name-btn">Listar</span>
                    </a>
                @endcan
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        @can('create-donation')
            <form method="POST" action="{{ route('donations.store') }}" enctype="multipart/form-data"
                class="bg-white rounded-xl shadow p-6 space-y-4">


                @csrf
                @method('POST')

                <div>
                    <label class="form-label">Membro</label>
                    <select name="member_id" class="form-input">
                        <option value="">Administração</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
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
                </div>
                @error('payment_method_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <label class="form-label">Data</label>
                    <input type="date" name="donation_date" class="form-input" value="{{ now()->toDateString() }}">
                </div>

                <div>
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="amount" class="form-input">
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
                    <button class="btn-primary-md">
                        @include('components.icons.save')
                        Salvar Doação
                    </button>
                </div>
            </form>
        @endcan
    @endsection
