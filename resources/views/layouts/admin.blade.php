@extends('layouts.app')

@section('body')
    <div class="flex flex-col min-h-screen">

        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-container">
                <!-- Lado esquerdo - Menu -->
                <div class="flex items-center">
                    <button id="toggleSidebar"
                        class="menu-button lg:hidden cursor-pointer p-2 rounded hover:bg-blue-800 transition-colors duration-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Centro - Seletor de igreja (desktop) -->
                <div class="hidden lg:flex items-center gap-2">
                    <span class="text-xs text-gray-300">Igreja:</span>
                    @hasanyrole('admin|superadmin')
                        <form method="POST" action="" id="churchSwitchForm">
                            @csrf
                            <select name="church_id" onchange="switchChurchDesktop(this)"
                                class="bg-gray-800 text-white border border-gray-700
                               rounded px-3 py-1 text-sm
                               focus:outline-none focus:ring-2 focus:ring-blue-500
                               max-w-[200px] truncate">
                                @foreach ($churchesList as $church)
                                    <option value="{{ $church->id }}" {{ $activeChurchId == $church->id ? 'selected' : '' }}>
                                        {{ $church->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endhasanyrole
                </div>

                <!-- Lado direito - Ícones com espaçamento igual -->
                <div class="flex items-center gap-4">
                    <!-- Seletor igreja mobile -->
                    @hasanyrole('admin|superadmin')
                        <div class="lg:hidden">
                            <button id="mobileChurchButton"
                                class="text-white p-2 rounded hover:bg-blue-800 transition-colors duration-200"
                                onclick="toggleMobileChurchSelector()">
                                @include('components.icons.church')
                            </button>

                            <!-- Dropdown mobile -->
                            <div id="mobileChurchDropdown"
                                class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-50"
                                style="top: 100%; right: 0;">
                                <div class="p-3 border-b border-gray-200">
                                    <h3 class="font-semibold text-gray-700">Selecionar Igreja</h3>
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="" id="mobileChurchSwitchForm">
                                        @csrf
                                        <select name="church_id" onchange="switchChurchMobile(this)"
                                            class="w-full p-2 border border-gray-300 rounded text-sm">
                                            @foreach ($churchesList as $church)
                                                <option value="{{ $church->id }}"
                                                    {{ $activeChurchId == $church->id ? 'selected' : '' }}>
                                                    {{ $church->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endhasanyrole

                    <!-- Menu do usuário -->
                    <div class="user-container">
                        <div class="relative">
                            <button id="userDropdownButton"
                                class="dropdown-button p-2 rounded hover:bg-blue-800 transition-colors duration-200">
                                <span class="hidden sm:inline">{{ Auth::user()->name ?? 'Usuário' }}</span>
                                <span class="sm:hidden">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linecap="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                                <svg class="dropdown-icon hidden sm:inline-block" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="dropdownContent" class="dropdown-content hidden">
                                <a href="{{ route('profile.show') }}" class="dropdown-item">Perfil</a>
                                <a href="{{ route('site.home') }}" class="dropdown-item">Home Page</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-red-600 hover:bg-red-50 font-semibold">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Overlay para fechar dropdowns no mobile -->
        <div id="dropdownOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40" onclick="closeAllDropdowns()">
        </div>

        <!-- Área abaixo da navbar -->
        <div class="flex flex-1">
            <x-sidebar :menu="$menu ?? null" />
            <main class="main-content flex-1 w-full">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Função para trocar de igreja no desktop
        function switchChurchDesktop(select) {
            const churchId = select.value;
            const form = document.getElementById('churchSwitchForm');

            // CORRIGIDO: Usa URL direta em vez de route helper
            form.action = '/switch-church/' + churchId;
            form.submit();
        }

        // Função para trocar de igreja no mobile
        function switchChurchMobile(select) {
            const churchId = select.value;
            const form = document.getElementById('mobileChurchSwitchForm');

            // CORRIGIDO: Usa URL direta em vez de route helper
            form.action = '/switch-church/' + churchId;
            form.submit();
        }

        // Funções para controle dos dropdowns
        function toggleMobileChurchSelector() {
            const dropdown = document.getElementById('mobileChurchDropdown');
            const button = document.getElementById('mobileChurchButton');
            const overlay = document.getElementById('dropdownOverlay');
            const userDropdown = document.getElementById('dropdownContent');
            const userButton = document.getElementById('userDropdownButton');

            // Fecha o dropdown do usuário se estiver aberto
            if (userDropdown && !userDropdown.classList.contains('hidden')) {
                userDropdown.classList.add('hidden');
                if (userButton) userButton.classList.remove('bg-blue-800');
            }

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                if (button) button.classList.add('bg-blue-800');
                if (overlay) overlay.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
                if (button) button.classList.remove('bg-blue-800');
                if (overlay) overlay.classList.add('hidden');
            }
        }

        function toggleUserDropdown() {
            const dropdown = document.getElementById('dropdownContent');
            const button = document.getElementById('userDropdownButton');
            const overlay = document.getElementById('dropdownOverlay');
            const churchDropdown = document.getElementById('mobileChurchDropdown');
            const churchButton = document.getElementById('mobileChurchButton');

            // Fecha o dropdown da igreja se estiver aberto
            if (churchDropdown && !churchDropdown.classList.contains('hidden')) {
                churchDropdown.classList.add('hidden');
                if (churchButton) churchButton.classList.remove('bg-blue-800');
            }

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                if (button) button.classList.add('bg-blue-800');
                if (overlay) overlay.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
                if (button) button.classList.remove('bg-blue-800');
                if (overlay) overlay.classList.add('hidden');
            }
        }

        function closeAllDropdowns() {
            const churchDropdown = document.getElementById('mobileChurchDropdown');
            const userDropdown = document.getElementById('dropdownContent');
            const churchButton = document.getElementById('mobileChurchButton');
            const userButton = document.getElementById('userDropdownButton');
            const overlay = document.getElementById('dropdownOverlay');

            if (churchDropdown) churchDropdown.classList.add('hidden');
            if (userDropdown) userDropdown.classList.add('hidden');
            if (churchButton) churchButton.classList.remove('bg-blue-800');
            if (userButton) userButton.classList.remove('bg-blue-800');
            if (overlay) overlay.classList.add('hidden');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Botão do usuário
            const userButton = document.getElementById('userDropdownButton');
            if (userButton) {
                userButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    toggleUserDropdown();
                });
            }

            // Fecha ao clicar fora
            document.addEventListener('click', function(event) {
                const userButton = document.getElementById('userDropdownButton');
                const userDropdown = document.getElementById('dropdownContent');
                const churchButton = document.getElementById('mobileChurchButton');
                const churchDropdown = document.getElementById('mobileChurchDropdown');

                // Se clicou fora de tudo, fecha
                if (!userButton?.contains(event.target) &&
                    !userDropdown?.contains(event.target) &&
                    !churchButton?.contains(event.target) &&
                    !churchDropdown?.contains(event.target)) {
                    closeAllDropdowns();
                }
            });

            // Previne fechar ao clicar dentro dos dropdowns
            const churchDropdown = document.getElementById('mobileChurchDropdown');
            if (churchDropdown) {
                churchDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            const userDropdown = document.getElementById('dropdownContent');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
@endsection
