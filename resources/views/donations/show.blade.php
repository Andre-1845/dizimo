@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Receitas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <a href="{{ route('donations.index') }}" class="breadcrumb-link">Receitas</a>
                <span>/</span>
                <span>Visualizar</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Detalhes da Receita</h3>

            <!-- Botoes (com icones)  -->
            <!-- Botoes (com icones)  -->
            <x-action-buttons :list="route('donations.index')" :edit="route('donations.edit', $donation)" :delete="route('donations.destroy', $donation)" can-list="index-donation"
                can-edit="edit-donation" can-delete="destroy-donation" delete-confirm="Deseja excluir esta doação ?" />
            <!-- Botoes (com icones)  -->
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">Membro: </span>
                <span class="detail-content">{{ $donation->display_donor }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Categoria: </span>
                <span class="detail-content">{{ $donation->category->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Forma de Pagamento: </span>
                <span class="detail-content">{{ $donation->paymentMethod?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Valor: </span>
                <span class="detail-content">{{ $donation->amount }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Lançado por: </span>
                <span class="detail-content">{{ $donation->user?->name }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Data: </span>
                <span class="detail-content">{{ \Carbon\Carbon::parse($donation->donation_date)->format('d/m/Y') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Notas: </span>
                <span class="detail-content">{{ $donation->notes }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Comprovante (doc): </span>
                <span class="detail-content">
                    @if ($donation->receipt_path)
                        <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                            class="text-blue-600 font-bold hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>

                        </a>
                    @else
                        —
                    @endif
                </span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Criado em:</span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($donation->created_at)->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="mb-1">
                <span class="title-detail-content">Modificado em: </span>
                <span
                    class="detail-content">{{ \Carbon\Carbon::parse($donation->updated_at)->format('d/m/Y H:i:s') }}</span>
            </div>
        </div>

    </div>
@endsection
