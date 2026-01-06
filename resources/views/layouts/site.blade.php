<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>
        @yield('title', \App\Models\SiteSetting::get('church_name', 'Igreja'))
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('description', 'Site oficial da igreja')">

    @vite('resources/css/app.css')
</head>

<body class="font-sans text-gray-800 bg-white flex flex-col min-h-screen">

    {{-- ================= HEADER ================= --}}
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo / Nome --}}
            <a href="{{ route('site.home') }}" class="text-xl font-bold text-gray-900">
                {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
            </a>

            {{-- Menu --}}
            <nav class="hidden md:flex gap-6 text-sm font-medium">
                <a href="{{ route('site.home') }}" class="hover:text-blue-600">
                    Início
                </a>
                <a href="#about" class="hover:text-blue-600">
                    Sobre
                </a>
                <a href="#agenda" class="hover:text-blue-600">
                    Agenda
                </a>
                <a href="#contact" class="hover:text-blue-600">
                    Contato
                </a>

                {{-- Link para o sistema --}}
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Área do Membro
                </a>
            </nav>

        </div>
    </header>

    {{-- ================= CONTEÚDO ================= --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-gray-900 text-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-3 gap-8">

            {{-- Igreja --}}
            <div>
                <h3 class="font-semibold mb-2">
                    {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
                </h3>
                <p class="text-sm">
                    {{ \App\Models\SiteSetting::get('address') }}
                </p>
                <p class="text-sm mt-1">
                    {{ \App\Models\SiteSetting::get('phone') }}
                </p>
            </div>

            {{-- Contato --}}
            <div>
                <h3 class="font-semibold mb-2">Contato</h3>
                <p class="text-sm">
                    {{ \App\Models\SiteSetting::get('email') }}
                </p>
            </div>

            {{-- Redes sociais --}}
            <div>
                <h3 class="font-semibold mb-2">Redes sociais</h3>
                <div class="flex gap-4 text-sm">
                    @if ($instagram = \App\Models\SiteSetting::get('instagram'))
                        <a href="{{ $instagram }}" target="_blank" class="hover:text-white">
                            Instagram
                        </a>
                    @endif

                    @if ($facebook = \App\Models\SiteSetting::get('facebook'))
                        <a href="{{ $facebook }}" target="_blank" class="hover:text-white">
                            Facebook
                        </a>
                    @endif

                    @if ($youtube = \App\Models\SiteSetting::get('youtube'))
                        <a href="{{ $youtube }}" target="_blank" class="hover:text-white">
                            YouTube
                        </a>
                    @endif
                </div>
            </div>

        </div>

        <div class="text-center text-xs text-gray-400 py-4 border-t border-gray-800">
            © {{ date('Y') }} {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
        </div>
    </footer>

</body>

</html>
