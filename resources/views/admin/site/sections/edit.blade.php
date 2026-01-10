@extends('layouts.admin')

@section('title', 'Editar Seção')

@section('content')

    <h1 class="content-title">Editar Seção: {{ $section->key }}</h1>

    <form method="POST" action="{{ route('admin.site.sections.update', $section) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label">Título</label>
            <input type="text" name="title" value="{{ old('title', $section->title) }}" class="form-input">
        </div>

        <div class="mb-4">
            <label class="form-label">Subtítulo</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle) }}" class="form-input">
        </div>

        <div class="mb-4">
            <label class="form-label">Conteúdo</label>
            <textarea name="content" rows="5" class="form-input w-full">{{ old('content', $section->content) }}</textarea>
        </div>

        <div class="mb-4 flex items-end gap-6">

            <div>
                <label class="form-label">Ordem</label>
                <input type="number" name="order" value="{{ old('order', $section->order) }}" class="form-input w-20">
            </div>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" @checked($section->is_active)>
                <span>Seção ativa</span>
            </label>

        </div>


        <button class="btn-primary">Salvar</button>
    </form>

@endsection
