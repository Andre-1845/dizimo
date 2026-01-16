@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Papéis</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('roles.index') }}" class="breadcrumb-link">Papéis</a>
                <span>/</span>
                <span>Cadastrar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Cadastrar</h3>

        </div>

        <x-alert />

        <div class="form-div">

            <form action="{{ route('roles.store') }}" method="post">
                @csrf
                @method('POST')

                <label for="" class="form-label">Papel</label>
                <input type="text" class="form-input" name="name" id="name" placeholder="Digite o papel"><br>

                <input type="hidden" name="guard_name" id="guard_name" value="web" readonly>

                <div class="btn-md-div">
                    <button class="btn-success-md" type="submit">
                        @include('components.icons.save')
                        Salvar</button>
                </div>
            </form>
        </div>
    @endsection
