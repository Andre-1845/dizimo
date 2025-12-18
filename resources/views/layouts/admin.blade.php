@extends('layouts.app')

@section('body')
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <button id="toggleSidebar" class="menu-button">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="user-container">
                <div class="relative">
                    <button id="userDropdownButton" class="dropdown-button">
                        {{ Auth::user()->name ?? 'Usuário' }}
                        <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="dropdownContent" class="dropdown-content hidden">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">Perfil</a>
                        <a href="{{ route('logout') }}" class="dropdown-item">Sair</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div class="sidebar-container">

                <button id="closeSidebar" class="sidebar-close-button">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="sidebar-header">
                    <span class="sidebar-title">Dízimo</span>
                </div>

                @auth
                    <div class="text-cyan-300 font-semibold mb-4">
                        {{ Auth::user()->name }}
                    </div>
                @endauth

                <nav class="sidebar-nav">
                    @can('view-dashboard-admin')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'dashboard']) href="{{ route('dashboard.index') }}">
                            Dashboard
                        </a>
                    @endcan

                    @can('view-dashboard-dizimo')
                        <a @class([
                            'sidebar-link',
                            'active' => ($menu ?? '') === 'dashboard-dizimo',
                        ]) href="{{ route('dashboard.dizimo_index') }}">
                            Dizimo Painel
                        </a>
                    @endcan

                    <a href="{{ route('members.dashboard') }}" class="sidebar-link">
                        Meu Dizimo
                    </a>

                    @can('view-members')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'members']) href="{{ route('members.index') }}">
                            Membros
                        </a>
                    @endcan

                    @can('index-donations')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'donations']) href="{{ route('donations.index') }}">
                            Doações
                        </a>
                    @endcan

                    @can('index-expenses')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'expenses']) href="{{ route('expenses.index') }}">
                            Despesas
                        </a>
                    @endcan

                    @can('view-dashboard-admin')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'categories']) href="{{ route('categories.index') }}">
                            Categorias
                        </a>
                    @endcan

                    @can('view-dashboard-admin')
                        <a @class([
                            'sidebar-link',
                            'active' => ($menu ?? '') === 'payment-methods',
                        ]) href="{{ route('payment-methods.index') }}">
                            Formas de Pagamento
                        </a>
                    @endcan

                    @can('index-user')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'users']) href="{{ route('users.index') }}">
                            Usuários
                        </a>
                    @endcan

                    @can('index-role')
                        <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'role']) href="{{ route('roles.index') }}">
                            Papeis
                        </a>
                    @endcan

                    <a @class(['sidebar-link', 'active' => ($menu ?? '') === 'profile']) href="{{ route('profile.show') }}">
                        Perfil
                    </a>







                </nav>

            </div>
        </aside>

        <!-- Conteúdo -->
        <main class="main-content">
            @yield('content')
        </main>

    </div>
@endsection
