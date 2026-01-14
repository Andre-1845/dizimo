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
            @can('create', \App\Models\User::class)
                <div class="content-box-btn">
                    <a href="{{ route('users.create') }}" class="btn-success flex items-center space-x-1">
                        @include('components.icons.plus')
                        <span>Cadastrar</span>
                    </a>
                </div>
            @endcan
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <x-users.filter :roles="$roles" />

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">ID</th>
                        <th class="table-header">Usuario</th>
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
                            <td class="table-body">{{ $user->member?->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->email }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->status->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->getRoleNames()->implode(', ') ?: '-' }}
                            </td>
                            <x-table-actions-icons :show="Gate::allows('view', $user) ? route('users.show', $user) : null" :edit="Gate::allows('update', $user) ? route('users.edit', $user) : null" :delete="Gate::allows('delete', $user) && auth()->id() !== $user->id
                                ? route('users.destroy', $user)
                                : null"
                                confirm="Deseja excluir {{ $user->name }}?" />
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
