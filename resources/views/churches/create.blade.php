@extends('layouts.admin')

@section('content')
    <h2 class="text-xl font-bold mb-4">Nova Igreja</h2>

    <form method="POST" action="{{ route('churches.store') }}" enctype="multipart/form-data">
        @csrf

        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-input">

        <label class="form-label">CNPJ</label>
        <input type="text" name="cnpj" class="form-input">

        <label class="form-label">Endereço</label>
        <input type="text" name="address" class="form-input">

        <label class="form-label">Logo</label>
        <input type="file" name="logo" class="file-input">

        <div class="mt-4">
            <button class="btn-success">
                Salvar
            </button>
        </div>
    </form>
@endsection
