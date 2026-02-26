@extends('layouts.admin')

@section('content')
    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Igrejas</h2>
            <x-smart-breadcrumb :items="[['label' => 'Igrejas']]" />
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->


    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botao CADASTRAR (com icone)  -->
            @can('create', \App\Models\User::class)
                <div class="content-box-btn">
                    <a href="{{ route('churches.create') }}" class="btn-success flex items-center space-x-1">
                        @include('components.icons.plus')
                        <span>Cadastrar</span>
                    </a>
                </div>
            @endcan
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <div class="table-container">

            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header text-center table-cell-lg-hidden">ID</th>
                        <th class="table-header">Nome</th>
                        <th class="table-header text-center table-cell-lg-hidden">CNPJ</th>
                        <th class="table-header table-cell-lg-hidden">Endereço</th>
                        <th class="table-header text-center">Membros</th>
                        <th class="table-header text-center table-cell-lg-hidden">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($churches as $church)
                        <tr class="table-row-body">
                            <td class="table-body text-center table-cell-lg-hidden">{{ $church->id }}</td>
                            <td class="table-body">{{ $church->name }}</td>
                            <td class="table-body text-right table-cell-lg-hidden">{{ $church->cnpj }}</td>
                            <td class="table-body table-cell-lg-hidden">{{ $church->address }}</td>
                            <td class="table-body text-center">
                                {{ $church->members_total }}
                            </td>

                            <x-table-actions-icons :show="route('churches.show', $church)" :edit="route('churches.edit', $church)" :delete="route('churches.destroy', $church)" :can-delete="'settings.access'"
                                confirm="Deseja excluir a igreja * {{ $church->name }} * ?" />

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Nenhuma igreja cadastrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $churches->links() }}
            </div>

        </div>
    </div>
@endsection
