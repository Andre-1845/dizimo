@extends('layouts.admin')

@section('content')
    <h2>Editar Usuário</h2>
    <br>

    <x-alert />

    <br>
    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Nome do usuário"
            required><br>

        <label for="">Email: </label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            placeholder="Email do usuário" required><br>

        <label for="">Status: </label>
        <select name="status_id" id="status_id">
            @foreach ($statuses as $status)
                <option value="{{ $status->id }}"
                    {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select><br>

        <label for="">Papel: </label>
        @forelse ($roles as $role)
            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}" value="{{ $role }}"
                    {{ in_array($role, old('roles', $userRoles)) ? 'checked' : '' }}>

                <label for="role_{{ Str::slug($role) }}">{{ $role }}</label>
            @endif
        @empty
            <span class="alert-warning">Nenhum papel disponível.</span>
        @endforelse


        {{-- <label for="">Papel: </label>
        @forelse ($roles as $role)
            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}" value="{{ $role }}"
                    {{ in_array($role, old('roles', $userRoles)) ? 'checked' : '' }}>
                <label for="role_{{ Str::slug($role) }} ">{{ $role }}</label>
            @endif

        @empty
            <span class="alert-warning">Nenhum papel disponível.</span>
        @endforelse --}}
        <br><br>
        <button type="submit">Salvar</button>
    </form>
@endsection
