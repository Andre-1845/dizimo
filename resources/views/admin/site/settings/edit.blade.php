@extends('layouts.admin')

@section('title', 'Configurações do Site')

@section('content')
    <div class="max-w-4xl mx-auto">

        <h1 class="content-title my-6">Configurações do Site</h1>
        <div class="flex justify-between items-center">
            <div></div>
            <div>
                <a href="{{ route('admin.site.index') }}" class="btn-info">
                    Voltar
                </a>
            </div>

        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.site.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nome da igreja --}}
            <div class="mb-4">
                <label class="block form-label">Nome da Igreja</label>
                <input type="text" name="church_name" value="{{ $settings['church_name'] ?? '' }}"
                    class="w-full form-input">
            </div>

            {{-- Endereço --}}
            <div class="mb-4">
                <label class="block form-label">Endereço</label>
                <input type="text" name="address" value="{{ $settings['address'] ?? '' }}" class="w-full form-input">
            </div>

            {{-- Telefone --}}
            <div class="mb-4">
                <label class="block form-label">Telefone</label>
                <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}" class="w-full form-input"
                    id="phone">
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block form-label">E-mail</label>
                <input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="w-full form-input">
            </div>

            {{-- Nome do Aplicativo --}}
            <div class="mb-4">
                <label class="block form-label">Nome do Aplicativo</label>
                <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}" class="w-full form-input">
            </div>

            {{-- Logo do Sistema --}}
            <div class="mb-4">
                <label class="block form-label">Logo do Sistema</label>

                @if (!empty($settings['site_logo']))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-16">

                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_logo" value="1" class="mr-2">
                                Remover logo atual
                            </label>
                        </div>
                    </div>
                @endif

                <input type="file" name="site_logo" accept="image/*" class="w-full form-input">
            </div>


            {{-- Redes sociais --}}
            <div class="mb-4">
                <label class="block form-label">Instagram</label>
                <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}" class="w-full form-input">
            </div>

            <div class="mb-4">
                <label class="block form-label">Facebook</label>
                <input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}" class="w-full form-input">
            </div>

            <div class="mb-4">
                <label class="block form-label">YouTube</label>
                <input type="url" name="youtube" value="{{ $settings['youtube'] ?? '' }}" class="w-full form-input">
            </div>


            <div class="mt-6">
                <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Salvar configurações
                </button>
            </div>
        </form>
    </div>
@endsection
