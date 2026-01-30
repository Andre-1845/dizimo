<!DOCTYPE html>
<html>

<head>
    <title>Transparência - Teste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Transparência Financeira - SIMPLIFICADA</h1>

        <div class="alert alert-success">
            <h4>Dados recebidos do Controller:</h4>
            <p>Ano: {{ $year }}</p>
            <p>Receitas: R$ {{ number_format($totalIncome, 2, ',', '.') }}</p>
            <p>Despesas: R$ {{ number_format($totalExpenses, 2, ',', '.') }}</p>
            <p>Saldo: R$ {{ number_format($balance, 2, ',', '.') }}</p>
        </div>

        <h3>Todos os dados:</h3>
        <pre>{{ print_r(get_defined_vars(), true) }}</pre>
    </div>
</body>

</html>
