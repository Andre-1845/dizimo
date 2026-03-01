@extends('layouts.app')

@section('body')
    <div class="flex flex-col min-h-screen">

        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-container">

                <!-- ESQUERDA -->
                <div class="flex items-center gap-3">
                    <!-- HAMBURGER -->
                    <button id="toggleSidebar" class="menu-button lg:hidden">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- DIREITA -->
                <div class="flex items-center gap-4">

                    {{-- ================= CHURCH ================= --}}
                    @hasanyrole('admin|superadmin')
                        <!-- DESKTOP -->
                        <div class="hidden lg:block">
                            <form method="POST" action="{{ route('church.switch', 0) }}" id="churchSwitchForm">
                                @csrf
                                <select onchange="switchChurch(this.value)"
                                    class="bg-gray-800 text-white border border-gray-700
                                   rounded px-3 py-1 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @foreach ($churchesList as $church)
                                        <option value="{{ $church->id }}"
                                            {{ $activeChurchId == $church->id ? 'selected' : '' }}>
                                            {{ $church->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- MOBILE ICON -->
                        <div class="relative lg:hidden">
                            <button id="churchDropdownButton" class="dropdown-button">
                                @include('components.icons.church')
                            </button>

                            <div id="churchDropdown" class="dropdown-content hidden right-0 mt-2">

                                @foreach ($churchesList as $church)
                                    <button type="button"
                                        class="dropdown-item church-option text-left w-full
                                       {{ $activeChurchId == $church->id ? 'font-semibold bg-gray-100' : '' }}"
                                        data-church-id="{{ $church->id }}">
                                        {{ $church->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endhasanyrole

                    {{-- ================= USER ================= --}}

                    <div class="relative">

                        <!-- DESKTOP -->
                        <button id="userDropdownButton" class="dropdown-button hidden lg:flex items-center">
                            {{ Auth::user()->name }}
                            <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- MOBILE ICON -->
                        <button id="userDropdownButtonMobile" class="dropdown-button lg:hidden">
                            @include('components.icons.user')
                        </button>

                        <!-- DROPDOWN -->
                        <div id="dropdownContent" class="dropdown-content hidden right-0 mt-2">
                            <a href="{{ route('profile.show') }}" class="dropdown-item text-center">
                                Perfil
                            </a>

                            <a href="{{ route('site.home') }}" class="dropdown-item text-center">
                                Home Page
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <!-- Área abaixo da navbar -->
        <div class="flex flex-1">

            <x-sidebar :menu="$menu ?? null" />

            <main class="main-content flex-1 w-full">
                @yield('content')
            </main>

        </div>

    </div>
@endsection
