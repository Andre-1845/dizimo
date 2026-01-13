@extends('layouts.admin')

@section('title', 'Editar Pessoa')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Editar Pessoa</h1>

    <form action="{{ route('admin.site.people.update', $person) }}" method="POST" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @include('admin.site.people.partials.form', ['person' => $person])

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.site.people.index') }}" class="btn-secondary">
                Cancelar
            </a>

            <button class="btn-primary">
                Atualizar
            </button>
        </div>
    </form>


@endsection
