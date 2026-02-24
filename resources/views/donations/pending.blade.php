@extends('layouts.admin')

@section('title', 'Doações Pendentes')

@section('content')


    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Receitas Pendentes de Validação</h2>
        </div>
    </div>

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botao VOLTAR (com icone)  -->
            <div class="content-box-btn">
                <a href="{{ route('donations.index') }}" class="btn-primary flex items-center space-x-1">
                    @include('components.icons.list')
                    <span>Receitas</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <div class="table-container">
            @include('components.confirmations._table', [
                'items' => $donations,
            
                'headers' => [
                    ['label' => 'Membro'],
                    ['label' => 'Categoria', 'class' => 'text-center table-cell-lg-hidden'],
                    ['label' => 'Valor', 'class' => 'text-center'],
                    ['label' => 'Data', 'class' => 'text-center'],
                    ['label' => 'Comprovante', 'class' => 'text-center table-cell-lg-hidden'],
                ],
            
                'columns' => [
                    [
                        'value' => fn($d) => $d->member->name ?? $d->donor_name,
                    ],
                    [
                        'class' => 'text-center table-cell-lg-hidden',
                        'value' => fn($d) => $d->category->name,
                    ],
                    [
                        'class' => 'text-right font-semibold',
                        'value' => fn($d) => 'R$ ' . money($d->amount),
                    ],
                    [
                        'class' => 'text-center',
                        'value' => fn($d) => $d->donation_date->format('d/m/Y'),
                    ],
                    [
                        'class' => 'text-center table-cell-lg-hidden',
                        'value' => fn($d) => $d->receipt_path
                            ? '<div class="flex justify-center items-center">' .
                                '<a href="' .
                                asset('storage/' . $d->receipt_path) .
                                '" target="_blank"' .
                                ' class="inline-flex items-center justify-center text-blue-600 hover:underline">' .
                                view('components.icons.doc_view')->render() .
                                '</a>' .
                                '</div>'
                            : '—',
                    ],
                ],
            
                'confirmRoute' => 'donations.confirm',
                'permission' => 'donations.confirm',
                'confirmMessage' => 'Confirmar esta receita?',
                'emptyMessage' => 'Nenhuma receita pendente.',
            ])

        </div>

    </div>

    <div class="mt-4">
        {{ $donations->links() }}

    </div>

    </div> <!-- FIM Content-Box  -->
@endsection
