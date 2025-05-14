<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentController;

Route::get('/documents', [DocumentController::class, 'jasoDokumentuak']);
