@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Dashboard</h2>
            <nav class="breadcrumb">
                <span>Dashboard</span>
            </nav>
        </div>
    </div>
    <!-- Titulo e trilha de navegacao -->


    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title">Página Inicial</h3>
            <div class="content-box-btn"></div>
        </div>

        <x-alert />

        <div class="content-box-body">
            Bem-vindo ...!
        </div>
    </div>
@endsection
