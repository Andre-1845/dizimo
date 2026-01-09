@extends('layouts.admin')

@section('title', 'Conteúdo do Site')

@section('content')
    <div class="max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-8">Conteúdo do Site</h1>

        <div class="grid md:grid-cols-3 gap-6">

            {{-- Seções --}}
            <a href="{{ route('admin.site.sections.index') }}"
                class="block p-6 border rounded-lg shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold mb-2">Seções da Página</h2>
                <p class="text-sm text-gray-600">
                    Editar textos, ordem e visibilidade da página inicial.
                </p>
            </a>

            {{-- Eventos --}}
            <a href="{{ route('admin.site.events.index') }}"
                class="block p-6 border rounded-lg shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold mb-2">Agenda / Eventos</h2>
                <p class="text-sm text-gray-600">
                    Gerenciar eventos exibidos no site público.
                </p>
            </a>

            {{-- Configurações --}}
            <a href="{{ route('admin.site.settings.edit') }}"
                class="block p-6 border rounded-lg shadow-sm hover:shadow-md transition">
                <h2 class="text-lg font-semibold mb-2">Configurações</h2>
                <p class="text-sm text-gray-600">
                    Título do site, rodapé, endereço e telefone.
                </p>
            </a>

        </div>
    </div>
@endsection
