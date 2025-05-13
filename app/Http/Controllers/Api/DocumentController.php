<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Dokumentuak ondo jaso dira!',
            'documents' => $request->input('documents'),
        ]);
    }
}