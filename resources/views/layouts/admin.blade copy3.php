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

                <!-- Header -->
                <div class="sidebar-header">
                    <span class="sidebar-title">Dízimo</span>
                </div>

                <!-- Usuário -->
                @auth
                    <div class="sidebar-user">
                        {{ Auth::user()->name }}
                    </div>
                @endauth

                <nav class="sidebar-nav">

                    {{-- ===================== --}}
                    {{-- DASHBOARDS --}}
                    {{-- ===================== --}}
                    @canany(['view-dashboard-admin', 'view-dashboard-dizimo', 'view-dashboard-member'])
                        <div class="sidebar-group">
                            <span class="sidebar-group-title">Painéis</span>

                            @can('view-dashboard-admin')
                                <a href="{{ route('dashboard.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'dashboard' ? 'active' : '' }}">
                                    <span class="sidebar-icon">📊</span>
                                    <span class="sidebar-text">Dashboard Admin</span>
                                </a>
                            @endcan

                            @can('view-dashboard-dizimo')
                                <a href="{{ route('dashboard.dizimo') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'dashboard-dizimo' ? 'active' : '' }}">
                                    <span class="sidebar-icon">💰</span>
                                    <span class="sidebar-text">Painel do Dízimo</span>
                                </a>
                            @endcan

                            @can('view-dashboard-member')
                                <a href="{{ route('dashboard.member') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'my-dashboard' ? 'active' : '' }}">
                                    <span class="sidebar-icon">🙋</span>
                                    <span class="sidebar-text">Meu Painel</span>
                                </a>
                            @endcan
                        </div>
                    @endcanany

                    {{-- ===================== --}}
                    {{-- PESSOAS --}}
                    {{-- ===================== --}}
                    @canany(['index-user', 'index-member'])
                        <div class="sidebar-group">
                            <span class="sidebar-group-title">Pessoas</span>

                            @can('index-member')
                                <a href="{{ route('members.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'members' ? 'active' : '' }}">
                                    <span class="sidebar-icon">👥</span>
                                    <span class="sidebar-text">Membros</span>
                                </a>
                            @endcan

                            @can('index-user')
                                <a href="{{ route('users.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'users' ? 'active' : '' }}">
                                    <span class="sidebar-icon">🧑‍💼</span>
                                    <span class="sidebar-text">Usuários</span>
                                </a>
                            @endcan
                        </div>
                    @endcanany

                    {{-- ===================== --}}
                    {{-- FINANCEIRO --}}
                    {{-- ===================== --}}
                    @canany(['index-donation', 'index-expense'])
                        <div class="sidebar-group">
                            <span class="sidebar-group-title">Financeiro</span>

                            @can('index-donation')
                                <a href="{{ route('donations.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'donations' ? 'active' : '' }}">
                                    <span class="sidebar-icon">➕</span>
                                    <span class="sidebar-text">Doações</span>
                                </a>
                            @endcan

                            @can('index-expense')
                                <a href="{{ route('expenses.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'expenses' ? 'active' : '' }}">
                                    <span class="sidebar-icon">➖</span>
                                    <span class="sidebar-text">Despesas</span>
                                </a>
                            @endcan
                        </div>
                    @endcanany

                    {{-- ===================== --}}
                    {{-- CONFIGURAÇÕES --}}
                    {{-- ===================== --}}
                    @canany(['index-category', 'index-role'])
                        <div class="sidebar-group">
                            <span class="sidebar-group-title">Configurações</span>

                            @can('index-category')
                                <a href="{{ route('categories.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'categories' ? 'active' : '' }}">
                                    <span class="sidebar-icon">🏷️</span>
                                    <span class="sidebar-text">Categorias</span>
                                </a>
                            @endcan

                            @can('index-role')
                                <a href="{{ route('roles.index') }}"
                                    class="sidebar-link {{ ($menu ?? '') === 'roles' ? 'active' : '' }}">
                                    <span class="sidebar-icon">🔐</span>
                                    <span class="sidebar-text">Papéis</span>
                                </a>
                            @endcan
                        </div>
                    @endcanany

                    {{-- ===================== --}}
                    {{-- PERFIL --}}
                    {{-- ===================== --}}
                    <div class="sidebar-group">
                        <a href="{{ route('profile.show') }}"
                            class="sidebar-link {{ ($menu ?? '') === 'profile' ? 'active' : '' }}">
                            <span class="sidebar-icon">⚙️</span>
                            <span class="sidebar-text">Meu Perfil</span>
                        </a>
                    </div>

                </nav>
            </div>
        </aside>


        <!-- Conteúdo -->
        <main class="main-content">
            @yield('content')
        </main>

    </div>
@endsection
