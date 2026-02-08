@extends('layouts.admin')

@section('title', 'Equipe da Igreja')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Equipe da Igreja</h1>
            <p class="text-gray-500">Gerencie as pessoas ligadas à igreja</p>
        </div>

        <a href="{{ route('admin.site.people.create') }}" class="btn-primary">
            + Nova Pessoa
        </a>
    </div>

    <x-alert />


    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Ordem</th>
                    <th class="px-6 py-3 text-left">Nome</th>
                    <th class="px-6 py-3 text-left">Função</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($people as $person)
                    <tr>
                        <td class="px-6 py-4">{{ $person->order }}</td>
                        <td class="px-6 py-4 font-medium">{{ $person->name }}</td>
                        <td class="px-6 py-4">{{ $person->role }}</td>
                        <td class="px-6 py-4 text-center">
                            @if ($person->is_active)
                                <x-badge type="active">Ativo</x-badge>
                            @else
                                <x-badge type="inactive">Inativo</x-badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.site.people.edit', $person) }}" class="btn-primary">
                                Editar
                            </a>

                            <form action="{{ route('admin.site.people.destroy', $person) }}" method="POST" class="inline"
                                onsubmit="return confirm('Remover esta pessoa?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-danger">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            Nenhuma pessoa cadastrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
