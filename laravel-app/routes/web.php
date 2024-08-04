<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/post/show/{post}', [PostController::class, 'show'])->name('post.show');






Route::middleware('auth')->group(function () {
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.add');
    Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.add');
    Route::get('/post/destroy/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});

Route::get('/test-permission', function () {
    return 'Middleware works!';
})->middleware('permission:role-list');


