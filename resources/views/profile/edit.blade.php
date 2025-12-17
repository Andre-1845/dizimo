@extends('layouts.admin')

@section('content')
    <div class="content-box"><!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Perfil</h3>
            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('profile.show') }}" class="btn-primary align-icon-btn" title="Listar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>

                    <span class="hide-name-btn">Perfil</span>
                </a>
                <!-- Fim - Botao LISTAR  -->


                <!-- Botao EDITAR SENHA(com icone)  -->
                <a href="{{ route('profile.edit_password', ['user' => $user->id]) }}" class="btn-info align-icon-btn"
                    title="Senha">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                    </svg>

                    <span class="hide-name-btn">Senha</span>
                </a>
                <!-- Fim - Botao EDITAR SENHA -->

                <!-- Botao APAGAR(com icone)  -->

                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post">
                    @csrf
                    @method('delete')

                    <button class="btn-danger align-icon-btn" title="Apagar" type="submit"
                        onclick="return confirm('Tem certeza que deseja excluir o usuário {{ $user->name }} ?')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>

                        <span class="hide-name-btn">Apagar</span>
                    </button>
                </form>

                <!-- Fim - Botao APAGAR -->
            </div>
            <!-- Botoes (com icones)  -->

        </div>


        <x-alert />

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <h3 class="font-semibold mb-3">Dados de acesso</h3>

            <label class="form-label" for="name">Usuário: </label>
            <input class="form-input" type="text" name="user_name" value="{{ old('name', $user->name) }}">

            <label class="form-label" for="email">Email: </label>
            <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}">

            <h3 class="font-semibold mt-6 mb-3">Dados pessoais</h3>

            <label class="form-label" for="name">Nome: </label>
            <input class="form-input" type="text" name="name" value="{{ old('email', $user->member?->name) }}">

            <label class="form-label" for="phone">Telefone: </label>
            <input class="form-input" type="text" name="phone" value="{{ old('phone', $user->member?->phone) }}">

            <button class="btn-primary mt-4">
                Salvar
            </button>
        </form>


        {{-- ANTIGO --}}
        {{-- <form action="{{ route('profile.update') }}" method="post">
            {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        {{-- <label class="form-label" for="">Nome: </label>
        <input class="form-input" type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
            placeholder="Nome do usuário" required><br>

        <label class="form-label" for="">Email: </label>
        <input class="form-input" type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
            placeholder="Email do usuário" required><br> --}}
        {{-- <label for="">Status: </label>
        <input type="text" name="status" id="status" value="{{ old('status', $user->status) }}"
            placeholder="Status do usuário" required><br> --}}


        {{-- <button class="btn-primary mt-2" type="submit">Salvar</button>
        </form> --}}
    </div>
@endsection
