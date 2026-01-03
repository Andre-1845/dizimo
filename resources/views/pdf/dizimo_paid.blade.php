<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 40px 30px 60px 30px;
            /* espaço para rodapé */
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

    <table>
        <thead>
            <tr>
                <th>Ordem</th>
                <th>Membro</th>
                <th>Data</th>
                <th class="right">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>

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
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Relatório dízimo do período {{ sprintf('%02d', $month) }}/{{ $year }}        página {PAGE_NUM}/{PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("DejaVu Sans", "normal");
            $color = [150, 150, 150];

            $width = $fontMetrics->getTextWidth($text, $font, $size);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 40;

            $pdf->page_text($x, $y, $text, $font, $size, $color);
        }
    </script>

</body>

</html>
