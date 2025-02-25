<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class, 'index'])->name('home');

//admin guard routes
Route::middleware([AdminMiddleware::class])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

//user login routes
Route::get('/login', [AuthController::class, 'ShowLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

//user register routes
Route::get('/register', [AuthController::class, 'ShowRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

//user register routes
// Route::get('/register', [AuthController::class, 'ShowRegisterForm'])->name('auth.register.form'); logout doesn't use get because we don't want anything in url
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


//admin login route
Route::get('/admin/login', [AdminAuthController::class, 'ShowAdminLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

//admin logout route
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
