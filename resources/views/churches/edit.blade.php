@extends('layouts.admin')

@section('content')
    <h2 class="text-xl font-bold mb-4">Editar Igreja</h2>

    <form method="POST" action="{{ route('churches.update', $church) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $church->name) }}">

        <label class="form-label">CNPJ</label>
        <input type="text" name="cnpj" class="form-input" value="{{ old('cnpj', $church->cnpj) }}">

        <label class="form-label">Endereço</label>
        <input type="text" name="address" class="form-input" value="{{ old('address', $church->address) }}">

        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="file-input">

        @if ($church->logo)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $church->logo) }}" class="h-16">
            </div>
        @endif

        <div class="mt-4">
            <button class="btn-success">
                Atualizar
            </button>
        </div>
    </form>
@endsection
