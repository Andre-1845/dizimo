@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->
    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Receitas</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.admin') }}" class="breadcrumb-link">Dashboard</a>
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
            <x-action-buttons :list="route('donations.index')" :edit="route('donations.edit', $donation)" :delete="route('donations.destroy', $donation)" can-list="donations-view"
                can-edit="donations.edit" can-delete="donations.delete" delete-confirm="Deseja excluir esta doação ?" />
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
            <span class="inline-flex items-center gap-2">
                @if ($donation->is_confirmed)
                    <span class="text-green-600 font-semibold">Confirmada</span>
                    <span class="text-sm text-gray-600">
                        ({{ $donation->confirmed_at->format('d/m/Y H:i') }}
                        – {{ $donation->confirmedBy?->name }})
                    </span>
                @else
                    <span class="text-orange-500 font-semibold">
                        Aguardando confirmação
                    </span>
                @endif
            </span>

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
                            @include('components.icons.doc_view')
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
