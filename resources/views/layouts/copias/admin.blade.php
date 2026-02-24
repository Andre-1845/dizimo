@extends('layouts.app')

@section('body')
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <button id="toggleSidebar" class="menu-button lg:hidden">
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

                    {{-- *** NAVBAR DO USUARIO *** --}}

                    <div id="dropdownContent" class="dropdown-content hidden">
                        {{-- **** PERFIL **** --}}
                        <a href="{{ route('profile.show') }}" class="dropdown-item text-center">Perfil</a>

                        {{-- **** HOME PAGE **** --}}
                        <a href="{{ route('site.home') }}" class="dropdown-item text-center">Home Page</a>

                        {{-- **** SAIR **** --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <x-sidebar :menu="$menu ?? null" />

        {{-- Conteúdo --}}
        <main class="main-content flex-1 w-full">
            @yield('content')
        </main>

    </div>
@endsection
