@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Usuários</h2>
            <x-smart-breadcrumb :items="[['label' => 'Usuários']]" />
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
                        <th class="table-header table-cell-lg-hidden">ID</th>
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
                            <td class="table-body table-cell-lg-hidden">{{ $user->id }}</td>
                            <td class="table-body">{{ $user->name }}</td>
                            <td class="table-body">{{ $user->member?->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->email }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->status->name }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $user->getRoleNames()->implode(', ') ?: '-' }}
                            </td>

                            <x-table-actions-icons :show="route('users.show', $user)" :edit="route('users.edit', $user)" :delete="$user->id !== auth()->id() ? route('users.destroy', $user) : null"
                                can-show="users.view" can-edit="users.edit" :can-delete="$user->id !== auth()->id() ? 'users.delete' : null"
                                confirm="Deseja excluir o usuário * {{ $user->name }} * ?" />

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
