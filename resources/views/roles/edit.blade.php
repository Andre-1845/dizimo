@extends('layouts.admin')

@section('content')
    <h2>Editar Papel</h2>
    <br>
    <x-alert />

    <br><br>

    <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="post"><br>
        @csrf
        @method('PUT')

        <label for="papel">Papel: </label>
        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}"><br><br>
        <input type="hidden" name="guard_name" id="guard_name" value="web">
        <button type="submit">Salvar</button>
    </form>
@endsection
