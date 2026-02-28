<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">

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
    <header class="bg-white shadow relative">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('site.home') }}" class="text-xl font-bold text-gray-900">
                {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
            </a>

            {{-- Botão Mobile (só aparece em mobile) --}}
            <button id="siteMenuToggle" class="md:hidden text-2xl text-gray-800 focus:outline-none">
                ☰
            </button>

            {{-- MENU DESKTOP (agora só com links do site, sem login/dashboard) --}}
            <nav class="hidden md:flex gap-6 items-center">
                <a href="#about" class="site-link">Sobre</a>
                <a href="#agenda" class="site-link">Agenda</a>
                <a href="#horarios" class="site-link">Horários e Informações</a>
                <a href="https://www.instagram.com/grupocarloacutis_resende/" target="_blank" rel="noopener noreferrer"
                    class="site-link">
                    Grupo Jovem
                </a>
                <a href="#avisos" class="site-link">Avisos</a>
                <a href="#contact" class="site-link">Contato</a>
            </nav>

            {{-- Área do usuário (separada, só em desktop) --}}
            <div class="hidden md:flex items-center gap-4">
                @guest
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Faça seu cadastro
                    </a>
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium">
                        Login
                    </a>
                @endguest

                @auth
                    @if (auth()->user()->member)
                        <a href="{{ route('dashboard.member') }}"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                            Meu Painel
                        </a>
                    @else
                        <a href="{{ route('dashboard.admin') }}"
                            class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900 transition">
                            Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-blue-600 font-medium">
                            Sair
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        {{-- MENU MOBILE (agora vazio, será preenchido pelo JS) --}}
        <div id="siteMobileMenu"></div>
    </header>

    {{-- ================= CONTEÚDO ================= --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="bg-gray-900 text-gray-200">
        <div class="max-w-7xl mx-auto px-6 pt-6 pb-6 grid md:grid-cols-3 gap-8 text-center md:text-center">

            {{-- Igreja --}}
            <div class="flex flex-col items-center">
                <h3 class="font-semibold mb-2">
                    {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
                </h3>
                <p class="text-sm">
                    {{ \App\Models\SiteSetting::get('address') }}
                </p>
                <p class="text-sm mt-1">
                    {{ format_phone(\App\Models\SiteSetting::get('phone')) }}
                </p>
            </div>

            {{-- Contato --}}
            <div class="flex flex-col items-center">
                <h3 class="font-semibold mb-2">Contato</h3>
                <p class="text-sm">
                    {{ \App\Models\SiteSetting::get('email') }}
                </p>
            </div>

            {{-- Redes sociais --}}
            <div class="flex flex-col items-center">
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

        <div class="text-center text-small text-gray-400 py-2">
            Desenvolvido por : André Andrino
        </div>

        <div class="text-center text-xs text-gray-400 py-4 border-t border-gray-800">
            © {{ date('Y') }} {{ \App\Models\SiteSetting::get('church_name', 'Igreja') }}
        </div>
    </footer>

    {{-- Vite JS --}}
    @vite('resources/js/app.js')

    {{-- SCRIPT ESPECÍFICO DO MENU MOBILE --}}
    {{-- SCRIPT DO MENU MOBILE - VERSÃO FINAL --}}
    <script>
        (function() {
            'use strict';

            console.log('🚀 Iniciando configuração do menu mobile...');

            // Função principal
            function initSiteMenu() {
                const menuToggle = document.getElementById('siteMenuToggle');
                const mobileMenu = document.getElementById('siteMobileMenu');

                if (!menuToggle || !mobileMenu) {
                    console.log('❌ Elementos não encontrados, tentando novamente...');
                    setTimeout(initSiteMenu, 100);
                    return;
                }

                console.log('✅ Elementos encontrados! Criando menu...');

                // ==========================================
                // 1. CRIAR ESTRUTURA DO MENU
                // ==========================================

                // Lista de links do menu
                const menuLinks = [{
                        href: '#about',
                        text: 'Sobre'
                    },
                    {
                        href: '#agenda',
                        text: 'Agenda'
                    },
                    {
                        href: '#horarios',
                        text: 'Horários e Informações'
                    },
                    {
                        href: 'https://www.instagram.com/grupocarloacutis_resende/',
                        text: 'Grupo Jovem',
                        target: '_blank'
                    },
                    {
                        href: '#avisos',
                        text: 'Avisos'
                    },
                    {
                        href: '#contact',
                        text: 'Contato'
                    }
                ];

                // Construir HTML do menu
                let menuHTML = '<div class="site-sidebar-content">';

                // Links principais
                menuLinks.forEach(link => {
                    const target = link.target ? `target="${link.target}"` : '';
                    menuHTML += `<a href="${link.href}" ${target} class="site-sidebar-link">${link.text}</a>`;
                });

                // Separador
                menuHTML += '<div class="site-sidebar-divider"></div>';

                // Área do usuário (copiada do PHP)
                menuHTML += `
                @guest
                    <a href="{{ route('register') }}" class="site-sidebar-button site-sidebar-button-primary">Faça seu cadastro</a>
                    <a href="{{ route('login') }}" class="site-sidebar-button site-sidebar-button-login">Login</a>
                @endguest

                @auth
                    @if (auth()->user()->member)
                        <a href="{{ route('dashboard.member') }}" class="site-sidebar-button site-sidebar-button-primary">Meu Painel</a>
                    @else
                        <a href="{{ route('dashboard.admin') }}" class="site-sidebar-button site-sidebar-button-secondary">Dashboard</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="site-sidebar-button site-sidebar-button-login" style="width: 100%;">Sair</button>
                    </form>
                @endauth
            `;

                menuHTML += '</div>';

                // Inserir no menu mobile
                mobileMenu.innerHTML = menuHTML;

                // ==========================================
                // 2. ADICIONAR CSS NECESSÁRIO
                // ==========================================

                // Verificar se o CSS já existe
                if (!document.getElementById('siteMenuCSS')) {
                    const style = document.createElement('style');
                    style.id = 'siteMenuCSS';
                    style.textContent = `
                    /* Menu Mobile - Estilos */
                    #siteMobileMenu {
                        position: fixed !important;
                        top: 0 !important;
                        left: 0 !important;
                        width: 280px !important;
                        height: 100vh !important;
                        background: white !important;
                        z-index: 1001 !important;
                        transform: translateX(-100%);
                        transition: transform 0.3s ease !important;
                        box-shadow: 2px 0 10px rgba(0,0,0,0.1) !important;
                        overflow-y: auto !important;
                        padding: 2rem 1.5rem !important;
                        display: block !important;
                    }

                    #siteMobileMenu.site-sidebar-expanded {
                        transform: translateX(0) !important;
                    }

                    .site-sidebar-content {
                        display: flex !important;
                        flex-direction: column !important;
                        gap: 1rem !important;
                    }

                    .site-sidebar-link {
                        color: #374151 !important;
                        font-weight: 500 !important;
                        font-size: 1.125rem !important;
                        text-decoration: none !important;
                        padding: 0.5rem 0 !important;
                        display: block !important;
                        transition: color 0.2s !important;
                    }

                    .site-sidebar-link:hover {
                        color: #2563eb !important;
                    }

                    .site-sidebar-button {
                        display: block !important;
                        width: 100% !important;
                        padding: 0.75rem 1rem !important;
                        border-radius: 0.375rem !important;
                        text-align: center !important;
                        text-decoration: none !important;
                        font-weight: 500 !important;
                        border: none !important;
                        cursor: pointer !important;
                        transition: all 0.2s !important;
                    }

                    .site-sidebar-button-primary {
                        background: #2563eb !important;
                        color: white !important;
                    }

                    .site-sidebar-button-primary:hover {
                        background: #1d4ed8 !important;
                    }

                    .site-sidebar-button-secondary {
                        background: #1f2937 !important;
                        color: white !important;
                    }

                    .site-sidebar-button-secondary:hover {
                        background: #111827 !important;
                    }

                    .site-sidebar-button-login {
                        background: transparent !important;
                        color: #2563eb !important;
                        border: 1px solid #2563eb !important;
                    }

                    .site-sidebar-button-login:hover {
                        background: #2563eb !important;
                        color: white !important;
                    }

                    .site-sidebar-divider {
                        height: 1px !important;
                        background: #e5e7eb !important;
                        margin: 1rem 0 !important;
                    }

                    /* Overlay */
                    #siteMenuOverlay {
                        position: fixed !important;
                        top: 0 !important;
                        left: 0 !important;
                        right: 0 !important;
                        bottom: 0 !important;
                        background: rgba(0,0,0,0.5) !important;
                        z-index: 1000 !important;
                        display: none;
                        opacity: 0;
                        transition: opacity 0.3s ease !important;
                    }

                    #siteMenuOverlay.active {
                        display: block !important;
                        opacity: 1 !important;
                    }

                    /* Botão do menu */
                    #siteMenuToggle {
                        display: inline-block !important;
                        background: transparent !important;
                        border: none !important;
                        font-size: 1.5rem !important;
                        cursor: pointer !important;
                        padding: 0.5rem !important;
                        color: #1f2937 !important;
                        z-index: 1002 !important;
                        position: relative !important;
                    }

                    #siteMenuToggle.active {
                        transform: rotate(90deg);
                    }

                    /* Desktop: esconder tudo */
                    @media (min-width: 768px) {
                        #siteMobileMenu,
                        #siteMenuOverlay {
                            display: none !important;
                        }

                        #siteMenuToggle {
                            display: none !important;
                        }
                    }
                `;
                    document.head.appendChild(style);
                }

                // ==========================================
                // 3. CRIAR OVERLAY
                // ==========================================

                let overlay = document.getElementById('siteMenuOverlay');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.id = 'siteMenuOverlay';
                    document.body.appendChild(overlay);
                }

                // ==========================================
                // 4. CONFIGURAR EVENTOS
                // ==========================================

                let isOpen = false;

                function toggleMenu(open) {
                    isOpen = open !== undefined ? open : !isOpen;

                    if (isOpen) {
                        mobileMenu.classList.add('site-sidebar-expanded');
                        overlay.classList.add('active');
                        menuToggle.classList.add('active');
                        menuToggle.innerHTML = '✕';
                        console.log('📱 Menu aberto');
                    } else {
                        mobileMenu.classList.remove('site-sidebar-expanded');
                        overlay.classList.remove('active');
                        menuToggle.classList.remove('active');
                        menuToggle.innerHTML = '☰';
                        console.log('📱 Menu fechado');
                    }
                }

                // Remover eventos anteriores (clonar botão)
                const newToggle = menuToggle.cloneNode(true);
                menuToggle.parentNode.replaceChild(newToggle, menuToggle);

                // Evento de clique
                newToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('🎯 Clique no menu');
                    toggleMenu();
                });

                // Fechar ao clicar no overlay
                overlay.addEventListener('click', function() {
                    if (isOpen) toggleMenu(false);
                });

                // Fechar ao clicar em links
                mobileMenu.querySelectorAll('a, button').forEach(el => {
                    el.addEventListener('click', function() {
                        if (isOpen) toggleMenu(false);
                    });
                });

                // Fechar ao redimensionar para desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768 && isOpen) {
                        toggleMenu(false);
                    }
                });

                // Garantir que comece fechado
                mobileMenu.classList.remove('site-sidebar-expanded');
                overlay.classList.remove('active');
                newToggle.innerHTML = '☰';

                console.log('✅ Menu mobile configurado com sucesso!');
            }

            // Iniciar quando possível
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initSiteMenu);
            } else {
                initSiteMenu();
            }
            window.addEventListener('load', initSiteMenu);
        })();
    </script>
</body>

</html>
