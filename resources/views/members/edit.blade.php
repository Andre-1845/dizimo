@extends('layouts.admin')

@section('title', 'Editar Membro')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Editar Membro</h1>

    <form action="{{ route('members.update', $member) }}" method="POST" class="content-box space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="form-label">Nome *</label>
            <input type="text" name="name" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input">
        </div>

        <div>
            <label class="form-label">Telefone</label>
            <input type="text" name="phone" class="form-input">
        </div>

        <div>
            <label>
                <input type="checkbox" name="active" value="1" checked>
                Ativo
            </label>
        </div>

        <div class="flex justify-end">
            <button class="btn-primary-md">
                Salvar
            </button>
        </div>
    </form>

@endsection
