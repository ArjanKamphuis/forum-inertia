<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\ThreadsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', fn() => redirect(route('threads')));

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/threads/create', [ThreadsController::class, 'create'])->name('threads.create');
Route::get('/threads/{channel:slug?}', [ThreadsController::class, 'index'])->name('threads');
Route::get('/threads/{channel:slug}/{thread}', [ThreadsController::class, 'show']);
Route::post('/threads/{channel:slug}/{thread}/replies', [RepliesController::class, 'store'])->name('threads.add-reply');
Route::post('/threads', [ThreadsController::class, 'store']);
Route::delete('/threads/{channel:slug}/{thread}', [ThreadsController::class, 'destroy']);

Route::delete('/replies/{reply}', [RepliesController::class, 'destroy']);
Route::post('/replies/{reply}/favorites', [FavoritesController::class, 'store']);

Route::get('/profiles/{user:name}', [ProfilesController::class, 'Show'])->name('profiles.show');
