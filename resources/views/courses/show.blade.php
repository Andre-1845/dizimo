@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Curso</h2>
    <br>

    <x-alert />

    <br>
    @can('create-course')
        <a href="{{ route('courses.create') }}">Cadastrar</a><br>
    @endcan
    <a href="{{ route('home') }}">Inicio</a><br><br>

    {{-- Listar registro --}}


    ID: {{ $course->id }}<br>
    Nome: {{ $course->name }} <br>
    {{-- Carbon é uma biblioteca Laravel usada para o format --}}
    Criado: {{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y H:i:s') }} <br>
    Alterado: {{ \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y H:i:s') }} <br>
@endsection
