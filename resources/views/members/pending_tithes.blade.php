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
            <a href="{{ route('members.index') }}" class="btn-info flex items-center space-x-1">
                <span>Voltar</span>
            </a>
        </div>

        @if (count($months) == 0)
            <div class="text-green-600 font-semibold">
                Nenhuma pendência encontrada.
            </div>
        @else
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Mês</th>
                        <th class="table-header table-cell-lg-hidden text-center">Ano</th>
                        <th class="table-header table-cell-lg-hidden text-center">Valor Previsto</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($months as $m)
                        <tr class="table-row-body">
                            <td class="table-body">{{ ucfirst($m['month_name']) }}</td>
                            <td class="table-body table-cell-lg-hidden text-center">{{ $m['year'] }}</td>
                            <td class="table-body table-cell-lg-hidden text-red-600 font-semibold text-center">
                                R$ {{ money($m['expected']) }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif

    </div>




@endsection
