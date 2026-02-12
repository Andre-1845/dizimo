@extends('layouts.admin')

@section('title', 'Configurações do Site')

@section('content')
    <div class="max-w-5xl mx-auto">

        <h1 class="content-title my-6">Configurações do Site</h1>

        <div class="flex justify-between items-center mb-6">
            <div></div>
            <a href="{{ route('admin.site.index') }}" class="btn-info">
                Voltar
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.site.settings.update') }}" enctype="multipart/form-data" class="space-y-8">

            @csrf
            @method('PUT')

            {{-- ================= DADOS INSTITUCIONAIS ================= --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-lg font-semibold mb-4">Dados Institucionais</h2>

                <div class="mb-4">
                    <label class="block form-label">Nome da Igreja</label>
                    <input type="text" name="church_name" value="{{ $settings['church_name'] ?? '' }}"
                        class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label class="block form-label">Endereço</label>
                    <input type="text" name="address" value="{{ $settings['address'] ?? '' }}" class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label class="block form-label">Telefone</label>
                    <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}" class="w-full form-input"
                        id="phone">
                </div>

                <div>
                    <label class="block form-label">E-mail</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="w-full form-input">
                </div>
            </div>

            {{-- ================= BRANDING ================= --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-lg font-semibold mb-4">Branding</h2>

                <div class="mb-4">
                    <label class="block form-label">Nome do Aplicativo</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}"
                        class="w-full form-input">
                    <p class="text-sm text-gray-500 mt-2">
                        Este nome aparecerá como título dos emails enviados pelo sistema.
                        Exemplo: Igreja N Sra das Dores.
                    </p>
                </div>

                <div>
                    <label class="block form-label">Logo do Sistema</label>

                    @if (!empty($settings['site_logo']))
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-16 mb-2">

                            <label class="inline-flex items-center text-sm">
                                <input type="checkbox" name="remove_logo" value="1" class="mr-2">
                                Remover logo atual
                            </label>
                        </div>
                    @endif

                    <input type="file" name="site_logo" accept="image/*" class="w-full file-input">
                </div>
            </div>

            {{-- ================= REDES SOCIAIS ================= --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-lg font-semibold mb-4">Redes Sociais</h2>

                <div class="mb-4">
                    <label class="block form-label">Instagram</label>
                    <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}"
                        class="w-full form-input">
                </div>

                <div class="mb-4">
                    <label class="block form-label">Facebook</label>
                    <input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}"
                        class="w-full form-input">
                </div>

                <div>
                    <label class="block form-label">YouTube</label>
                    <input type="url" name="youtube" value="{{ $settings['youtube'] ?? '' }}"
                        class="w-full form-input">
                </div>
            </div>

            {{-- ================= CONFIGURAÇÕES DE EMAIL ================= --}}
            <div class="bg-white shadow rounded p-6">
                <h2 class="text-lg font-semibold mb-4">Configurações de Email</h2>

                {{-- Nome do remetente --}}
                <div class="mb-6">
                    <label class="block form-label">Nome exibido no envio de Email (Nome do remetente)</label>
                    <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}"
                        class="w-full form-input">

                    <p class="text-sm text-gray-500 mt-2">
                        Este nome aparecerá como remetente dos emails enviados pelo sistema.
                        Exemplo: Secretaria da Igreja xxxxx.
                    </p>
                </div>

                {{-- Modo padrão --}}
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="use_default_email_templates" value="1"
                            {{ ($settings['use_default_email_templates'] ?? 1) == 1 ? 'checked' : '' }} class="mr-2">
                        Usar modelo padrão do sistema (recomendado)
                    </label>

                    <p class="text-sm text-gray-500 mt-2">
                        Se ativado, o sistema utilizará os emails padrão do Laravel.
                        Caso desmarcado, os textos abaixo serão utilizados.
                    </p>
                </div>

                {{-- Email de Confirmação --}}
                <div class="mb-6">
                    <h3 class="font-medium mb-3">Email de Confirmação de Cadastro</h3>

                    <div class="mb-4">
                        <label class="block form-label">Assunto</label>
                        <input type="text" name="email_verification_subject"
                            value="{{ $settings['email_verification_subject'] ?? '' }}" class="w-full form-input">
                    </div>

                    <div>
                        <label class="block form-label">Texto</label>
                        <textarea name="email_verification_body" rows="4" class="w-full form-input">{{ $settings['email_verification_body'] ?? '' }}</textarea>
                    </div>
                </div>

                {{-- Email de Reset --}}
                <div>
                    <h3 class="font-medium mb-3">Email de Redefinição de Senha</h3>

                    <div class="mb-4">
                        <label class="block form-label">Assunto</label>
                        <input type="text" name="password_reset_subject"
                            value="{{ $settings['password_reset_subject'] ?? '' }}" class="w-full form-input">
                    </div>

                    <div>
                        <label class="block form-label">Texto</label>
                        <textarea name="password_reset_body" rows="4" class="w-full form-input">{{ $settings['password_reset_body'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>


            {{-- BOTÃO --}}
            <div class="text-right">
                <button class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Salvar configurações
                </button>
            </div>

        </form>
    </div>
@endsection
