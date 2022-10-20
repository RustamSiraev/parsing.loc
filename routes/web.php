<?php


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parsing\ParsingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('web')->group(function () {
    // главная
    Route::get('/', [SignupController::class, 'index'])->name('index');

    // форма регистрации
    Route::get('register', [SignupController::class, 'register'])->name('register');

    // создание пользователя
    Route::post('register', [SignupController::class, 'create'])->name('create');

    // форма входа
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

    // аутентификация
    Route::post('login', [LoginController::class, 'login']);

    // выход
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // смена пароля
    Route::get('password', [SignupController::class, 'password'])->name('password');

    // сброс пароля
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/start', [HomeController::class, 'start'])->name('start');
    Route::get('/parsing', [HomeController::class, 'parsing'])->name('parsing');
    Route::get('/parsing/list', [HomeController::class, 'getParsings'])->name('parsings.list');
    Route::get('/result/list', [HomeController::class, 'getResults'])->name('results.list');

Route::middleware('auth')->group(function () {
    // Админ
    Route::group(['middleware' => 'role:root'], function() {
        Route::prefix('admin')->group(function () {
            // Пользователи
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/users/list', [UserController::class, 'getUsers'])->name('users.list');
            Route::get('/users/{user}/password', [UserController::class, 'password'])->name('users.password');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::get('/users/{user}/parsing', [UserController::class, 'parsing'])->name('users.parsing');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::get('/deleteUser', [UserController::class, 'deleteUser']);
        });
    });

    Route::post('/users/change', [UserController::class, 'change'])->name('users.password.change');
    Route::get('changeStatus', [UserController::class, 'changeStatus']);
    Route::get('download/{file}', [HomeController::class, 'download'])->name('download');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
});

