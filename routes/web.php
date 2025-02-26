<?php
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class, 'index'])->name('home');

//admin guard routes
Route::middleware([AdminMiddleware::class])
->name('admin.')
->prefix('admin')
->group(function(){
    //Admin dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
    //Admin category route
    Route::resource('categories', CategoryController::class)->except('show');
    //Admin product route
    Route::resource('products', ProductController::class);
});

//user profile routes
Route::middleware(UserMiddleware::class)
->group(function () {
    // Profile routes
    Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.profile.update');
});

//user login routes
Route::get('/login', [AuthController::class, 'ShowLoginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

//user register routes
Route::get('/register', [AuthController::class, 'ShowRegisterForm'])->name('auth.register.form');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

//user logout routes
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//admin login route
Route::get('/admin/login', [AdminAuthController::class, 'ShowAdminLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

//admin logout route
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
