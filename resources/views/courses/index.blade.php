@extends('layouts.admin')

@section('content')
    <h2>Listar Cursos</h2>
    <br>

    <x-alert />

    <br>
    @can('create-course')
        <a href="{{ route('courses.create') }}">Cadastrar</a><br>
    @endcan

    {{-- Listar registros --}}

    @forelse ($cursos as $item)
        ID: {{ $item->id }}<br>
        Nome: {{ $item->name }} <br>
        @can('show-course')
            <a href="{{ route('courses.show', ['course' => $item->id]) }}">Visualizar</a><br>
        @endcan
        @can('edit-course')
            <a href="{{ route('courses.edit', ['course' => $item->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-course')
            <form action="{{ route('courses.destroy', ['course' => $item->id]) }}" method="post">
                @csrf
                @method('delete')

                <button type="submit"
                    onclick="return confirm('Tem certeza que deseja apagar o curso {{ $item->name }} ?')">Apagar</button>
            </form>
        @endcan

        <hr>
    @empty
        <p>Nenhum item cadastrado</p>
    @endforelse
@endsection
