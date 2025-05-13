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

    public function jasoDokumentuak(){
        return response()->json([
            [
                'id' => 1,
                'name' => 'Dokumentua 1',
                'path' => 'https://pdfobject.com/pdf/sample.pdf',
                'can_download' => false,
                'active' => true],
            [
                'id' => 2,
                'name' => 'Dokumentua 2',
                'path' => 'https://pdfobject.com/pdf/sample.pdf',
                'can_download' => true,
                'active' => true
            ],
            [
                'id' => 3,
                'name' => 'Dokumentua 3',
                'path' => 'https://pdfobject.com/pdf/sample.pdf',
                'can_download' => true,
                'active' => false
            ],
            [
                'id' => 4,
                'name' => 'Dokumentua 4',
                'path' => 'https://pdfobject.com/pdf/sample.pdf',
                'can_download' => false,
                'active' => false
            ],
        ]);
    }
}