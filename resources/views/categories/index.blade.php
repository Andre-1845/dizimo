@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Categorias</h1>

        {{-- <a href="{{ route('donations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nova Doação
        </a> --}}
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr class="table-row-header">
                    <th class="table-header">Categoria</th>
                    <th class="table-header text-center">Tipo</th>
                    {{-- <th class="table-header table-cell-lg-hidden">Forma</th> --}}
                    <th class="table-header text-center">Data</th>
                    {{-- <th class="table-header table-cell-lg-hidden">Cadastrado por</th>
                    <th class="table-header center">Valor</th> --}}
                    <th class="table-header center">Ações</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="table-row-body">
                        <td class="table-body">{{ $category->name ?? '—' }}</td>
                        <td class="table-body text-center">{{ $category->type ?? '—' }}</td>
                        {{-- <td class="table-body table-cell-lg-hidden">{{ $categories->paymentMethod->name ?? '—' }}</td> --}}
                        <td class="table-body text-center">
                            {{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}
                        </td>
                        {{-- <td class="table-body table-cell-lg-hidden">{{ $categories>user->name ?? '—' }}</td>
                        </td> --}}
                        {{-- <td class="table-body text-right text-green-600 font-semibold">
                            R$ {{ number_format($categories>amount, 2, ',', '.') }}
                        </td> --}}
                        <td class="table-body table-actions">
                            <div class="flex items-center justify-end gap-2">
                                <a class="btn-warning" href="{{ route('categories.index', $category->id) }}">
                                    Editar
                                </a>

                                <form action="{{ route('categories.index', $category->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Deseja excluir esta doação?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger py-2">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-600">
                            Nenhuma doação registrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>

@endsection
