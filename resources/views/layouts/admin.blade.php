<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-dashboard">

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
                    <!-- Dropdown -->
                    <button id="userDropdownButton" class="dropdown-button">
                        Usuário
                        <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Conteúdo do Dropdown -->
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="sidebar-header">
                    <span class="sidebar-title">Celke</span>
                </div>
                <div>

                    @if (Auth::check())
                        <div class="text-cyan-300 font-semibold">
                            Logado como: {{ Auth::user()->name }}<br><br>
                        </div>
                    @endif
                </div>

                <!-- Links da SIDEBAR -->

                <nav class="sidebar-nav">

                    <a @class([
                        'sidebar-link',
                        'active' => isset($menu) && $menu == 'dashboard',
                    ]) href="{{ route('dashboard.index') }}">Dashboard</a>

                    @can('index-user')
                        <a @class(['sidebar-link', 'active' => isset($menu) && $menu == 'users']) href={{ route('users.index') }} class="sidebar-link">Usuários</a>
                    @endcan

                    @can('index-status')
                        <a @class([
                            'sidebar-link',
                            'active' => isset($menu) && $menu == 'statuses',
                        ]) href="{{ route('statuses.index') }}">Status</a>
                    @endcan

                    @can('index-roles')
                        <a @class(['sidebar-link', 'active' => isset($menu) && $menu == 'roles']) href="{{ route('roles.index') }}">Papeis</a>
                    @endcan

                    @can('index-course')
                        <a @class([
                            'sidebar-link',
                            'active' => isset($menu) && $menu == 'courses',
                        ]) href="{{ route('courses.index') }}">Cursos</a>
                    @endcan

                    <a @class([
                        'sidebar-link',
                        'active' => isset($menu) && $menu == 'modules',
                    ]) href="{{ route('modules.index') }}">Módulos</a>

                    <a href={{ route('logout') }} class="sidebar-link">Sair</a>
                </nav>

                <!-- Links da SIDEBAR -->

            </div>
        </aside>

        <!-- Conteudo Principal -->
        <main class="main-content">
            @yield('content')
        </main>
        <!-- FIM - Conteudo Principal -->

    </div>



</body>

</html>
