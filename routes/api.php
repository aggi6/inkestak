<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DocumentController;

Route::get('/documents', [DocumentController::class, 'index']);
// ez du funtzionatzen eta ez dakit zergaitik, horregatik jarri dut web.php-en ere
