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
                    <span>Doações</span>
                </a>
            </div>
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        {{-- <div class="py-6 max-w-7xl mx-auto"> --}}
        <div class="table-container">

            {{-- <div class="bg-white shadow rounded overflow-x-auto"> --}}
            {{-- <table class="min-w-full border-collapse"> --}}
            <table class="table">
                {{-- <thead class="bg-gray-100 text-gray-700 text-sm"> --}}
                <thead>
                    <tr class="table-row-header">

                        <th class="table-header">Membro</th>
                        <th class="table-header">Categoria</th>
                        <th class="table-header text-center">Valor</th>
                        <th class="table-header text-center table-cell-lg-hidden">Data</th>
                        <th class="table-header text-center table-cell-lg-hidden">Comprovante</th>
                        <th class="table-header center w-20 whitespace-nowrap">Ação</th>
                    </tr>
                </thead>

                <tbody class="text-sm">
                    @forelse ($donations as $donation)
                        <tr class="table-row-body">
                            <td class="table-body">
                                {{ $donation->member->name ?? $donation->donor_name }}
                            </td>

                            <td class="table-body">
                                {{ $donation->category->name }}
                            </td>

                            <td class="table-body text-right font-semibold">
                                R$ {{ money($donation->amount) }}
                            </td>

                            <td class="table-body text-center">
                                {{ $donation->donation_date->format('d/m/Y') }}
                            </td>

                            <td class="table-body text-center">
                                @if ($donation->receipt_path)
                                    <div class="flex justify-center items-center">
                                        <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                            class="text-blue-600 hover:underline">
                                            @include('components.icons.doc_view')
                                        </a>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>


                            <td class="table-body text-center">
                                <form method="POST" action="{{ route('donations.confirm', $donation) }}"
                                    onsubmit="return confirm('Confirmar esta doação?')">
                                    @csrf
                                    @method('PATCH')

                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Confirmar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Nenhuma doação pendente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $donations->links() }}

        </div>

    </div> <!-- FIM Content-Box  -->
@endsection
