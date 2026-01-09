@extends('layouts.admin')

@section('title', 'Agenda do Site')

@section('content')

    <h1 class="content-title">Agenda do Site</h1>

    <a href="{{ route('admin.site.events.create') }}" class="btn-primary mb-4">
        Novo Evento
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Título</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->event_date->format('d/m/Y') }}</td>
                    <td>{{ $event->title }}</td>
                    <td>
                        {{ $event->is_active ? 'Ativo' : 'Inativo' }}
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.site.events.edit', $event) }}" class="text-blue-600">
                            Editar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $events->links() }}
    </div>

@endsection
