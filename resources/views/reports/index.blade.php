@extends('layouts.admin')

@section('title', 'Relatórios Financeiros')

@section('content')

    <div class="content-wrapper">
        <div class="content-header flex justify-between items-center">
            <div>
                <h2 class="content-title">Relatórios Financeiros</h2>
                <p class="text-sm text-gray-500">
                    Gerencie os relatórios PDF utilizados na Transparência.
                </p>
            </div>

            @can('create', \App\Models\FinancialReport::class)
                <a href="{{ route('reports.create') }}" class="btn-success-md">
                    <i class="fas fa-plus"></i> Novo Relatório
                </a>
            @endcan
        </div>
    </div>

    <div class="content-box">
        <x-alert />

        @if ($reports->count())
            <div class="table-responsive">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Referência</th>
                            <th>Publicado em</th>
                            <th>Status</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                {{-- Título --}}
                                <td>
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
                                <td>
                                    <span class="badge badge-gray">
                                        {{ ucfirst($report->type) }}
                                    </span>
                                </td>

                                {{-- Referência --}}
                                <td>
                                    {{ $report->reference_month ? $report->reference_month->format('m/Y') : '—' }}
                                </td>

                                {{-- Publicação --}}
                                <td>
                                    {{ $report->published_at ? $report->published_at->format('d/m/Y') : '—' }}
                                </td>

                                {{-- Status --}}
                                <td>
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
                                <td class="text-right">
                                    <div class="inline-flex gap-1">

                                        {{-- Baixar PDF --}}
                                        <a href="{{ $report->file_url }}" target="_blank" class="btn-primary btn-sm"
                                            title="Baixar PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>

                                        {{-- Editar --}}
                                        @can('update', $report)
                                            <a href="{{ route('reports.edit', $report) }}" class="btn-warning btn-sm"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        {{-- Excluir --}}
                                        @can('delete', $report)
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
