@extends('layouts.admin')

@section('title', 'Editar Relatório')

@section('content')

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Editar Relatório Financeiro</h2>

            <x-smart-breadcrumb :items="[['label' => 'Relatórios', 'url' => route('reports.index')], ['label' => $report->title]]" />
        </div>
    </div>

    <div class="content-box">
        <x-alert />

        <form action="{{ route('reports.update', $report) }}" method="POST" enctype="multipart/form-data" class="space-y-4">

            @csrf
            @method('PUT')

            {{-- Título --}}
            <div>
                <label class="form-label">Título</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $report->title) }}" required>
            </div>

            {{-- Descrição --}}
            <div>
                <label class="form-label">Descrição</label>
                <textarea name="description" rows="3" class="form-input">{{ old('description', $report->description) }}</textarea>
            </div>

            {{-- Tipo --}}
            <div>
                <label class="form-label">Tipo de relatório</label>
                <select name="type" class="form-input">
                    @foreach (['financial', 'balancete', 'auditoria', 'ata'] as $type)
                        <option value="{{ $type }}" {{ $report->type === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PDF --}}
            <div>
                <label class="form-label">Arquivo PDF</label>
                <input type="file" name="file" accept="application/pdf" class="file-input">

                <p class="text-xs text-gray-500 mt-1">
                    Arquivo atual:
                    <a href="{{ $report->file_url }}" target="_blank" class="text-blue-600 underline">
                        visualizar PDF
                    </a>
                </p>
            </div>

            {{-- Datas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Mês de referência</label>
                    <input type="month" name="reference_month" class="form-input"
                        value="{{ old('reference_month', optional($report->reference_month)->format('Y-m')) }}">
                </div>

                <div>
                    <label class="form-label">Publicado em</label>
                    <input type="date" name="published_at" class="form-input"
                        value="{{ old('published_at', optional($report->published_at)->toDateString()) }}">
                </div>
            </div>

            {{-- Validade --}}
            <div>
                <label class="form-label">Válido até</label>
                <input type="date" name="valid_until" class="form-input"
                    value="{{ old('valid_until', optional($report->valid_until)->toDateString()) }}">
            </div>

            {{-- Publicação --}}
            <div>
                <label>
                    <input type="checkbox" name="is_published" value="1" {{ $report->is_published ? 'checked' : '' }}>
                    Publicar relatório
                </label>
            </div>

            {{-- Botões --}}
            <div class="btn-md-div gap-2">
                <button class="btn-success">
                    Atualizar relatório
                </button>

                <a href="{{ route('reports.index') }}" class="btn-info">
                    Voltar
                </a>
            </div>

        </form>
    </div>

@endsection
