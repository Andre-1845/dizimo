@extends('layouts.admin')

@section('title', 'Seções do Site')

@section('content')

    {{-- Título --}}
    <div class="mb-6">
        <h1 class="content-title my-4">
            Seções da Homepage
        </h1>
        <div class="flex justify-between mb-4">
            <p class="text-gray-500">
                Gerencie a ordem, visibilidade e conteúdo das seções do site
            </p>
            <div>
                <a href="{{ route('admin.site.index') }}" class="btn-info">
                    Voltar
                </a>
            </div>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">

        <table class="table">
            <thead>
                <tr class="table-row-header">
                    <th class="table-header center">Ordem</th>
                    <th class="table-header">Chave</th>
                    <th class="table-header">Título</th>
                    <th class="table-header center">Status</th>
                    <th class="table-header center">Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sections as $section)
                    <tr class="bg-gray-50 hover:bg-gray-100 transition rounded">

                        <td class="table-body text-center">
                            {{ $section->order }}
                        </td>

                        <td class="table-body">
                            {{ $section->key }}
                        </td>

                        <td class="table-body">
                            {{ $section->title }}
                        </td>

                        <td class="table-body text-center">
                            @if ($section->is_active)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Ativa
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                    Inativa
                                </span>
                            @endif
                        </td>

                        <td class="table-actions">
                            <div class="inline-flex gap-2">
                                @if ($section->key === 'activities')
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('admin.site.sections.edit', $section) }}" class="btn-primary">
                                            Editar
                                        </a>

                                        <a href="{{ route('admin.site.site-activities.index') }}"
                                            class="px-3 py-2 text-sm rounded bg-purple-600 text-white hover:bg-purple-700">
                                            Gerenciar Horários
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('admin.site.sections.edit', $section) }}" class="btn-primary">
                                        Editar
                                    </a>

                                    <a href="{{ route('admin.site.images.index', $section) }}" class="btn-success">
                                        Imagens
                                    </a>
                                @endif
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
