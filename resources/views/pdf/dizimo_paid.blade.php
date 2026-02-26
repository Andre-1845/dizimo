<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 40px 30px 70px 30px;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;

            text-align: center;
            font-size: 9px;
            color: #999;
        }

        body {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        th {
            background: #f0f0f0;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>Membros Dizimistas</h1>
    <p>Período: {{ \App\Helpers\DateHelper::periodoExtenso($month, $year) }}</p>
    @if ($church)
        <h3 style="margin-bottom:5px;">
            {{ $church->name }}
        </h3>
    @endif
    <table>
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Membro</th>
                <th>Data</th>
                <th class="right">Valor doado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}
                        @if (!$member->active)
                            <span class="text-xs text-gray-500">(Inativo)</span>
                        @endif

                    </td>

                    <td class="center">
                        @foreach ($member->donations as $donation)
                            {{ $donation->donation_date->format('d/m/Y') }}<br>
                        @endforeach
                    </td>

                    <td class="right">
                        R$ {{ number_format($member->donations->sum('amount'), 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- RODAPÉ --}}
    <footer>
        Relatório dízimo – período
        {{ \App\Helpers\DateHelper::periodoExtenso($month, $year) }}
        — página <span class="page-number"></span>
    </footer>
    <style>
        .page-number:after {
            content: counter(page);
        }
    </style>

</body>

</html>
