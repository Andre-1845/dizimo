@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    @if (isset($isSuperAdmin) && $isSuperAdmin)
        <div class="alert alert-info">
            <strong>Modo Super Admin:</strong> Você pode modificar todas as permissões.
        </div>
    @endif
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Permissões</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
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
            <x-action-buttons :list="route('roles.index')" list-label="Papeis" can-list="roles.view" />
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
    @endsection
