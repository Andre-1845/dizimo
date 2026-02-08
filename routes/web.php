<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\{
    AuthController,
    ForgotPasswordController,
    DashboardController,
    DizimoDashboardController,
    MemberDashboardController,
    ProfileController,
    StatusController,
    UserController,
    RoleController,
    RolePermissionController,
    CategoryController,
    DizimoReportController,
    PaymentMethodController,
    MemberController,
    DonationController,
    ExpenseController,
    FinancialReportController,
    ReportController,
    SiteController,
    TransparencyDashboardController
};

use App\Http\Controllers\MemberDonationController;
use App\Http\Controllers\Admin\{
    SiteSectionController,
    SiteEventController,
    SiteImageController,
    SiteSettingController,
    SiteActivityController,
    SiteNoticeController,
    SitePersonController
};
use App\Http\Controllers\Site\TeamController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| SITE PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/login-teste', function () {
return 'rota /login-teste OK';
});

Route::get('/', [SiteController::class, 'home'])
    ->name('site.home');
Route::get('/equipe', [TeamController::class, 'index'])
    ->name('site.team');

/*
|--------------------------------------------------------------------------
| AUTENTICAÇÃO
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| RECUPERAÇÃO DE SENHA
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| VERIFICAÇÃO DE E-MAIL
|--------------------------------------------------------------------------
*/
Route::get('/email/verify', fn() => view('auth.verify-email'))
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    //  ATIVA O USUÁRIO APÓS VERIFICAÇÃO
    $user = $request->user();
    $user->update([
        'status_id' => 2 // ATIVO
    ]);
    return redirect('/login')
        ->with('success', 'E-mail confirmado com sucesso!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'E-mail reenviado.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| CMS DO SITE (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'permission:cms.access'])
    ->prefix('admin/site')
    ->name('admin.site.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.site.index');
        })->name('index');

        // Atividades do site (horarios)
        Route::resource('site-activities', SiteActivityController::class);

        // Equipe da Igreja
        Route::resource('people', SitePersonController::class);

        // Avisos do site
        Route::resource('notices', SiteNoticeController::class);

        // Eventos
        Route::resource('events', SiteEventController::class);

        // Seções
        Route::resource('sections', SiteSectionController::class)
            ->only(['index', 'edit', 'update']);

        // Configurações
        Route::get('settings', [SiteSettingController::class, 'edit'])
            ->name('settings.edit');

        Route::put('settings', [SiteSettingController::class, 'update'])
            ->name('settings.update');

        // Imagens
        Route::get('sections/{section}/images', [SiteImageController::class, 'index'])
            ->name('images.index');

        Route::post('sections/{section}/images', [SiteImageController::class, 'store'])
            ->name('images.store');

        Route::delete('images/{image}', [SiteImageController::class, 'destroy'])
            ->name('images.destroy');
    });


/*
|--------------------------------------------------------------------------
| SISTEMA (USUÁRIOS AUTENTICADOS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'user.status'])->group(function () {

    /*
    | Dashboards
    */
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])
        ->name('dashboard.admin')
        ->middleware('permission:dashboard.admin');

    Route::get('/dashboard/tesouraria', [DizimoDashboardController::class, 'index'])
        ->name('dashboard.treasury')
        ->middleware('permission:dashboard.treasury');

    Route::get('/dashboard/membro', [MemberDashboardController::class, 'index'])
        ->name('dashboard.member')
        ->middleware('permission:dashboard.member');

    Route::put('/dashboard/membro/dizimo', [MemberDashboardController::class, 'updateTithe'])
        ->name('dashboard.member.update-tithe')
        ->middleware('permission:members.tithe-manage');

    // Rota de fallback para dashboard (redireciona para o dashboard apropriado)
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->can('dashboard.admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->can('dashboard.treasury')) {
            return redirect()->route('dashboard.treasury');
        } elseif ($user->can('dashboard.member')) {
            return redirect()->route('dashboard.member');
        }

        return redirect()->route('profile.show');
    })->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard/transparencia', [TransparencyDashboardController::class, 'index'])
            ->name('dashboard.transparency');
    });

    // Dashboard de Transparência (para todos logados)
    Route::middleware(['auth'])->group(function () {
        Route::get('/transparencia', [TransparencyDashboardController::class, 'index'])
            ->name('transparency.dashboard');
    });

    // CRUD de Relatórios TRANSPARENCIA
    // Route::middleware(['auth'])->prefix('admin')->group(function () {
    //     Route::resource('reports', ReportController::class);
    //     Route::post('/reports/{report}/toggle-status', [ReportController::class, 'toggleStatus'])
    //         ->name('reports.toggle-status');
    // });

    Route::middleware(['auth', 'verified'])
        ->prefix('admin')
        ->group(function () {

            Route::resource('reports', FinancialReportController::class);
        });


    /*
    | Relatórios (apenas para quem tem acesso a relatórios)
    */
    Route::middleware('permission:reports.access')->group(function () {
        Route::prefix('relatorios/dizimos')->group(function () {
            Route::get('pagaram', [DizimoReportController::class, 'paid'])
                ->name('reports.dizimos.paid')
                ->middleware('permission:reports.tithes');

            Route::get('pendentes', [DizimoReportController::class, 'pending'])
                ->name('reports.dizimos.pending')
                ->middleware('permission:reports.tithes');

            Route::get('anonimos', [DizimoReportController::class, 'anonymous'])
                ->name('reports.dizimos.anonymous')
                ->middleware('permission:reports.tithes');
        });

        Route::prefix('relatorios/dizimos/export')->group(function () {
            Route::get('pagaram/csv', [DizimoReportController::class, 'exportPaidCsv'])
                ->name('reports.dizimos.export.paid.csv')
                ->middleware('permission:reports.export');

            Route::get('pendentes/csv', [DizimoReportController::class, 'exportPendingCsv'])
                ->name('reports.dizimos.export.pending.csv')
                ->middleware('permission:reports.export');

            Route::get('anonimos/csv', [DizimoReportController::class, 'exportAnonymousCsv'])
                ->name('reports.dizimos.export.anonymous.csv')
                ->middleware('permission:reports.export');

            Route::get('pagaram/pdf', [DizimoReportController::class, 'exportPaidPdf'])
                ->name('reports.dizimos.export.paid.pdf')
                ->middleware('permission:reports.export');

            Route::get('pendentes/pdf', [DizimoReportController::class, 'exportPendingPdf'])
                ->name('reports.dizimos.export.pending.pdf')
                ->middleware('permission:reports.export');

            Route::get('anonimos/pdf', [DizimoReportController::class, 'exportAnonymousPdf'])
                ->name('reports.dizimos.export.anonymous.pdf')
                ->middleware('permission:reports.export');
        });
    });

    /*
    | Financeiro - Doações
    */
    Route::middleware('permission:donations.access')->group(function () {
        Route::prefix('donations')->group(function () {
            Route::get('pendentes', [DonationController::class, 'pending'])
                ->name('donations.pending')
                ->middleware('permission:donations.view');

            Route::patch('{donation}/confirm', [DonationController::class, 'confirm'])
                ->name('donations.confirm')
                ->middleware('permission:donations.confirm');
        });

        Route::resource('donations', DonationController::class);
    });

    /*
    | Financeiro - Despesas
    */
    Route::middleware('permission:expenses.access')->group(function () {

        Route::prefix('expenses')->group(function () {
            Route::get('pendentes', [ExpenseController::class, 'pending'])
                ->name('expenses.pending')
                ->middleware('permission:expenses.view');

            Route::patch('/{expense}/confirm', [ExpenseController::class, 'confirm'])
                ->name('expenses.confirm')
                ->middleware('permission:expenses.approve');

            Route::resource('expenses', ExpenseController::class);
        });
    });

    /*
    | Cadastros - Usuários
    */
    Route::middleware('permission:users.access')->group(function () {
        Route::resource('users', UserController::class);

        Route::get('/users/{user}/password', [UserController::class, 'editPassword'])
            ->name('users.password.edit')
            ->middleware('permission:users.reset-password');

        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])
            ->name('users.password.update')
            ->middleware('permission:users.reset-password');
    });

    /*
    | Cadastros - Membros
    */
    Route::middleware('permission:members.access')->group(function () {
        Route::resource('members', MemberController::class);
    });

    /*
    | Cadastros - Categorias
    */
    Route::middleware('permission:categories.access')->group(function () {
        Route::resource('categories', CategoryController::class);
    });

    /*
    | Cadastros - Status (apenas admin)
    */
    Route::middleware('permission:settings.access')->group(function () {
        Route::resource('statuses', StatusController::class)
            ->middleware('permission:settings.view');
    });

    /*
    | Métodos de Pagamento (acesso geral para quem usa doações)
    */
    Route::middleware('permission:donations.create')->group(function () {
        Route::resource('payment-methods', PaymentMethodController::class)
            ->only(['index']); // Apenas visualização
    });

    /*
    | Segurança - Papéis e Permissões
    */
    Route::middleware('permission:settings.access')->group(function () {
        // Papéis
        Route::resource('roles', RoleController::class)
            ->middleware('permission:roles.view');

        // Gerenciamento de Permissões por Papel
        Route::prefix('role-permissions')->group(function () {
            Route::get('/{role}', [RolePermissionController::class, 'index'])
                ->name('role-permissions.index')
                ->middleware('permission:permissions.view');

            Route::put('/{role}/{permission}', [RolePermissionController::class, 'toggle'])
                ->name('role-permissions.toggle')
                ->middleware('permission:permissions.manage');
        });
    });

    /*
    | Área do Membro (doações pessoais)
    */
    Route::prefix('minhas-doacoes')->middleware('permission:dashboard.member')->group(function () {

        Route::get('create', [MemberDonationController::class, 'create'])
            ->name('member.donations.create')
            ->middleware('permission:donations.create');

        Route::post('/', [MemberDonationController::class, 'store'])
            ->name('member.donations.store')
            ->middleware('permission:donations.create');

        Route::get('/{donation}', [MemberDonationController::class, 'show'])->name('member.donations.show');

        Route::get('/{donation}/edit', [MemberDonationController::class, 'edit'])->name('member.donations.edit'); // NOVA

        Route::put('/{donation}', [MemberDonationController::class, 'update'])->name('member.donations.update'); // NOVA

        Route::get('/{donation}/download-receipt', [MemberDonationController::class, 'downloadReceipt'])
            ->name('member.donations.download-receipt');

        Route::delete('/{donation}', [MemberDonationController::class, 'destroy'])->name('member.donations.destroy');
    });

    /*
    | Perfil (acesso livre para todos autenticados)
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])
            ->name('profile.show')
            ->middleware('permission:profile.view');

        Route::get('/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit')
            ->middleware('permission:profile.edit');

        Route::put('/', [ProfileController::class, 'update'])
            ->name('profile.update')
            ->middleware('permission:profile.edit');

        Route::get('/password', [ProfileController::class, 'editPassword'])
            ->name('profile.password.edit')
            ->middleware('permission:profile.password');

        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password.update')
            ->middleware('permission:profile.password');
    });

    /*
    | Transparência (acesso público autenticado)
    */
    // Route::middleware('permission:transparency.access')->group(function () {
    //     Route::get('/transparencia', function () {
    //         return view('transparency.index');
    //     })->name('transparency.index');
    // });
});
