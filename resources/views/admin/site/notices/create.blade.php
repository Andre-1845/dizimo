@extends('layouts.admin')

@section('title', 'Novo Aviso')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-semibold mb-6">Novo Aviso</h1>

        <form action="{{ route('admin.site.notices.store') }}" method="POST">
            @include('admin.site.notices.partials.form')
        </form>
    </div>
@endsection
