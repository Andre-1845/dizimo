@extends('layouts.admin')

@section('title', 'Membros')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Membros</span>
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
                    @include('components.icons.plus')
                    <span>Cadastrar</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <!-- Formulario de pesquisa -->

        {{-- <form action="#" class="form-search">
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
                <a href="{{ route('members.index') }}" class="btn-warning flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>

                    <span class="hide-name-btn">Limpar</span>
                </a>
            </div>

        </form> --}}
        <!-- FIM - Formulario de pesquisa -->

        <x-filters.generic :filters="$filters" route="members.index" />



        <div class="content-box">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Nome</th>
                        <th class="table-header">Email</th>
                        <th class="table-header">Status</th>
                        <th class="table-header text-center">Dizimo prev</th>
                        <th class="table-header text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr class="table-row-body">
                            <td class="table-body">{{ $member->name }}</td>
                            <td class="table-body">{{ $member->user->email ?? '—' }}</td>
                            <td class="table-body">
                                @if ($member->active)
                                    <x-badge type="active">Ativo</x-badge>
                                @else
                                    <x-badge type="inactive">Inativo</x-badge>
                                @endif
                            </td>
                            <td class="table-body text-right">{{ $member->monthly_tithe ?? '—' }}</td>
                            <x-table-actions-icons :show="route('members.show', $member)" :edit="route('members.edit', $member)" :delete="route('members.destroy', $member)"
                                confirm="Deseja excluir {{ $member->name }}?" />
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Nenhum membro cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>

    @endsection
