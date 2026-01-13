@extends('layouts.admin')

@section('title', 'Nova Pessoa')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Nova Pessoa</h1>

    <form action="{{ route('admin.site.people.store') }}" method="POST" class="max-w-3xl space-y-6">
        @csrf

        @include('admin.site.people.partials.form')

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.site.people.index') }}" class="btn-secondary">
                Cancelar
            </a>

            <button class="btn-primary">
                Salvar
            </button>
        </div>
    </form>



@endsection
