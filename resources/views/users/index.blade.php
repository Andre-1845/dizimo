@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Usuários</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Usuários</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botao CADASTRAR (com icone)  -->
            <div class="content-box-btn">
                <a href="{{ route('users.create') }}" class="btn-success flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>

                    <span>Cadastrar</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <!-- Formulario de pesquisa -->

        <form action="#" class="form-search">
            <input type="text" name="name" class="form-input" placeholder="Digite o nome" value="{{ $name }}">
            <input type="text" name="email" class="form-input" placeholder="Digite o e-mail"
                value="{{ $email }}">
            <input type="date" name="start_date_registration" value="{{ $start_date_registration }}" class="form-input"
                placeholder="Data de início">
            <input type="date" name="end_date_registration" value="{{ $end_date_registration }}" class="form-input"
                placeholder="Data de fim">

            <div class="flex gap-1">
                <button type="submit" class="btn-success flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>

                    <span class="hide-name-btn">Pesquisar</span>
                </button>
                <a href="{{ route('users.index') }}" class="btn-warning flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>

                    <span class="hide-name-btn">Limpar</span>
                </a>
            </div>

        </form>
        <!-- FIM - Formulario de pesquisa -->

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header"r>
                        <th class="table-header">ID</th>
                        <th class="table-header">Nome</th>
                        <th class="table-header table-cell-lg-hidden">E-mail</th>
                        <th class="table-header table-cell-lg-hidden">Status</th>
                        <th class="table-header table-cell-lg-hidden">Papel</th>
                        <th class="table-header center w-20 whitespace-nowrap">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Listar os usuarios -->
                    @forelse ($users as $user)
                        <tr class="table-row-body">
                            <td class="table-body">{{ $user->id }}</td>
                            <td class="table-body">{{ $user->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->email }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->status->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->getRoleNames()->implode(', ') ?: '-' }}
                            </td>
                            <td class="table-body table-actions">

                                <a href="{{ route('users.show', ['user' => $user->id]) }}"
                                    class="btn-primary">Visualizar</a>

                                <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                    class="btn-warning table-md-hidden">Editar</a>

                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                                    @csrf
                                    @method('delete')

                                    <button class="btn-danger table-md-hidden" type="button"
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">Apagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <span class="alert-warning">Não existem usuários cadastrados.</span>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> <!-- FIM Content-Box  -->

    {{ $users->links() }}
@endsection
