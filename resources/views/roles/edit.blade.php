@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Papéis</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('roles.index') }}" class="breadcrumb-link">Papéis</a>
                <span>/</span>
                <span>Editar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Editar</h3>

        </div>

        <x-alert />

        <div class="form-div">
            <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="post"><br>
                @csrf
                @method('PUT')

                <label for="papel" class="form-label">Papel: </label>
                <input type="text" class="form-input" name="name" id="name"
                    value="{{ old('name', $role->name) }}">
                <input type="hidden" name="guard_name" id="guard_name" value="web">
                <div class="btn-md-div">
                    <button class="btn-success-md" type="submit">
                        @include('components.icons.save')
                        Salvar</button>
                </div>
            </form>
        </div>
    @endsection
