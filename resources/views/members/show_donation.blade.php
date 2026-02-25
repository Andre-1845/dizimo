@extends('layouts.admin')

@section('title', 'Detalhes da Colaboração')

@section('content')
    <div class="content-header">
        <h1 class="content-title">Detalhes da Colaboração</h1>
        <x-smart-breadcrumb :items="[['label' => 'Detalhes']]" />
    </div>

    <x-alert />

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Informações principais --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações da Colaboração</h3>



                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Data</p>
                            <p class="font-medium">{{ $donation->donation_date->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Categoria</p>
                            <p class="font-medium">{{ $donation->category->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Valor</p>
                            <p class="text-xl font-bold text-green-600">
                                R$ {{ number_format($donation->amount, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Informações complementares --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Detalhes Adicionais</h3>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Forma de Pagamento</p>
                            <p class="font-medium">{{ $donation->paymentMethod->name ?? 'Não informado' }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium
                                @if ($donation->is_confirmed) bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                @if ($donation->is_confirmed)
                                    Confirmada em {{ $donation->confirmed_at->format('d/m/Y H:i') }}
                                @else
                                    Aguardando validação
                                @endif
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Cadastrada por</p>
                            <p class="font-medium">{{ $donation->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $donation->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Comprovante --}}
            <div class="mt-8 pt-6 border-t">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Comprovante</h3>

                @if ($donation->receipt_path)
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <div class="text-blue-600">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="flex-1">
                            <p class="font-medium">Comprovante anexado</p>
                            <p class="text-sm text-gray-500">
                                {{ strtoupper(pathinfo($donation->receipt_path, PATHINFO_EXTENSION)) }} •
                                {{ Storage::disk('public')->size($donation->receipt_path) / 1024 }} KB
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                class="btn-primary px-4 py-2">
                                Visualizar
                            </a>

                            <a href="{{ route('member.donations.download-receipt', $donation) }}"
                                class="btn-info px-4 py-2">
                                Download
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2">Nenhum comprovante anexado</p>
                    </div>
                @endif
            </div>

            {{-- Observações --}}
            @if ($donation->notes)
                <div class="mt-8 pt-6 border-t">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Observações</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700">{{ $donation->notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Botões de ação --}}
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard.member') }}" class="btn-info">
                    Voltar para lista
                </a>
            </div>

            <div class="flex gap-3">
                @if (!$donation->is_confirmed)
                    <a href="{{ route('member.donations.edit', $donation) }}" class="btn-warning">
                        Editar Doação
                    </a>

                    <form action="{{ route('member.donations.destroy', $donation) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta doação?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            Excluir Colaboração
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Alerta para doações confirmadas --}}
        @if ($donation->is_confirmed)
            <div class="mt-6 p-4 bg-green-200 border border-black rounded-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="text-green-800 font-bold">
                        Esta colaboração já foi confirmada pela tesouraria e não pode mais ser editada ou excluída.
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
