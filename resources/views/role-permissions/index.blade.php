@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Permissões</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Permissões</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title text-2xl"> Permissões do papel: {{ $role->name }}</h3>
            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('roles.index')" list-label="Papeis" can-list="index-role" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        @foreach ($permissions as $group => $groupPermissions)
            <h3 class="table-title">
                {{ ucfirst($group) }}
            </h3>

            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Permissão</th>
                        <th class="table-header">Descrição</th>
                        <th class="table-header">Status</th>
                        <th class="table-header text-center">Ação</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($groupPermissions as $permission)
                        @php
                            $hasPermission = $role->hasPermissionTo($permission);
                        @endphp

                        <tr>
                            <td class="table-body font-medium">
                                {{ $permission->display_name }}
                            </td>

                            <td class="table-body text-sm text-gray-500">
                                {{ $permission->name }}
                            </td>

                            <td class="table-body">
                                @if ($hasPermission)
                                    <span class="text-green-600 font-semibold">Liberado</span>
                                @else
                                    <span class="text-red-600 font-semibold">Bloqueado</span>
                                @endif
                            </td>

                            <td class="table-body text-right">
                                <form method="POST" action="{{ route('role-permissions.toggle', [$role, $permission]) }}">
                                    @csrf
                                    @method('PUT')

                                    <button class="btn-sm {{ $hasPermission ? 'btn-warning' : 'btn-success' }}">
                                        {{ $hasPermission ? 'Bloquear' : 'Liberar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach


        {{-- @forelse ($permissions as $permission)
        <div class="flex items-center justify-between border-b py-2">

            <div>
                <span class="text-sm text-gray-500">ID {{ $permission->id }}</span><br>
                <strong>{{ $permission->name }}</strong>
            </div>

            @can('managePermissions', $role)
                <form method="POST" action="{{ route('role-permissions.toggle', [$role, $permission]) }}">
                    @csrf
                    @method('PUT')

                    <button type="submit"
                        class="btn-sm {{ $role->hasPermissionTo($permission) ? 'btn-danger' : 'btn-success' }}">
                        {{ $role->hasPermissionTo($permission) ? 'Remover' : 'Adicionar' }}
                    </button>
                </form>
            @endcan

        </div>

    @empty
        <p class="text-gray-500">Nenhuma permissão cadastrada.</p>
    @endforelse --}}
    @endsection
