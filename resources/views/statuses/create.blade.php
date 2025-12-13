@extends('layouts.admin')

<form action="{{ route('statuses.store') }}" method="post">
    @csrf
    @method('POST')

    <label for="">Nome : </label>
    <input type="text" name="name" id="name" placeholder="Nome do Status" required>

    <button type="submit">Cadastrar</button>
</form>
