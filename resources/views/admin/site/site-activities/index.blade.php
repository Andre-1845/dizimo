@extends('layouts.admin')

@section('title', 'Horários e Informações')

@section('content')

    <div class="mb-6">
        <h1 class="content-title my-4">Horários e Informações</h1>
        <p class="text-gray-500">Gerencie missas, confissões e atividades semanais</p>
    </div>

    <div class="flex justify-between mb-4">
        <div>
            <a href="{{ route('admin.site.index') }}" class="btn-info">
                Voltar
            </a>
        </div>
        <div>
            <a href="{{ route('admin.site.site-activities.create') }}" class="btn-primary">
                @include('components.icons.plus')
                Nova Atividade
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="table">
            <thead>
                <tr class="table-row-header">
                    <th class="table-header">Ordem</th>
                    <th class="table-header">Atividade</th>
                    <th class="table-header">Dia</th>
                    <th class="table-header">Horário</th>
                    <th class="table-header">Status</th>
                    <th class="table-header center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($activities as $activity)
                    <tr class="table-row-body">
                        <td class="table-body text-center">{{ $activity->order }}</td>
                        <td class="table-body font-medium">{{ $activity->name }}</td>
                        <td class="table-body">{{ $activity->day }}</td>
                        <td class="table-body">{{ $activity->time }}</td>
                        <td class="table-body text-center">
                            @if ($activity->active)
                                <span class="text-green-600">Ativo</span>
                            @else
                                <span class="text-gray-500">Inativo</span>
                            @endif
                        </td>
                        <td class="table-actions">
                            <div class="flex justify-center items-center gap-6">

                                <a href="{{ route('admin.site.site-activities.edit', $activity) }}" class="btn-primary">
                                    Editar
                                </a>
                                <form action="{{ route('admin.site.site-activities.destroy', $activity) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Remover esta atividade?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="table-row-body">
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                            Nenhuma atividade cadastrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
