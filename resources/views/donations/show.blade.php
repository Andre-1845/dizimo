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
            <div class="content-box-btn">

                <!-- Botao LISTAR (com icone)  -->
                <a href="{{ route('donations.index') }}" class="btn-primary align-icon-btn" title="Listar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>

                    <span class="hide-name-btn">Listar</span>
                </a>
                <!-- Fim - Botao LISTAR  -->

                <!-- Botao EDITAR (com icone)  -->
                <a href="{{ route('donations.edit', ['donation' => $donation->id]) }}" class="btn-warning align-icon-btn"
                    title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>

                    <span class="hide-name-btn">Editar</span>
                </a>
                <!-- Fim - Botao EDITAR -->

                <!-- Botao APAGAR(com icone)  -->

                <form action="{{ route('donations.destroy', ['donation' => $donation->id]) }}" method="post">
                    @csrf
                    @method('delete')

                    <button class="btn-danger align-icon-btn" title="Apagar" type="submit"
                        onclick="return confirm('Tem certeza que deseja excluir este registro ?')">
                        <span class="py-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg></span>

                        <span class="hide-name-btn">Apagar</span>
                    </button>
                </form>

                <!-- Fim - Botao APAGAR -->
            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />


        <div class="detail-box">
            <div class="mb-1">
                <span class="title-detail-content">Membro: </span>
                <span class="detail-content">{{ $donation->member->name }}</span>
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
