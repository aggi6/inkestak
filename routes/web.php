<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PollAnswerController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\PollDataTableController;
use App\Http\Controllers\Front\FrontAnswerController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ua', function () {
    return view('ua');
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
Route::patch('polls/{poll}/restore', [PollController::class, 'restore'])->name('polls.restore')->middleware(['auth', 'verified']);
Route::get('polls/trash', [PollController::class, 'trash'])->name('polls.trash')->middleware(['auth','verified']);

Route::get('questions/{poll}/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('questions/{poll}', [QuestionController::class, 'store'])->name('questions.store');
Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::patch('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

Route::resource('answers', PollAnswerController::class)
    ->only(['index', 'create', 'store'])
    ->middleware(['auth', 'verified']);

Route::get('front/polled', [FrontAnswerController::class, 'polled'])->name('front.polled')->middleware(['auth','verified']);
Route::get('front/{polled}/polls', [FrontAnswerController::class, 'polls'])->name('front.polls')->middleware(['auth','verified']);
Route::get('front/{polled}/{poll}/create', [FrontAnswerController::class, 'create'])->name('front.create')->middleware(['auth','verified']);
Route::post('front/polledCreate', [FrontAnswerController::class, 'polledCreate'])->name('front.polledCreate')->middleware(['auth','verified']);
Route::post('front/store/{polled}/{poll}', [FrontAnswerController::class, 'store'])->name('front.store')->middleware(['auth','verified']);

Route::get('users', [UserController::class, 'index'])->name('users');
Route::get('pollDataTable', [PollDataTableController::class, 'index'])->name('pollDataTable');

require __DIR__.'/auth.php';
