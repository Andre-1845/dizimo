@extends('layouts.admin')

@section('title', 'Relatórios Financeiros')

@section('content')

    <div class="content-wrapper">
        <div class="content-header flex justify-between items-center">
            <div>
                <h2 class="content-title mb-2">Relatórios Financeiros</h2>
                <p class="text-sm text-gray-500">
                    Gerencie os relatórios PDF utilizados na Transparência.
                </p>
            </div>

            @can('reports.create')
                <a href="{{ route('reports.create') }}" class="btn-success-md">
                    <i class="fas fa-plus"></i> Novo Relatório
                </a>
            @endcan
        </div>
    </div>

    <div class="content-box">
        <x-alert />

        @if ($reports->count())
            <div class="table-container">
                <table class="table w-full">
                    <thead>
                        <tr class="table-row-header">
                            <th class="table-header">Título</th>
                            <th class="table-header">Tipo</th>
                            <th class="table-header">Referência</th>
                            <th class="table-header">Publicado em</th>
                            <th class="table-header center">Status</th>
                            <th class="table-header center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="table-row-body">
                                {{-- Título --}}
                                <td class="table-body">
                                    <div class="font-semibold">
                                        {{ $report->title }}
                                    </div>

                                    @if ($report->description)
                                        <div class="text-xs text-gray-500">
                                            {{ Str::limit($report->description, 80) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Tipo --}}
                                <td class="table-body">
                                    <span class="badge badge-gray">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>

                                {{-- Referência --}}
                                <td class="table-body text-center">
                                    {{ $report->reference_month ? $report->reference_month->format('m/Y') : '—' }}
                                </td>

                                {{-- Publicação --}}
                                <td class="table-body text-center">
                                    {{ $report->published_at ? $report->published_at->format('d/m/Y') : '—' }}
                                </td>

                                {{-- Status --}}
                                <td class="table-body text-center">
                                    @if (!$report->is_published)
                                        <span class="badge badge-secondary">
                                            Rascunho
                                        </span>
                                    @elseif ($report->valid_until && now()->gt($report->valid_until->endOfDay()))
                                        <span class="badge badge-warning">
                                            Vencido
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Publicado
                                        </span>
                                    @endif
                                </td>

                                {{-- Ações --}}
                                <td class="table-actions">
                                    <div class="inline-flex gap-1">

                                        {{-- Baixar PDF --}}
                                        @can('reports.financial')
                                            <a href="{{ $report->file_url }}" target="_blank" class="btn-primary btn-sm"
                                                title="Baixar PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endcan

                                        {{-- Editar --}}
                                        @can('reports.edit')
                                            <a href="{{ route('reports.edit', $report) }}" class="btn-warning btn-sm"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        {{-- Excluir --}}
                                        @can('reports.delete')
                                            <form action="{{ route('reports.destroy', $report) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja excluir este relatório?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-danger btn-sm" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-file-pdf"></i>
                <p>Nenhum relatório cadastrado.</p>
                <p class="text-sm text-gray-500">
                    Utilize o botão <strong>Novo Relatório</strong> para começar.
                </p>
            </div>
        @endif
    </div>

@endsection
