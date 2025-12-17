@extends('layouts.admin')

@section('title', 'Membros')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Membros</h1>

        <a href="{{ route('members.create') }}" class="btn-primary-md">
            Novo Membro
        </a>
    </div>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                        <td class="table-body"><span class="{{ $member->active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $member->active ? 'Ativo' : 'Inativo' }}
                        </td>
                        <td class="table-body text-right">{{ $member->monthly_tithe ?? '—' }}</td>
                        <td class="table-body text-right space-x-2">
                            <a href="{{ route('members.edit', $member) }}" class="text-blue-600">
                                Editar
                            </a>

                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline"
                                onsubmit="return confirm('Deseja excluir este membro?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">
                                    Excluir
                                </button>
                            </form>
                        </td>
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
