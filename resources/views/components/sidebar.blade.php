<aside id="sidebar" class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <span class="sidebar-title">Dízimo</span>
        </div>

        <nav class="sidebar-nav">

            <a @class(['sidebar-link', 'active' => request()->routeIs('site.home')]) href="{{ route('site.home') }}">
                <span class="sidebar-icon">@include('components.icons.home')</span>
                <span class="sidebar-text">Home Page</span>
            </a>
            {{-- ================= DASHBOARDS ================= --}}
            @canany(['dashboard.admin', 'dashboard.treasury', 'dashboard.member'])
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Dashboards</span>

                    @can('dashboard.admin')
                        <a @class([
                            'sidebar-link',
                            'active' => request()->routeIs('dashboard.admin'),
                        ]) href="{{ route('dashboard.admin') }}">
                            <span class="sidebar-icon">@include('components.icons.painel_icon')</span>
                            <span class="sidebar-text">Administração</span>
                        </a>
                    @endcan

                    @can('dashboard.treasury')
                        <a @class([
                            'sidebar-link',
                            'active' => request()->routeIs('dashboard.treasury'),
                        ]) href="{{ route('dashboard.treasury') }}">
                            <span class="sidebar-icon">@include('components.icons.chartpie')</span>
                            <span class="sidebar-text">Painel Dízimos</span>
                        </a>
                    @endcan

                    @can('dashboard.member')
                        <a @class([
                            'sidebar-link',
                            'active' => request()->routeIs('dashboard.member'),
                        ]) href="{{ route('dashboard.member') }}">
                            <span class="sidebar-icon">@include('components.icons.dolar')</span>
                            <span class="sidebar-text">Meu Dízimo</span>
                        </a>
                    @endcan


                    <a @class([
                        'sidebar-link',
                        'active' => request()->routeIs('dashboard.transparency'),
                    ]) href="{{ route('dashboard.transparency') }}">
                        <span class="sidebar-icon">@include('components.icons.graph')</span>
                        <span class="sidebar-text">Transparência</span>
                    </a>

                </div>
            @endcanany

            {{-- ================= CMS DO SITE ================= --}}
            @can('cms.access')
                <a @class([
                    'sidebar-link',
                    'active' => request()->routeIs('admin.site.*'),
                ]) href="{{ route('admin.site.index') }}">
                    <span class="sidebar-icon">@include('components.icons.picture')</span>
                    <span class="sidebar-text">Conteúdo do Site</span>
                </a>
            @endcan

            {{-- ================= PESSOAS ================= --}}
            @canany(['users.access', 'members.access'])
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Pessoas</span>

                    @can('members.access')
                        <a @class(['sidebar-link', 'active' => $menu === 'members']) href="{{ route('members.index') }}">
                            <span class="sidebar-icon">@include('components.icons.usercircle')</span>
                            <span class="sidebar-text">Membros</span>
                        </a>
                    @endcan

                    @can('users.access')
                        <a @class(['sidebar-link', 'active' => $menu === 'users']) href="{{ route('users.index') }}">
                            <span class="sidebar-icon">@include('components.icons.usersgroup')</span>
                            <span class="sidebar-text">Usuários</span>
                        </a>
                    @endcan
                </div>
            @endcanany

            {{-- ================= FINANCEIRO ================= --}}
            @canany(['donations.access', 'expenses.access'])
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Financeiro</span>

                    @can('donations.access')
                        <a @class(['sidebar-link', 'active' => $menu === 'donations']) href="{{ route('donations.index') }}">
                            <span class="sidebar-icon">@include('components.icons.plus')</span>
                            <span class="sidebar-text">Receitas</span>
                        </a>

                        @can('donations.view')
                            <a @class([
                                'sidebar-link',
                                'active' => request()->routeIs('donations.pending'),
                            ]) href="{{ route('donations.pending') }}">
                                <span class="sidebar-icon">@include('components.icons.question')</span>
                                <span class="sidebar-text">Confirmações Pendentes</span>
                            </a>
                        @endcan
                    @endcan

                    @can('expenses.access')
                        <a @class(['sidebar-link', 'active' => $menu === 'expenses']) href="{{ route('expenses.index') }}">
                            <span class="sidebar-icon">@include('components.icons.minus')</span>
                            <span class="sidebar-text">Despesas</span>
                        </a>

                        @can('expenses.approve')
                            <a @class([
                                'sidebar-link',
                                'active' => request()->routeIs('expenses.pending'),
                            ]) href="{{ route('expenses.pending') }}">
                                <span class="sidebar-icon">@include('components.icons.question')</span>
                                <span class="sidebar-text">Confirmações de Despesas</span>
                            </a>
                        @endcan
                    @endcan
                </div>
            @endcanany

            {{-- ================= RELATÓRIOS ================= --}}
            @can('reports.access')
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Relatórios</span>

                    @can('reports.tithes')
                        <a @class([
                            'sidebar-link',
                            'active' => request()->routeIs('reports.dizimos.*'),
                        ]) href="{{ route('reports.dizimos.paid') }}">
                            <span class="sidebar-icon">@include('components.icons.chartbar')</span>
                            <span class="sidebar-text">Relatórios de Dízimos</span>
                        </a>
                    @endcan

                    @can('reports.financial')
                        <a @class(['sidebar-link']) href="#">
                            <span class="sidebar-icon">@include('components.icons.docdolar')</span>
                            <span class="sidebar-text">Relatórios Financeiros</span>
                        </a>
                    @endcan
                </div>
            @endcan

            {{-- ================= CATEGORIAS ================= --}}
            @can('categories.access')
                <a @class(['sidebar-link', 'active' => $menu === 'categories']) href="{{ route('categories.index') }}">
                    <span class="sidebar-icon">@include('components.icons.tag')</span>
                    <span class="sidebar-text">Categorias</span>
                </a>
            @endcan

            {{-- ================= CONFIGURAÇÕES ================= --}}
            @canany(['settings.access', 'roles.view', 'permissions.view'])
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Configurações</span>

                    @can('settings.access')
                        <a @class(['sidebar-link', 'active' => $menu === 'statuses']) href="{{ route('statuses.index') }}">
                            <span class="sidebar-icon">@include('components.icons.newspaper')</span>
                            <span class="sidebar-text">Status</span>
                        </a>
                    @endcan

                    @can('roles.view')
                        <a @class(['sidebar-link', 'active' => $menu === 'roles']) href="{{ route('roles.index') }}">
                            <span class="sidebar-icon">@include('components.icons.usersgroup')</span>
                            <span class="sidebar-text">Papéis</span>
                        </a>
                    @endcan

                    @can('permissions.view')
                        <a @class([
                            'sidebar-link',
                            'active' => request()->routeIs('role-permissions.*'),
                        ])
                            href="{{ route('role-permissions.index', ['role' => \Spatie\Permission\Models\Role::first()->id ?? 1]) }}">
                            <span class="sidebar-icon">
                                @include('components.icons.shield')</span>
                            <span class="sidebar-text">Permissões</span>
                        </a>
                    @endcan
                </div>
            @endcanany

            {{-- ================= ÁREA DO MEMBRO ================= --}}
            @can('dashboard.member')
                <div class="sidebar-group">
                    <span class="sidebar-group-title">Minha Área</span>

                    <a @class([
                        'sidebar-link',
                        'active' => request()->routeIs('member.donations.*'),
                    ]) href="{{ route('member.donations.create') }}">
                        <span class="sidebar-icon">@include('components.icons.doc_plus')</span>
                        <span class="sidebar-text">Nova Doação</span>
                    </a>
                </div>
            @endcan

            {{-- ================= PERFIL ================= --}}
            <a @class(['sidebar-link', 'active' => $menu === 'profile']) href="{{ route('profile.show') }}">
                <span class="sidebar-icon">@include('components.icons.user')</span>
                <span class="sidebar-text">Perfil</span>
            </a>
        </nav>
    </div>
</aside>
