@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Curso</h2>

    <form action="{{ route('courses.store') }}" method="post">
        {{-- O CSRF impede o envio de dados de outras fontes. So aceita do próprio app --}}
        @csrf
        @method('POST')

        <label for="">Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do curso" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
@endsection
