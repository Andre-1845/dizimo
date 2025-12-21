@extends('layouts.admin')

@section('content')
    <h2 class="text-xl font-semibold mb-4">
        Permissões do papel: {{ $role->name }}
    </h2>

    <x-alert />

    <div class="mb-4 space-x-3">
        <a href="{{ route('home') }}">Início</a>
        <a href="{{ route('roles.index') }}">Listar papéis</a>
    </div>

    <hr class="my-4">

    @forelse ($permissions as $permission)
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
    @endforelse
@endsection
