@extends('layouts.admin')

@section('title', 'Avisos da Igreja')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Avisos</h1>

            <a href="{{ route('admin.site.notices.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Novo Aviso
            </a>
        </div>

        <x-alert />

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Título</th>
                    <th class="p-3">Validade</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notices as $notice)
                    <tr class="border-t">
                        <td class="p-3">{{ $notice->title }}</td>
                        <td class="p-3">
                            @if ($notice->expires_at)
                                <span class="{{ $notice->expires_at->isPast() ? 'text-red-600 font-medium' : '' }}">
                                    até {{ $notice->expires_at->format('d/m/Y') }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3">
                            @php
                                $expired = $notice->expires_at && $notice->expires_at->isPast();
                            @endphp

                            @if ($expired)
                                <x-badge type="expired">Expirado</x-badge>
                            @elseif ($notice->is_active)
                                <x-badge type="active">Ativo</x-badge>
                            @else
                                <x-badge type="inactive">Inativo</x-badge>
                            @endif
                        </td>
                        <td class="p-3 text-center">
                            <a href="{{ route('admin.site.notices.edit', $notice) }}" class="btn-primary">Editar</a>

                            <form action="{{ route('admin.site.notices.destroy', $notice) }}" method="POST" class="inline"
                                onsubmit="return confirm('Excluir este aviso?')">
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
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            Nenhum aviso cadastrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <p class="text-sm text-gray-500 mb-4">
            Avisos expirados deixam de aparecer automaticamente no site.
        </p>

        <div class="mt-6">
            {{ $notices->links() }}
        </div>
    </div>
@endsection
