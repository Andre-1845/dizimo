@extends('layouts.app')

@section('body')
    <div class="flex flex-col min-h-screen">

        <!-- Navbar -->
        <nav class="navbar">
            <div class="navbar-container">

                <!-- ESQUERDA -->
                <div class="flex items-center gap-3">
                    <button id="toggleSidebar" class="menu-button lg:hidden">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- DIREITA -->
                <div class="flex items-center gap-3">

                    {{-- ================= CHURCH ================= --}}
                    @hasanyrole('admin|superadmin')
                        <div class="relative">

                            <!-- BOTÃO -->
                            <button id="churchDropdownButton" class="dropdown-button flex items-center gap-2">

                                <!-- Desktop -->
                                <span class="hidden lg:inline">
                                    {{ $churchesList->firstWhere('id', $activeChurchId)?->name }}
                                </span>

                                <!-- Mobile -->
                                <span class="lg:hidden">
                                    @include('components.icons.church')
                                </span>

                                <svg class="dropdown-icon hidden lg:inline" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- DROPDOWN -->
                            <div id="churchDropdown" class="dropdown-content hidden right-0 mt-2">

                                @foreach ($churchesList as $church)
                                    <form method="POST" action="{{ route('church.switch', $church->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-left w-full
                                    {{ $activeChurchId == $church->id ? 'font-semibold bg-gray-100' : '' }}">
                                            {{ $church->name }}
                                        </button>
                                    </form>
                                @endforeach

                            </div>
                        </div>
                    @endhasanyrole


                    {{-- ================= USER ================= --}}
                    <div class="relative">

                        <!-- BOTÃO -->
                        <button id="userDropdownButton" class="dropdown-button flex items-center gap-2">

                            <!-- Desktop -->
                            <span class="hidden lg:inline">
                                {{ Auth::user()->name }}
                            </span>

                            <!-- Mobile -->
                            <span class="lg:hidden">
                                @include('components.icons.user')
                            </span>

                            <svg class="dropdown-icon hidden lg:inline" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- DROPDOWN -->
                        <div id="userDropdown" class="dropdown-content hidden right-0 mt-2">

                            <a href="{{ route('profile.show') }}" class="dropdown-item text-center">
                                Perfil
                            </a>

                            <a href="{{ route('site.home') }}" class="dropdown-item text-center">
                                Home Page
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-center">
                                    <strong>Sair</strong>
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
