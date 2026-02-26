@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Igrejas</h2>
            <x-smart-breadcrumb :items="[
                ['label' => 'Igrejas', 'url' => route('churches.index')],
                ['label' => $church->name, 'url' => route('churches.show', $church)],
                ['label' => 'Visualizar'],
            ]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes</h3>

            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('churches.index')" :edit="route('churches.edit', $church)" :delete="route('churches.destroy', $church)" can-edit="churches.edit"
                can-delete="churches.delete" delete-confirm="Deseja excluir a igreja {{ $church->name }}?" />
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">ID: </span>
                <span class="detail-content">{{ $church->id }}</span>
            </div>

            <div class="mb-1">
                <span class="title-detail-content">Nome: </span>
                <span class="detail-content">{{ $church->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Endereço: </span>
                <span class="detail-content">{{ $church->address }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">CNPJ: </span>
                <span class="detail-content">{{ $church->cnpj }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Logo:</span>
                <span class="detail-content">
                    @if ($church->logo)
                        <img src="{{ asset('storage/' . $church->logo) }}" class="h-16 rounded shadow">
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Total de Membros:</span>
                <span class="detail-content">
                    {{ $church->members_count ?? $church->members()->withoutGlobalScope('church')->count() }}
                </span>
            </div>


            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($church->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($church->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
@endsection
