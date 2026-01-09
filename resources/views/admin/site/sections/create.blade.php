@extends('layouts.admin')

@section('title', 'Nova Seção do Site')

@section('content')

    <div class="content-header">
        <h1 class="content-title">Nova Seção do Site</h1>

        <a href="{{ route('admin.site.sections.index') }}" class="btn-secondary">
            Voltar
        </a>
    </div>

    <x-alert />

    <form method="POST" action="{{ route('admin.site.sections.store') }}" class="bg-white rounded shadow p-6 max-w-3xl">
        @csrf

        {{-- CHAVE (não editável depois) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Chave da Seção
            </label>

            <input type="text" name="key" value="{{ old('key') }}" class="form-input w-full"
                placeholder="ex: hero, gallery, about" required>

            <p class="text-xs text-gray-500 mt-1">
                ⚠️ Use apenas letras minúsculas e sem espaços.
                Esta chave será usada internamente e não poderá ser alterada depois.
            </p>
        </div>

        {{-- TÍTULO --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Título
            </label>

            <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full">
        </div>

        {{-- SUBTÍTULO --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Subtítulo
            </label>

            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="form-input w-full">
        </div>

        {{-- CONTEÚDO --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Conteúdo
            </label>

            <textarea name="content" rows="5" class="form-textarea w-full">{{ old('content') }}</textarea>
        </div>

        {{-- ORDEM --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Ordem de Exibição
            </label>

            <input type="number" name="order" value="{{ old('order', 0) }}" class="form-input w-32">
        </div>

        {{-- ATIVA --}}
        <div class="mb-6">
            <label class="inline-flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))>
                Seção ativa
            </label>
        </div>

        {{-- BOTÕES --}}
        <div class="flex gap-4">
            <button type="submit" class="btn-primary">
                Salvar
            </button>

            <a href="{{ route('admin.site.sections.index') }}" class="btn-secondary">
                Cancelar
            </a>
        </div>
    </form>

@endsection
