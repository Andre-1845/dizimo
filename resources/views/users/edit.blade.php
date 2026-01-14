@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Usuários</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('users.index') }}" class="breadcrumb-link">Usuários</a>
                <span>/</span>
                <span>Editar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="Gate::allows('viewAny', \App\Models\User::class) ? route('users.index') : null" :password="Gate::allows('editPassword', $user) ? route('users.password.edit', $user) : null" :delete="Gate::allows('delete', $user) ? route('users.destroy', $user) : null"
                delete-confirm="Deseja excluir o usuário {{ $user->name }}?" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        @can('update', $user)
            <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="form-input" placeholder="Nome completo">
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-input" placeholder="E-mail">
                </div>

                <div class="mb-4">
                    <label class="form-label" for="">Status</label>
                    <select class="form-input" name="status_id" id="status_id">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @can('manage-roles')
                    <div class="mb-4">
                        <label for="papeis" class="form-label">Papel</label>
                        @forelse ($roles as $role)
                            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                <input class="mt-2" type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}"
                                    value="{{ $role }}"
                                    {{ collect(old('roles', $userRoles))->contains($role) ? 'checked' : '' }}>

                                <label for="role_{{ Str::slug($role) }}">{{ $role }}</label>
                            @endif
                        @empty
                            <span class="alert-warning">Nenhum papel disponível.</span>
                        @endforelse

                    </div>
                @endcan

                <div class="btn-md-div">
                    <button type="submit" class="btn-success">
                        @include('components.icons.save')
                        Salvar
                    </button>
                </div>

            </form>
        @endcan
    </div> <!-- FIM Content-Box  -->
@endsection
