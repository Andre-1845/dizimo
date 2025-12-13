@extends('layouts.admin')

@section('content')
    <h2>Editar Curso</h2>

    <form action="{{ route('courses.update', ['course' => $course->id]) }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('PUT')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $course->name) }}" placeholder="Nome do curso"
            required><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
