@extends('layouts.admin')

@section('title', 'Editar Aviso')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Editar Aviso</h1>

        <form action="{{ route('admin.site.notices.update', $notice) }}" method="POST">
            @method('PUT')
            @include('admin.site.notices.partials.form', ['notice' => $notice])
        </form>
    </div>
@endsection
