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

        /* antigo */

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

    <h1>Membros com Dízimo Pendente</h1>
    <p>Período: {{ \App\Helpers\DateHelper::periodoExtenso($month, $year) }}</p>

    <table>
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Membro</th>
                <th class="right">Valor Previsto</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($members as $member)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>
                    <td class="right">
                        R$ {{ number_format($member->monthly_tithe, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
