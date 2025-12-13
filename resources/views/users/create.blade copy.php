@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Usuário</h2>
    <br>

    <x-alert />

    <br>
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        @method('POST')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nome do usuário"><br><br>
        <label for="">E-mail: </label>
        <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="E-mail"><br><br>
        <label for="papeis">Papel: </label>
        @forelse ($roles as $role)
            @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}" value="{{ $role }}"
                    {{ collect(old('roles'))->contains($role) ? 'checked' : '' }}>
                <label for="role_{{ Str::slug($role) }}">{{ $role }}</label>
            @endif
        @empty
            <p>Nenhum papel disponível.</p>
        @endforelse
        <br><br>
        <label for="">Senha: </label>
        <input type="password" name="password" id="password" placeholder="Senha"><br><br>
        <label for="">Confirmar Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a Senha"><br><br>
        <button type="submit">Cadastrar</button>
    </form>
@endsection
