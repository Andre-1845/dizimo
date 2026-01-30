@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-2">Relatórios</h1>
                <p class="text-muted mb-0">Gerencie os relatórios PDF disponíveis.</p>
            </div>
            <a href="{{ route('reports.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Novo Relatório
            </a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($reports->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Descrição</th>
                                    <th>Validade</th>
                                    <th>Status</th>
                                    <th>Criado em</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>{{ $report->title }}</td>
                                        <td class="text-muted small">{{ Str::limit($report->description, 60) }}</td>
                                        <td>
                                            @if ($report->available_until)
                                                {{ $report->available_until->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">Ilimitado</span>
                                            @endif
                                        </td>
                                        <td>{!! $report->status_badge !!}</td>
                                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ $report->file_url }}" target="_blank"
                                                    class="btn btn-outline-primary" title="Ver PDF">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('reports.edit', $report) }}"
                                                    class="btn btn-outline-secondary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('reports.destroy', $report) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir este relatório?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Excluir">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('reports.toggle-status', $report) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-warning"
                                                        title="Alternar Status">
                                                        <i class="fas fa-power-off"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-file-pdf fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Nenhum relatório cadastrado</h6>
                        <p class="text-muted small">Comece adicionando um novo relatório.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
