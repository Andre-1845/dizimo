@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')

    <div class="content-box"> <!-- Content-Box  -->

        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao NOVA CATEGORIA (com icone)  -->
                <div class="content-box-btn">
                    @can('categories.create')
                        <a href="{{ route('categories.create') }}" class="btn-success flex items-center space-x-1"
                            title="Cadastrar">
                            @include('components.icons.plus')

                            <span>Nova Categoria</span>
                        </a>
                    @endcan
                </div>
                <!--FIM  Botao NOVA CATEGORIA (com icone)  -->

            </div>
            <!-- Botoes (com icones)  -->
        </div>

        <x-alert />

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Categoria</th>
                        <th class="table-header text-center">Tipo</th>

                        <th class="table-header text-center">Data</th>

                        <th class="table-header center">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="table-row-body">
                            <td class="table-body">
                                {{ $category->name ?? '—' }}
                                @if ($category->is_used)
                                    <span
                                        class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-200 text-blue-500">
                                        Em uso
                                    </span>
                                @endif
                            </td>

                            <td class="table-body text-center">
                                <span
                                    class="font-bold @if ($category->type_label == 'Receita') text-blue-600 @else text-red-600 @endif">
                                    {{ $category->type_label }}
                                </span>
                            </td>


                            <td class="table-body text-center">
                                {{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}
                            </td>

                            <x-table-actions-icons class="table-body table-cell-lg-hidden" :model="$category"
                                :show="route('categories.show', $category)" :edit="route('categories.edit', $category)" :delete="route('categories.destroy', $category)"
                                confirm="Deseja excluir o registro * {{ $category->name }} * ?" />
                        @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-600">
                                Nenhuma categoria registrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
