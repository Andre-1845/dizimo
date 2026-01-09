@extends('layouts.admin')

@section('title', 'Novo Evento')

@section('content')

    <h1 class="content-title">Novo Evento</h1>

    <form method="POST" action="{{ route('admin.site.events.store') }}">
        @csrf

        @include('admin.site.events.partials.form')

        <button class="btn-primary">Salvar</button>
    </form>

@endsection
