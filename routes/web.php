<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
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
    PaymentMethodController,
    MemberController,
    DonationController,
    ExpenseController
};
use App\Http\Controllers\MemberDonationController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

/*
|--------------------------------------------------------------------------
| Recuperação de Senha
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
| Área Autenticada
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboards
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])
            ->name('profile.show')
            ->middleware('permission:show-profile');

        Route::get('/edit', [ProfileController::class, 'edit'])
            ->name('profile.edit')
            ->middleware('permission:edit-profile');

        Route::put('/', [ProfileController::class, 'update'])
            ->name('profile.update')
            ->middleware('permission:edit-profile');

        Route::get('/password', [ProfileController::class, 'editPassword'])
            ->name('profile.password.edit')
            ->middleware('permission:edit-profile-password');

        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password.update')
            ->middleware('permission:edit-profile-password');
    });

    /*
    |--------------------------------------------------------------------------
    | Administração de Usuários e Permissões
    |--------------------------------------------------------------------------
    */
    Route::resource('users', UserController::class)
        ->middleware('permission:index-user');
    Route::get('/users/{user}/password', [UserController::class, 'editPassword'])
        ->name('users.password.edit')
        ->middleware('permission:edit-password-user');

    Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])
        ->name('users.password.update')
        ->middleware('permission:edit-password-user');


    Route::resource('roles', RoleController::class)
        ->middleware('permission:index-role');

    Route::prefix('role-permissions')->group(function () {
        Route::get('/{role}', [RolePermissionController::class, 'index'])
            ->name('role-permissions.index')
            ->middleware('permission:index-role-permission');

        Route::put('/{role}/{permission}', [RolePermissionController::class, 'update'])
            ->name('role-permissions.update')
            ->middleware('permission:update-role-permission');
    });

    /*
    |--------------------------------------------------------------------------
    | Cadastros Gerais
    |--------------------------------------------------------------------------
    */
    Route::resource('statuses', StatusController::class)
        ->middleware('permission:index-user-status');

    Route::resource('categories', CategoryController::class)
        ->middleware('permission:index-category');

    Route::resource('payment-methods', PaymentMethodController::class);

    /*
    |--------------------------------------------------------------------------
    | Membros
    |--------------------------------------------------------------------------
    */
    Route::resource('members', MemberController::class)
        ->middleware('permission:index-member');
});

/*
    |--------------------------------------------------------------------------
    | Financeiro
    |--------------------------------------------------------------------------
    */
Route::resource('donations', DonationController::class)
    ->middleware('permission:index-donation');

Route::resource('expenses', ExpenseController::class)
    ->middleware('permission:index-expense');

/*
    |--------------------------------------------------------------------------
    | Área do Membro (doações próprias)
    |--------------------------------------------------------------------------
    */
Route::prefix('meu-dizimo')->middleware('permission:view-dashboard-member')->group(function () {

    Route::get('/doacoes/create', [MemberDonationController::class, 'create'])
        ->name('member.donation.create');

    Route::post('/doacoes', [MemberDonationController::class, 'store'])
        ->name('member.donation.store');
});
