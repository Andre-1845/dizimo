@extends('layouts.admin')

@section('title', 'Agenda do Site')

@section('content')

    <h1 class="content-title my-6">Agenda do Site</h1>
    <div class="flex justify-between mb-4">
        <div>
            <a href="{{ route('admin.site.index') }}" class="btn-info">
                Voltar
            </a>
        </div>

        <div>
            <a href="{{ route('admin.site.events.create') }}" class="btn-primary mb-4">
                @include('components.icons.plus')
                Novo Evento
            </a>
        </div>

    </div>

    <table class="table">
        <thead>
            <tr class="table-row-header ">
                <th class="table-header center">Data</th>
                <th class="table-header">Título</th>
                <th class="table-header center">Status</th>
                <th class="table-header center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr class="table-row-body">
                    <td class="table-body text-center">{{ $event->event_date->format('d/m/Y') }}</td>
                    <td class="table-body">{{ $event->title }}</td>
                    <td class="table-body text-center">
                        {{ $event->is_active ? 'Ativo' : 'Inativo' }}
                    </td>
                    <td class="table-actions">
                        <div class="flex justify-center items-center">
                            <a href="{{ route('admin.site.events.edit', $event) }}" class="btn-primary">
                                Editar
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $events->links() }}
    </div>

@endsection
