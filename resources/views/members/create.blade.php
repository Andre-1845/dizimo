@extends('layouts.admin')

@section('title', 'Novo Membro')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            <x-smart-breadcrumb :items="[['label' => 'Membros', 'url' => route('members.index')], ['label' => 'Cadastrar']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h2 class="content-title">Novo Membro</h2>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('viewAny', \App\Models\Member::class)
                    <a href="{{ route('members.index') }}" class="btn-primary align-icon-btn" title="Listar">
                        @include('components.icons.list')
                        <span class="hide-name-btn">Listar</span>
                    </a>
                @endcan
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        @can('create', \App\Models\Member::class)
            <form action="{{ route('members.store') }}" method="POST" class="content-box space-y-4">
                @csrf

                <div>
                    <label class="form-label">Nome </label>
                    <input type="text" name="name" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Telefone</label>
                    <input type="tel" name="phone" maxlength="15" pattern="\d{10,11}"
                        title="Informe um telefone com 10 ou 11 dígitos" class="form-input">
                </div>

                <div>
                    <label class="form-label">Igreja</label>
                    <select name="church_id" class="form-input">
                        @foreach ($churches as $church)
                            <option value="{{ $church->id }}">
                                {{ $church->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Dízimo (R$)</label>
                    <input class="form-input" type="number" step="0.01" name="monthly_tithe">
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="active" value="1" checked>
                        Ativo
                    </label>
                </div>

                <p class="text-sm text-gray-500">
                    Este cadastro cria apenas o membro.
                    O acesso ao sistema poderá ser liberado posteriormente, informando um e-mail.
                </p>

                <div class="btn-md-div">
                    <button class="btn-success-md ">
                        @include('components.icons.save')
                        Salvar
                    </button>
                </div>
            </form>
        @endcan
    </div>
@endsection
