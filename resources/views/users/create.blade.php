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
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('users.index') }}" class="btn-primary align-icon-btn" title="Listar">
                    @include('components.icons.list')
                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->


            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        <form action="{{ route('users.store') }}" method="post">
            @csrf
            @method('POST')

            <div class="mb-4">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" value="{{ old('name') }} " class="form-input"
                    placeholder="Nome completo">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-input"
                    placeholder="E-mail">
            </div>

            <div class="mb-4">
                <label for="papeis" class="form-label">Papel: </label>
                @forelse ($roles as $role)
                    @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                        <input class="mt-2" type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}"
                            value="{{ $role }}" {{ collect(old('roles'))->contains($role) ? 'checked' : '' }}>
                        <label for="role_{{ Str::slug($role) }}">{{ $role }}</label>
                    @endif
                @empty
                    <span class="alert-warning">Nenhum papel disponível.</span>
                @endforelse

            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-input"
                    placeholder="Senha (mínimmo 6 caracteres)">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Senha - confirmação</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input"
                    placeholder="Repita a senha">
            </div>

            <button type="submit" class="btn-success">Cadastrar</button>

        </form>
    </div> <!-- FIM  Content-Box  -->


    <!-- Antigo -->
    {{-- <form action="{{ route('users.store') }}" method="post">
        @csrf
        @method('POST')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
            placeholder="Nome do usuário"><br><br>
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
        <input type="password" name="password_confirmation" id="password_confirmation"
            placeholder="Repita a Senha"><br><br>
        <button type="submit">Cadastrar</button>
    </form> --}}
@endsection
