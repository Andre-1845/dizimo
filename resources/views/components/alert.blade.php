{{-- Alerta normal SUCCESS --}}
@if (session('success'))
    <div class="alert-success">
        <span>{{ session('success') }}</span>
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
