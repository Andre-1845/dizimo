@extends('layouts.admin')

@section('title', 'Editar Doação')

@section('content')
    <div class="content-header">
        <h1 class="content-title">Editar Doação</h1>
        <x-smart-breadcrumb :items="[['label' => 'Editar']]" />
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded shadow p-6">
            <form action="{{ route('member.donations.update', $donation) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="form-label">Categoria *</label>
                    <select class="form-input" name="category_id" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $donation->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Valor (R$) *</label>
                    <input type="number" name="amount" step="0.01" min="0.01"
                        value="{{ old('amount', $donation->amount) }}" class="form-input" required>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Data da Doação *</label>
                    <input class="form-input" type="date" name="donation_date"
                        value="{{ old('donation_date', $donation->donation_date->format('Y-m-d')) }}" required>
                    @error('donation_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Forma de Pagamento</label>
                    <select name="payment_method_id" class="form-input">
                        <option value="">Selecione</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}" @selected(old('payment_method_id', $donation->payment_method_id) == $method->id)>
                                {{ $method->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Comprovante Atual</label>
                    @if ($donation->receipt_path)
                        <div class="form-input">
                            <a href="{{ asset('storage/' . $donation->receipt_path) }}" target="_blank"
                                class="text-blue-600 hover:underline">
                                Visualizar comprovante atual
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">Nenhum comprovante anexado</p>
                    @endif

                    <label class="form-label">Substituir comprovante (opcional)</label>
                    <input class="file-input" type="file" name="receipt" class="form-input"
                        accept=".jpg,.jpeg,.png,.pdf">
                    <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, PDF (max: 2MB)</p>
                </div>

                <div class="mb-6">
                    <label class="form-label">Observações</label>
                    <textarea name="notes" rows="3" class="form-input">{{ old('notes', $donation->notes) }}</textarea>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('dashboard.member') }}" class="btn-danger">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        Atualizar Doação
                    </button>
                </div>
            </form>
        </div>

        {{-- Card de informações --}}
        <div class="bg-yellow-200 border border-black rounded p-4 mt-6">
            <h3 class="font-semibold text-black mb-2">⚠️ Atenção</h3>
            <p class="text-orange-700 text-sm font-bold">
                Esta doação ainda não foi validada pela tesouraria.
                Após a validação, não será mais possível editar.
            </p>
        </div>
    </div>
@endsection
