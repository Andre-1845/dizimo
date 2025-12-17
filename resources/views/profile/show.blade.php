@extends('layouts.admin')

@section('content')
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Perfil</h3>

        </div>


        <x-alert />

        <br>
        <a href="{{ route('profile.edit') }}">Editar</a><br>
        <a href="{{ route('profile.edit_password') }}">Editar Senha</a><br>
        <a href="{{ route('home') }}">Inicio</a><br><br>

        {{-- Listar registro --}}


        ID: {{ $user->id }}<br>
        Usuario: {{ $user->name }} <br>
        Nome: {{ $user->member?->name }}<br>
        Email: {{ $user->email }} <br>
        Status: {{ $user->status->name }} <br>
        Papel:
        {{-- @forelse ($user->getRoleNames() as $index => $role)
            @if (!$loop->last)
                {{ $role . ',' }}
            @else()
                {{ $role . '.' }}<br>
            @endif

        @empty
        -
        @endforelse --}}
        {{ $user->getRoleNames()->implode(', ') ?: '-' }}<br>

        {{-- Carbon é uma biblioteca Laravel usada para o format --}}
        Criado: {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }} <br>
        Alterado: {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }} <br>
    </div>
@endsection
