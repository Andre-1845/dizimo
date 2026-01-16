@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')

    <div class="content-box"> <!-- Content-Box  -->

        <div style="background: #e3f2fd; padding: 15px; margin: 15px 0; border-radius: 5px;">
            <h4>🔍 Diagnóstico de Permissões:</h4>
            <p>Usuário: {{ Auth::user()->name }}</p>
            <p>Pode ver categorias? {{ Auth::user()->can('categories.view') ? '✅ SIM' : '❌ NÃO' }}</p>
            <p>Pode editar categorias? {{ Auth::user()->can('categories.edit') ? '✅ SIM' : '❌ NÃO' }}</p>
            <p>Pode excluir categorias? {{ Auth::user()->can('categories.delete') ? '✅ SIM' : '❌ NÃO' }}</p>
            <p>É superadmin? {{ Auth::user()->hasRole('superadmin') ? '✅ SIM' : '❌ NÃO' }}</p>
        </div>
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botoes (com icones)  -->
            <div class="content-box-btn">

                <!-- Botao NOVA DOACAO (com icone)  -->
                <div class="content-box-btn">
                    <a href="{{ route('categories.create') }}" class="btn-success flex items-center space-x-1"
                        title="Cadastrar">
                        @include('components.icons.plus')

                        <span>Nova Categoria</span>
                    </a>
                </div>
                <!--FIM  Botao NOVA DOACAO (com icone)  -->

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
                            <td class="table-body">{{ $category->name ?? '—' }}</td>

                            <td class="table-body text-center">
                                <span
                                    class="font-bold @if ($category->type_label == 'Receita') text-blue-600 @else text-red-600 @endif">
                                    {{ $category->type_label }}
                                </span>
                            </td>


                            <td class="table-body text-center">
                                {{ \Carbon\Carbon::parse($category->created_at)->format('d/m/Y') }}
                            </td>

                            <x-table-actions-icons :show="route('categories.show', $category)" :edit="route('categories.edit', $category)" :delete="route('categories.destroy', $category)"
                                confirm="Deseja excluir esta categoria?" canShow="categories.view" canEdit="categories.edit"
                                canDelete="categories.delete" />
                        </tr>
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
