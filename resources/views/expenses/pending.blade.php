@extends('layouts.admin')

@section('title', 'Despesas Pendentes')

@section('content')


    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Despesas Pendentes de Validação</h2>
        </div>
    </div>

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botao VOLTAR (com icone)  -->
            <div class="content-box-btn">
                <a href="{{ route('expenses.index') }}" class="btn-primary flex items-center space-x-1">
                    @include('components.icons.list')
                    <span>Despesas</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <div class="table-container">
            @include('components.confirmations._table', [
                'items' => $expenses,
            
                'headers' => [
                    ['label' => 'Descrição'],
                    ['label' => 'Categoria', 'class' => 'text-center table-cell-lg-hidden'],
                    ['label' => 'Valor', 'class' => 'text-center'],
                    ['label' => 'Data', 'class' => 'text-center'],
                    ['label' => 'Comprovante', 'class' => 'text-center table-cell-lg-hidden'],
                ],
            
                'columns' => [
                    [
                        'value' => fn($e) => $e->description,
                    ],
                    [
                        'class' => 'text-center table-cell-lg-hidden',
                        'value' => fn($e) => $e->category->name,
                    ],
                    [
                        'class' => 'text-right font-semibold',
                        'value' => fn($e) => 'R$ ' . money($e->amount),
                    ],
                    [
                        'class' => 'text-center',
                        'value' => fn($e) => $e->expense_date->format('d/m/Y'),
                    ],
                    [
                        'class' => 'text-center table-cell-lg-hidden',
                        'value' => fn($e) => $e->receipt_path
                            ? '<div class="flex justify-center items-center">' .
                                '<a href="' .
                                asset('storage/' . $e->receipt_path) .
                                '" target="_blank"' .
                                ' class="inline-flex items-center justify-center text-blue-600 hover:underline">' .
                                view('components.icons.doc_view')->render() .
                                '</a>' .
                                '</div>'
                            : '—',
                    ],
                ],
            
                'confirmRoute' => 'expenses.confirm',
                'permission' => 'expenses.approve',
                'confirmMessage' => 'Confirmar esta despesa?',
                'emptyMessage' => 'Nenhuma despesa pendente.',
            ])

        </div>

    </div>

    <div class="mt-4">
        {{ $expenses->links() }}

    </div>

    </div> <!-- FIM Content-Box  -->
@endsection
