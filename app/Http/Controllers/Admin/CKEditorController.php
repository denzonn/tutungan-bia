<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json(["error" => ["message" => "Tidak ada file yang diunggah."]]);
        }

        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/temp_ckeditor', $filename); // Simpan di folder sementara

        $url = asset('storage/temp_ckeditor/' . $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url
        ]);
    }
}