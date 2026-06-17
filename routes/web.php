<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleRequestController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('events', EventController::class);
    Route::resource('comments', CommentController::class);

    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
    Route::get('/my-comments', [CommentController::class, 'myComments'])->name('comments.my');

    Route::prefix('role-request')->name('role-request.')->group(function () {
        Route::get('/create', [RoleRequestController::class, 'create'])->name('create');
        Route::post('/', [RoleRequestController::class, 'store'])->name('store');
        Route::get('/my-requests', [RoleRequestController::class, 'myRequests'])->name('my-requests');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/role-requests', [AdminController::class, 'roleRequests'])->name('role-requests');
    Route::patch('/role-requests/{id}/approve', [AdminController::class, 'approveRequest'])->name('role-requests.approve');
    Route::patch('/role-requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('role-requests.reject');
});

