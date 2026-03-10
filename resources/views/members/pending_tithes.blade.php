@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">
                Pendências de Dízimo
            </h2>

            <x-smart-breadcrumb :items="[
                ['label' => 'Membros', 'url' => route('members.index')],
                ['label' => $member->name, 'url' => route('members.show', $member)],
                ['label' => 'Pendências'],
            ]" />
        </div>
    </div>
    <!-- Titulo e trilha de navegacao -->
    <div class="content-box">
        <div class="content-box-header">
            <h3 class="content-box-title font-bold text-black">{{ $member->name }}</h3>
            @php
                $backRoute = auth()->user()->can('viewAny', App\Models\Member::class)
                    ? route('members.index')
                    : route('dashboard.member');
            @endphp
            <a href="{{ $backRoute }}" class="btn-info flex items-center space-x-1">
                <span>Voltar</span>
            </a>
        </div>

        @php
            $totalPending = collect($months)->sum(function ($m) {
                return $m['missing'] ?? $m['expected'];
            });
        @endphp

        @if (count($months) == 0)
            <div class="text-green-600 font-semibold">
                Nenhuma pendência encontrada.
            </div>
        @else
            <div class="mb-4 text-right">
                <span class="text-gray-600 font-semibold">Total pendente:</span>
                <span class="text-red-600 font-bold text-lg">
                    R$ {{ money($totalPending) }}
                </span>
            </div>
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Mês</th>
                        <th class="table-header table-cell-lg-hidden text-center">Ano</th>
                        <th class="table-header table-cell-lg-hidden text-center">Valor Previsto</th>
                        <th class="table-header text-center">Pago</th>
                        <th class="table-header text-center">Pendente</th>
                    </tr>
                </thead>

                <tbody>

                    {{-- @foreach ($months as $m)
                        <tr class="table-row-body">
                            <td class="table-body">{{ ucfirst($m['month_name']) }}</td>
                            <td class="table-body table-cell-lg-hidden text-center">{{ $m['year'] }}</td>
                            <td class="table-body table-cell-lg-hidden text-red-600 font-semibold text-center">
                                R$ {{ money($m['expected']) }}
                            </td>
                        </tr>
                    @endforeach --}}

                    @foreach ($months as $m)
                        <tr class="table-row-body">
                            <td class="table-body">{{ ucfirst($m['month_name']) }}</td>

                            <td class="table-body text-center">
                                {{ $m['year'] }}
                            </td>

                            <td class="table-body text-center">
                                R$ {{ money($m['expected']) }}
                            </td>

                            <td class="table-body text-center text-green-600 font-semibold">
                                R$ {{ money($m['paid']) }}
                            </td>

                            <td class="table-body text-center text-red-600 font-semibold">
                                R$ {{ money($m['missing']) }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif

    </div>
@endsection
