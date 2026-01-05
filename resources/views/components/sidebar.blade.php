<aside id="sidebar" class="sidebar">
    <div class="sidebar-container">

        <div class="sidebar-header">
            <span class="sidebar-title">Dízimo</span>
        </div>

        {{-- @auth
            <div class="sidebar-user">
                {{ Auth::user()->name }}
            </div>
        @endauth --}}

        <nav class="sidebar-nav">

            {{-- ================= DASHBOARDS ================= --}}

            @can('view-dashboard-admin')
                <a @class(['sidebar-link', 'active' => $menu === 'dashboard']) href="{{ route('dashboard.index') }}">
                    <span class="sidebar-icon">@include('components.icons.painel_icon')</span>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            @endcan

            @can('view-dashboard-dizimo')
                <a @class(['sidebar-link', 'active' => $menu === 'dashboard-dizimo']) href="{{ route('dashboard.dizimo') }}">
                    <span class="sidebar-icon">@include('components.icons.chartpie')</span>
                    <span class="sidebar-text">Dízimo</span>
                </a>
            @endcan

            <a @class(['sidebar-link', 'active' => $menu === 'dashboard-member']) href="{{ route('dashboard.member') }}">
                <span class="sidebar-icon">@include('components.icons.dolar')</span>
                <span class="sidebar-text">Meu Dízimo</span>
            </a>

            {{-- ================= USUÁRIOS / MEMBROS ================= --}}

            @can('view-members')
                <a @class(['sidebar-link', 'active' => $menu === 'members']) href="{{ route('members.index') }}">
                    <span class="sidebar-icon">@include('components.icons.usercircle')</span>
                    <span class="sidebar-text">Membros</span>
                </a>
            @endcan

            @can('index-user')
                <a @class(['sidebar-link', 'active' => $menu === 'users']) href="{{ route('users.index') }}">
                    <span class="sidebar-icon">@include('components.icons.usersgroup')</span>
                    <span class="sidebar-text">Usuários</span>
                </a>
            @endcan

            {{-- ================= FINANCEIRO ================= --}}

            @can('index-donation')
                <a @class(['sidebar-link', 'active' => $menu === 'donations']) href="{{ route('donations.index') }}">
                    <span class="sidebar-icon">@include('components.icons.plus')</span>
                    <span class="sidebar-text">Receitas</span>
                </a>
            @endcan

            @can('index-expense')
                <a @class(['sidebar-link', 'active' => $menu === 'expenses']) href="{{ route('expenses.index') }}">
                    <span class="sidebar-icon">@include('components.icons.minus')</span>
                    <span class="sidebar-text">Despesas</span>
                </a>
            @endcan

            @can('index-donation')
                <a @class(['sidebar-link', 'active' => $menu === 'confirm']) href="{{ route('donations.pending') }}">
                    <span class="sidebar-icon">@include('components.icons.question')</span>
                    <span class="sidebar-text">Confirmações</span>
                </a>
            @endcan

            {{-- ================= CONFIGURAÇÕES ================= --}}

            @can('view-dashboard-admin')
                <a @class(['sidebar-link', 'active' => $menu === 'categories']) href="{{ route('categories.index') }}">
                    <span class="sidebar-icon">@include('components.icons.docdolar')</span>
                    <span class="sidebar-text">Categorias</span>
                </a>
            @endcan


            @can('index-role')
                <a @class(['sidebar-link', 'active' => $menu === 'roles']) href="{{ route('roles.index') }}">
                    <span class="sidebar-icon">@include('components.icons.config')</span>
                    <span class="sidebar-text">Papéis</span>
                </a>
            @endcan

            {{-- ================= PERFIL ================= --}}

            <a @class(['sidebar-link', 'active' => $menu === 'profile']) href="{{ route('profile.show') }}">
                <span class="sidebar-icon">@include('components.icons.user')</span>
                <span class="sidebar-text">Perfil</span>
            </a>

        </nav>
    </div>
</aside>
