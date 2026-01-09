@extends('layouts.admin')

@section('title', 'Editar Seção')

@section('content')

    <h1 class="content-title">Editar Seção: {{ $section->key }}</h1>

    <form method="POST" action="{{ route('admin.site.sections.update', $section) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Título</label>
            <input type="text" name="title" value="{{ old('title', $section->title) }}" class="form-input">
        </div>

        <div class="mb-4">
            <label>Subtítulo</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}" class="form-input">
        </div>

        <div class="mb-4">
            <label>Conteúdo</label>
            <textarea name="content" rows="5" class="form-textarea">{{ old('content', $section->content) }}</textarea>
        </div>

        <div class="mb-4 flex gap-6">
            <label>
                <input type="checkbox" name="is_active" value="1" @checked($section->is_active)>
                Seção ativa
            </label>

            <label>
                Ordem:
                <input type="number" name="order" value="{{ old('order', $section->order) }}" class="form-input w-20">
            </label>
        </div>

        <button class="btn-primary">Salvar</button>
    </form>

@endsection
