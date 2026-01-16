@extends('layouts.admin')

@section('title', 'Editar Doação')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Receitas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('donations.index') }}" class="breadcrumb-link">Receitas</a>
                <span>/</span>
                <span>Editar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Doacao</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('donations.view')
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

        @can('donations.edit')
            <form method="POST" action="{{ route('donations.update', $donation) }}"
                class="bg-white rounded-xl shadow p-6 space-y-4">

                @csrf
                @method('PATCH')

                <div>
                    <label class="form-label">Membro</label>
                    <select name="member_id" class="form-input">
                        <option value="">Administração</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" @selected($donation->member_id == $member->id)>
                                {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Categoria</label>
                    <select name="category_id" class="form-input">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected($donation->category_id == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Forma de Pagamento</label>
                    <select name="payment_method_id" class="form-input">
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}" @selected($donation->payment_method_id == $method->id)>
                                {{ $method->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Data</label>
                    <input type="date" name="donation_date" value="{{ $donation->donation_date->format('Y-m-d') }}"
                        class="form-input">
                </div>

                <div>
                    <label class="form-label">Valor</label>
                    <input type="number" step="0.01" name="amount" value="{{ $donation->amount }}" class="form-input">
                </div>

                <div>
                    <label class="form-label">Observações</label>
                    <textarea name="notes" class="form-input">{{ $donation->notes }}</textarea>
                </div>

                <div class="btn-md-div gap-2">
                    <button class="btn-primary-md">
                        Atualizar
                    </button>

                    <a href="{{ route('donations.index') }}" class="btn-danger-md">
                        Cancelar
                    </a>
                </div>

            </form>
        @endcan

    @endsection
