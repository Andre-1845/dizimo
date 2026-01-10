@extends('layouts.admin')

@section('title', 'Conteúdo do Site')

@section('content')
    <div class="max-w-6xl mx-auto">

        {{-- <h1 class="text-2xl font-bold mb-8">Conteúdo do Site</h1> --}}
        <h1 class="content-title">Conteúdo do Site</h1>

        <div class="my-6 grid md:grid-cols-3 gap-6">

            {{-- Seções --}}
            <a href="{{ route('admin.site.sections.index') }}" class="card-config-site">
                <h2 class="card-config-title">Seções da Página</h2>
                <p class="card-config-subtitle">
                    Editar textos, ordem e visibilidade da página inicial.
                </p>
            </a>

            {{-- Eventos --}}
            <a href="{{ route('admin.site.events.index') }}" class="card-config-site">
                <h2 class="card-config-title">Agenda / Eventos</h2>
                <p class="card-config-subtitle">
                    Gerenciar eventos exibidos no site público.
                </p>
            </a>

            {{-- Configurações --}}
            <a href="{{ route('admin.site.settings.edit') }}" class="card-config-site">
                <h2 class="card-config-title">Configurações</h2>
                <p class="card-config-subtitle">
                    Título do site, rodapé, endereço e telefone.
                </p>
            </a>

        </div>
    </div>
@endsection
