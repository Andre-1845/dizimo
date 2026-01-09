<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DizimoDashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Member\MemberDonationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\MemberDonationController as ControllersMemberDonationController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

// Pagina inicial do site
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pagina de LOGIN
Route::get('/login', [AuthController::class, 'index'])->name('login');

// Processamento de LOGIN
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Formulario cadastrar novo usuario
Route::get('/register', [AuthController::class, 'create'])->name('register');

// Receber os dados do formulario e cadastrar novo usuario
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

// Recuperar senha
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showRequestForm'])->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Novas rotas para DIZIMO

Route::resource('categories', CategoryController::class);
Route::resource('payment-methods', PaymentMethodController::class);
Route::resource('members', MemberController::class);
Route::resource('donations', DonationController::class);
Route::resource('expenses', ExpenseController::class);

// DASHBOARD Rotas //

// Route::middleware(['auth'])->group(function () {
// get('/dashboard', [DashboardController::class, 'index'])
//     ->name('dashboard.index');}

Route::middleware(['auth', 'permission:view-dashboard-admin'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index');

Route::get('/meu-painel', [DashboardController::class, 'member'])
    ->name('dashboard.member');

Route::get('/dashboard-dizimo', [DizimoDashboardController::class, 'index'])
    ->name('dashboard.dizimo_index')
    ->middleware('permission:view-dashboard-dizimo');

Route::get('/dashboardMember', [MemberDashboardController::class, 'index'])
    ->name('members.dashboard')
    ->middleware('permission:view-dashboard-member');

Route::put('/dashboardMember', [MemberDashboardController::class, 'updateTithe'])
    ->name('members.update_tithe')
    ->middleware('permission:update-tithe');

Route::middleware(['auth', 'role:Membro'])->group(function () {
    Route::get('/meu-dizimo/doacoes/create', [ControllersMemberDonationController::class, 'create'])
        ->name('member.create_donation');

    Route::post('/meu-dizimo/doacoes', [ControllersMemberDonationController::class, 'store'])
        ->name('member.store_donation');
});




//Grupo de rotas restritas
// Necessita estar logado para acessar essas rotas
Route::group(['middleware' => 'auth'], function () {

    // Dashboard
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('permission:dashboard');



    // Perfil do Usuario

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show')->middleware('permission:show-profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('permission:edit-profile');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update')->middleware('permission:edit-profile');
        Route::get('/edit_password', [ProfileController::class, 'editPassword'])->name('profile.edit_password')->middleware('permission:edit-profile-password');
        Route::put('/update_password', [ProfileController::class, 'updatePassword'])->name('profile.update_password')->middleware('permission:edit-profile-password');
    });

    // Status
    Route::get('/index-status', [StatusController::class, 'index'])->name('statuses.index')->middleware('permission:index-status');
    Route::get('/create-status', [StatusController::class, 'create'])->name('statuses.create')->middleware('permission:create-status');
    Route::post('/store-status', [StatusController::class, 'store'])->name('statuses.store')->middleware('permission:create-status');


    // User
    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('permission:index-user');
        Route::get('/list/{status}', [UserController::class, 'list'])->name('users.list')->middleware('permission:show-user');
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create-user');
        Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('permission:create-user');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:show-user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit-user');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit-user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:destroy-user');
        Route::get('/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.edit_password')->middleware('permission:edit-user');
        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update_password')->middleware('permission:edit-user');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:index-role');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create-role');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create-role');
        Route::get('/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:show-role');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit-role');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit-role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:destroy-role');
    });

    // Permissao do papel

    // A utilizacao do PREFIX facilita na criacao das rotas
    Route::prefix('role-permissions')->group(function () {
        Route::get('/{role}', [RolePermissionController::class, 'index'])->name('role-permissions.index')->middleware('permission:index-role-permission');

        Route::get('/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permissions.update')->middleware('permission:update-role-permission');
    });
});
