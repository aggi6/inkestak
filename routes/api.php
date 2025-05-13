<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentController;

Route::post('/documents', [DocumentController::class, 'index']);
Route::get('/documents', [DocumentController::class, 'jasoDokumentuak']);
