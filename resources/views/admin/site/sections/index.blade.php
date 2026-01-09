@extends('layouts.admin')

@section('title', 'Seções do Site')

@section('content')

    <h1 class="content-title">Seções da Homepage</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Chave</th>
                <th>Título</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sections as $section)
                <tr>
                    <td>{{ $section->order }}</td>
                    <td>{{ $section->key }}</td>
                    <td>{{ $section->title }}</td>
                    <td>
                        {{ $section->is_active ? 'Ativa' : 'Inativa' }}
                    </td>

                    <td class="flex gap-3">
                        <a href="{{ route('admin.site.sections.edit', $section) }}" class="text-blue-600 hover:underline">
                            Editar
                        </a>

                        <a href="{{ route('admin.site.images.index', $section) }}" class="text-green-600 hover:underline">
                            Imagens
                        </a>
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
