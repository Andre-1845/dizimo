@extends('layouts.admin')

@section('title', 'Publicar Relatório')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Publicar Relatório Financeiro</h2>

            <x-smart-breadcrumb :items="[['label' => 'Relatórios', 'url' => route('reports.index')], ['label' => 'Publicar']]" />
        </div>
    </div>

    <div class="content-box">
        <x-alert />

        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">

            @csrf

            {{-- Título --}}
            <div>
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required>
            </div>

            {{-- Descrição --}}
            <div>
                <label class="form-label">Descrição</label>
                <textarea name="description" rows="3" class="form-input">{{ old('description') }}</textarea>
            </div>

            {{-- Tipo --}}
            <div>
                <label class="form-label">Tipo de relatório</label>
                <select name="type" class="form-input">
                    <option value="financial">Financeiro</option>
                    <option value="balancete">Balancete</option>
                    <option value="auditoria">Auditoria</option>
                    <option value="ata">Ata</option>
                </select>
            </div>

            {{-- PDF --}}
            <div>
                <label class="form-label">Arquivo (PDF)</label>
                <input type="file" name="file" accept="application/pdf" class="file-input" required>
            </div>

            {{-- Datas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Mês de referência</label>
                    <input type="month" name="reference_month" class="form-input" value="{{ old('reference_month') }}">
                </div>

                <div>
                    <label class="form-label">Publicar em</label>
                    <input type="date" name="published_at" class="form-input"
                        value="{{ old('published_at', now()->toDateString()) }}">
                </div>
            </div>

            {{-- Validade --}}
            <div>
                <label class="form-label">Válido até (opcional)</label>
                <input type="date" name="valid_until" class="form-input" value="{{ old('valid_until') }}">
            </div>

            {{-- Publicação --}}
            <div>
                <label>
                    <input type="checkbox" name="is_published" value="1">
                    Publicar relatório
                </label>
                <p class="text-xs text-gray-500 mt-1">
                    Apenas relatórios publicados aparecem na Transparência.
                </p>
            </div>

            {{-- Botões --}}
            <div class="btn-md-div gap-2">
                <button class="btn-success">
                    Salvar relatório
                </button>
                <a href="{{ route('reports.index') }}" class="btn-info">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

@endsection
