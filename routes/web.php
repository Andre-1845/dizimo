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
    SiteController
};

use App\Http\Controllers\MemberDonationController;
use App\Http\Controllers\Admin\{
    SiteSectionController,
    SiteEventController,
    SiteImageController,
    SiteSettingController
};

/*
|--------------------------------------------------------------------------
| SITE PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/', [SiteController::class, 'home'])
    ->name('site.home');

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
Route::middleware(['auth', 'verified', 'permission:manage-site-content'])
    ->prefix('admin/site')
    ->name('admin.site.')
    ->group(function () {

        Route::get('/', function () {
            return view('admin.site.index');
        })->name('index');

        Route::resource('sections', SiteSectionController::class)
            ->only(['index', 'edit', 'update']);

        Route::resource('events', SiteEventController::class);

        Route::get('settings', [SiteSettingController::class, 'edit'])
            ->name('settings.edit');

        Route::put('settings', [SiteSettingController::class, 'update'])
            ->name('settings.update');

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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index')
        ->middleware('permission:view-dashboard-admin');

    Route::get('/dashboard-dizimo', [DizimoDashboardController::class, 'index'])
        ->name('dashboard.dizimo')
        ->middleware('permission:view-dashboard-dizimo');

    Route::get('/meu-painel', [MemberDashboardController::class, 'index'])
        ->name('dashboard.member')
        ->middleware('permission:view-dashboard-member');

    Route::put('/meu-painel/dizimo', [MemberDashboardController::class, 'updateTithe'])
        ->name('dashboard.member.update-tithe')
        ->middleware('permission:edit-member');

    Route::get('/meu-painel-antigo', [DashboardController::class, 'member'])
        ->name('dashboard.member.old')
        ->middleware([
            'auth',
            'verified',
            'user.status',
            'permission:view-dashboard-member'
        ]);
    /*
    | Relatórios
    */
    Route::prefix('dashboard/dizimos')->group(function () {
        Route::get('pagaram', [DizimoReportController::class, 'paid'])->name('dizimos.paid');
        Route::get('pendentes', [DizimoReportController::class, 'pending'])->name('dizimos.pending');
        Route::get('anonimos', [DizimoReportController::class, 'anonymous'])->name('dizimos.anonymous');
    });

    Route::prefix('dashboard/dizimos/export')->group(function () {
        Route::get('pagaram/csv', [DizimoReportController::class, 'exportPaidCsv'])->name('dizimos.export.paid.csv');
        Route::get('pendentes/csv', [DizimoReportController::class, 'exportPendingCsv'])->name('dizimos.export.pending.csv');
        Route::get('anonimos/csv', [DizimoReportController::class, 'exportAnonymousCsv'])->name('dizimos.export.anonymous.csv');

        Route::get('pagaram/pdf', [DizimoReportController::class, 'exportPaidPdf'])->name('dizimos.export.paid.pdf');
        Route::get('pendentes/pdf', [DizimoReportController::class, 'exportPendingPdf'])->name('dizimos.export.pending.pdf');
        Route::get('anonimos/pdf', [DizimoReportController::class, 'exportAnonymousPdf'])->name('dizimos.export.anonymous.pdf');
    });

    /*
    | Financeiro
    */
    Route::prefix('donations')->group(function () {
        Route::get('pendentes', [DonationController::class, 'pending'])
            ->name('donations.pending')
            ->middleware('permission:index-donation');

        Route::patch('{donation}/confirm', [DonationController::class, 'confirm'])
            ->name('donations.confirm')
            ->middleware('permission:index-donation');
    });

    Route::resource('donations', DonationController::class)
        ->middleware('permission:index-donation');

    Route::resource('expenses', ExpenseController::class)
        ->middleware('permission:index-expense');

    /*
    | Cadastros
    */
    Route::resource('users', UserController::class)->middleware('permission:index-user');
    Route::resource('roles', RoleController::class)->middleware('permission:index-role');
    Route::resource('statuses', StatusController::class)->middleware('permission:index-user-status');
    Route::resource('categories', CategoryController::class)->middleware('permission:index-category');
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::resource('members', MemberController::class)->middleware('permission:index-member');

    /*
    | Permissoes
    */

    Route::prefix('role-permissions')->group(function () {
        Route::get('/{role}', [RolePermissionController::class, 'index'])
            ->name('role-permissions.index')
            ->middleware('permission:index-role-permission');

        // Route::put('/{role}/{permission}', [RolePermissionController::class, 'update'])
        //     ->name('role-permissions.update')
        //     ->middleware('permission:update-role-permission');
        Route::put(
            '/{role}/{permission}',
            [RolePermissionController::class, 'toggle']
        )->name('role-permissions.toggle');
    });
    /*
    | Área do Membro
    */
    Route::prefix('meu-dizimo')->middleware('permission:view-dashboard-member')->group(function () {
        Route::get('doacoes/create', [MemberDonationController::class, 'create'])
            ->name('member.donation.create');

        Route::post('doacoes', [MemberDonationController::class, 'store'])
            ->name('member.donation.store');
    });

    /*
    | Perfil
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
});
