@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Adicionar Relatório</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Título *</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" required maxlength="200">
                                @error('title')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="500">{{ old('description') }}</textarea>
                                <div class="form-text">Uma breve descrição do conteúdo do relatório.</div>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Arquivo PDF *</label>
                                <input type="file" class="form-control" id="file" name="file" accept=".pdf"
                                    required>
                                <div class="form-text">Apenas arquivos PDF, máximo 5MB.</div>
                                @error('file')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="available_until" class="form-label">Disponível até</label>
                                    <input type="date" class="form-control" id="available_until" name="available_until"
                                        value="{{ old('available_until') }}" min="{{ date('Y-m-d') }}">
                                    <div class="form-text">Deixe em branco para disponibilidade ilimitada.</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mt-4">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Ativo</label>
                                    </div>
                                    <div class="form-text">Relatórios inativos não são exibidos.</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Salvar Relatório
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
