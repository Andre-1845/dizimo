@extends('layouts.admin')

@section('title', 'Editar Membro')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            {{-- Em members/edit.blade.php --}}
            <x-smart-breadcrumb :items="[
                ['label' => 'Membros', 'url' => route('members.index')],
                ['label' => $member->name, 'url' => route('members.show', $member)],
                ['label' => 'Editar'],
            ]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar Membro</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                @can('viewAny', \App\Models\Member::class)
                    <a href="{{ route('members.index') }}" class="btn-primary align-icon-btn" title="Listar">
                        @include('components.icons.list')
                        <span class="hide-name-btn">Listar</span>
                    </a>
                @endcan
                <!-- Fim - Botao LISTAR  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>


        <x-alert />

        @can('update', $member)
            <form action="{{ route('members.update', $member) }}" method="POST" class="content-box space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">Nome </label>
                    <input type="text" name="name" class="form-input" value="{{ $member->name }}"required>
                </div>

                <div>
                    <label class="form-label">Usuário</label>

                    @if ($member->user)
                        <input type="text" class="form-input" value="{{ $member->user->name }}" readonly>

                        @if (!$member->user->hasVerifiedEmail())
                            <p class="text-xs text-orange-600 mt-1">
                                Convite enviado — aguardando confirmação por e-mail
                            </p>
                        @else
                            <p class="text-xs text-green-600 mt-1">
                                Acesso ativo
                            </p>
                        @endif
                    @else
                        <input type="text" class="form-input  text-orange-600" value="Sem acesso ao sistema" readonly>

                        <p class="text-xs text-gray-500 mt-1">
                            Informe um e-mail abaixo para liberar o acesso.
                        </p>
                    @endif
                </div>

                @if (!$member->user)
                    <div>
                        <label class="form-label">E-mail para acesso</label>
                        <input type="email" name="email" class="form-input" placeholder="email@exemplo.com">
                        <p class="text-xs text-gray-500 mt-1">
                            Ao salvar, será enviado um e-mail de confirmação para este endereço.
                        </p>
                    </div>
                @endif

                <div>
                    <label class="form-label">Telefone</label>
                    <input type="tel" name="phone" maxlength="15" pattern="\d{10,11}"
                        title="Informe um telefone com 10 ou 11 dígitos" class="form-input" value="{{ $member->phone }}">
                </div>

                <div>
                    <label class="form-label">Dízimo (R$)</label>
                    <input class="form-input" type="number" step="0.01" name="monthly_tithe"
                        value="{{ old('monthly_tithe', $member->monthly_tithe) }}">
                </div>

                <div>
                    <label>
                        <input type="checkbox" name="active" {{ $member->active ? 'checked' : '' }}>
                        Ativo
                    </label>
                </div>

                <div class="btn-md-div">
                    <button class="btn-success-md">
                        @include('components.icons.save')
                        {{ $member->user ? 'Salvar' : 'Salvar e enviar convite' }}
                    </button>
                </div>
            </form>
        @endcan
    </div>
@endsection
