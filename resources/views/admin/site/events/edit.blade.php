@extends('layouts.admin')

@section('title', 'Editar Evento')

@section('content')

    <h1 class="content-title my-6">Editar Evento</h1>

    <form method="POST" action="{{ route('admin.site.events.update', $event) }}">
        @csrf
        @method('PUT')

        @include('admin.site.events.partials.form', ['event' => $event])

        <button class="btn-primary">Salvar</button>
    </form>

@endsection
