@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Papel</h2>

    <x-alert /><br>

    <form action="{{ route('roles.store') }}" method="post">
        @csrf
        @method('POST')

        <label for="">Papel:</label>
        <input type="text" name="name" id="name" placeholder="Digite o papel"><br>

        <input type="hidden" name="guard_name" id="guard_name" value="web" readonly>

        <button type="submit">Cadastrar</button>
    </form>
@endsection
