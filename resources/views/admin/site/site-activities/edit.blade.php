@extends('layouts.admin')

@section('title', 'Editar Atividade')

@section('content')

    <h1 class="content-title my-6">Editar Atividade</h1>


    <form action="{{ route('admin.site.site-activities.update', $siteActivity) }}" method="POST" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @include('admin.site.site-activities.partials.form', [
            'activity' => $siteActivity,
        ])

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.site.site-activities.index') }}" class="px-4 py-2 bg-gray-200 rounded">
                Cancelar
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">
                Atualizar
            </button>
        </div>
    </form>

@endsection
