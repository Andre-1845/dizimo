@extends('layouts.admin')

@section('title', 'Membros')

@section('content')

    <!-- Titulo e trilha de navegacao -->

    <div class="content-wrapper">
        <div class="content-header">
            <h2 class="content-title">Membros</h2>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard.index') }}" class="breadcrumb-link">Dashboard</a>
                <span>/</span>
                <span>Membros</span>
            </nav>
        </div>
    </div>

    <!-- Titulo e trilha de navegacao -->

    <div class="content-box"> <!-- Content-Box  -->
        <div class="content-box-header">
            <h3 class="content-box-title">Listar</h3>

            <!-- Botao CADASTRAR (com icone)  -->
            @can('create', \App\Models\Member::class)
                <div class="content-box-btn">
                    <a href="{{ route('members.create') }}" class="btn-success flex items-center space-x-1">
                        @include('components.icons.plus')
                        <span>Cadastrar</span>
                    </a>
                </div>
            @endcan
            <!--FIM  Botao CADASTRAR (com icone)  -->
        </div>

        <x-alert />

        <x-filters.generic :filters="$filters" route="members.index" />

        <div class="content-box">
            <table class="table">
                <thead>
                    <tr class="table-row-header">
                        <th class="table-header">Nome</th>
                        <th class="table-header">Email</th>
                        <th class="table-header">Status</th>
                        <th class="table-header text-center">Dizimo prev</th>
                        <th class="table-header text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr class="table-row-body">
                            <td class="table-body">{{ $member->name }}</td>
                            <td class="table-body">{{ $member->user->email ?? '—' }}</td>
                            <td class="table-body">
                                @if ($member->active)
                                    <x-badge type="active">Ativo</x-badge>
                                @else
                                    <x-badge type="inactive">Inativo</x-badge>
                                @endif
                            </td>
                            <td class="table-body text-right">{{ $member->monthly_tithe ?? '—' }}</td>
                            <x-table-actions-icons :show="Gate::allows('view', $member) ? route('members.show', $member) : null" :edit="Gate::allows('update', $member) ? route('members.edit', $member) : null" :delete="Gate::allows('delete', $member) && auth()->id() !== $member->user_id
                                ? route('members.destroy', $member)
                                : null" />
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Nenhum membro cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $members->links() }}
            </div>
        </div>

    @endsection
