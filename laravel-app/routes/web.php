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


//    Route::get('/roles/index/', [RoleController::class, 'index'])->name('roles.index');
//    Route::post('/roles/store', [RoleController::class, 'update'])->name('roles.store');
//    Route::get('/roles/create/', [RoleController::class, 'edit'])->name('roles.edit');
//    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
//    Route::get('/roles/show/{id}', [RoleController::class, 'show'])->name('roles.show');
//    Route::patch('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
//    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
//
//
//    Route::get('/users/index/', [UserController::class, 'index'])->name('users.index');
//    Route::get('/users/create/', [UserController::class, 'create'])->name('users.create');
//    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
//    Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
//    Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
//    Route::post('/users/store', [UserController::class, 'update'])->name('users.store');
//    Route::get('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

});

Route::get('/test-permission', function () {
    return 'Middleware works!';
})->middleware('permission:role-list');


