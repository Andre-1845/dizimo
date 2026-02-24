@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Papéis</h2>
            <x-smart-breadcrumb :items="[['label' => 'Papeis']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>
            <!-- Botao CADASTRAR (com icone)  -->
            <div class="content-box-btn">
                <a href="{{ route('roles.create') }}" class="btn-success flex items-center space-x-1">
                    @include('components.icons.plus')
                    <span>Cadastrar</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header table-cell-lg-hidden">ID</th>
                        <th class="table-header">Papel</th>
                        <th class="table-header text-center">Permissões</th>
                        <th class="table-header table-cell-lg-hidden">Criado em</th>
                        <th class="table-header table-cell-lg-hidden">Editado em</th>
                        <th class="table-header center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        @continue($role->name === 'superadmin')
                        <tr class="table-row-body">
                            <td class="table-body table-cell-lg-hidden">{{ $role->id }}</td>
                            <td class="table-body">{{ $role->name ?? '—' }}</td>
                            <td class="table-body table-link text-center"> <a
                                    href="{{ route('role-permissions.index', ['role' => $role->id]) }}">Permissoes</a></td>
                            <td class="table-body table-cell-lg-hidden">{{ $role->created_at->format('d/m/Y') }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $role->updated_at->format('d/m/Y') }}</td>

                            <x-table-actions-icons :show="route('roles.show', $role)" :edit="route('roles.edit', $role)" :delete="route('roles.destroy', $role)"
                                confirm="Deseja excluir este papel?" />

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">
                                Nenhum papel registrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $roles->links() }}

        </div>
    @endsection
