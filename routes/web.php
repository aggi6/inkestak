<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('polls', PollController::class)
    ->only(['index', 'store', 'create', 'destroy', 'edit', 'update'])
    ->middleware(['auth','verified']);
Route::patch('polls/{poll}/restore', [PollController::class, 'restore'])->name('polls.restore');
Route::get('polls/trash', [PollController::class, 'trash'])->name('polls.trash');

Route::get('questions/{poll}/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('questions/{poll}', [QuestionController::class, 'store'])->name('questions.store');
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::patch('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

require __DIR__.'/auth.php';
