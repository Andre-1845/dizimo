@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('expenses.index') }}" class="breadcrumb-link">Despesas</a>
                <span>/</span>
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes de Despesa</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('expenses.index') }}" class="btn-primary align-icon-btn" title="Listar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>

                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->

                <!-- Botao EDITAR (com icone)  -->
                <a href="{{ route('expenses.edit', ['expense' => $expense->id]) }}" class="btn-warning align-icon-btn"
                    title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>

                    <span class="hide-name-btn">Editar</span>
                </a>
                <!-- Fim - Botao EDITAR -->

                <!-- Botao APAGAR(com icone)  -->

                <form action="{{ route('expenses.destroy', ['expense' => $expense->id]) }}" method="post">
                    @csrf
                    @method('delete')

                    <button class="btn-danger align-icon-btn" title="Apagar" type="submit"
                        onclick="return confirm('Tem certeza que deseja excluir este registro ?')">
                        <span class="py-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg></span>

                        <span class="hide-name-btn">Apagar</span>
                    </button>
                </form>

                <!-- Fim - Botao APAGAR -->
            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $expense->id }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Descrição: </span>
                <span class="detail-content">{{ $expense->description }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Categoria: </span>
                <span class="detail-content">{{ $expense->category?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Valor: </span>
                <span class="detail-content">{{ $expense->amount }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Lançado por: </span>
                <span class="detail-content">{{ $expense->user->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Data da despesa: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Notas: </span>
                <span class="detail-content">{{ $expense->notes }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($expense->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>

    {{-- <a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>
    <a href="{{ route('users.edit_password', ['user' => $user->id]) }}">Editar Senha</a><br>
    <a href="{{ route('home') }}">Inicio</a><br><br> --}}
@endsection
