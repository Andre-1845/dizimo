{{-- Alerta normal SUCCESS --}}
@if (session('success'))
    <div class="alert-success">
        <span>{{ session('success') }}</span>
    </div>
@endif

{{-- Campos atualizados --}}
@if (session('updated_fields'))
    <div class="alert-info">
        <div class="font-semibold mb-1">📝 Campos atualizados:</div>
        <ul class="list-disc list-inside pl-4">
            @php
                $fieldLabels = [
                    'category_id' => 'Categoria',
                    'amount' => 'Valor',
                    'donation_date' => 'Data',
                    'payment_method_id' => 'Forma de Pagamento',
                    'receipt_path' => 'Comprovante',
                    'notes' => 'Observações',
                    'donor_name' => 'Nome do Doador',
                    'member_id' => 'Membro',
                    'user_id' => 'Usuário',
                ];
            @endphp

            @foreach (session('updated_fields') as $field)
                <li>{{ $fieldLabels[$field] ?? $field }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Alerta com SWEET ALERT - SUCCESS --}}
{{-- @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                title: "Pronto !",
                text: "{{ session('success') }}",
                icon: "success"
            });
        });
    </script>
@endif --}}

{{-- Alerta ERRO --}}
@if (session('error'))
    <div class="alert-danger">
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Aerta ERRO (varias mensagens) --}}
@if ($errors->any())
    <div class="alert-danger">
        @foreach ($errors->all() as $error)
            <span>{{ $error }}</span><br>
        @endforeach
    </div>
@endif
