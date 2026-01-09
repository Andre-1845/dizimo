@extends('layouts.admin')

@section('title', 'Configurações do Site')

@section('content')
    <div class="max-w-4xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Configurações do Site</h1>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.site.settings.update') }}">
            @csrf
            @method('PUT')

            {{-- Nome da igreja --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nome da Igreja</label>
                <input type="text" name="church_name" value="{{ $settings['church_name'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>

            {{-- Endereço --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Endereço</label>
                <input type="text" name="address" value="{{ $settings['address'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>

            {{-- Telefone --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Telefone</label>
                <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}"
                    class="w-full rounded border px-3 py-2" id="phone">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">E-mail</label>
                <input type="email" name="email" value="{{ $settings['email'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>

            {{-- Redes sociais --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Instagram</label>
                <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Facebook</label>
                <input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">YouTube</label>
                <input type="url" name="youtube" value="{{ $settings['youtube'] ?? '' }}"
                    class="w-full rounded border px-3 py-2">
            </div>


            <div class="mt-6">
                <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Salvar configurações
                </button>
            </div>
        </form>
    </div>
@endsection
