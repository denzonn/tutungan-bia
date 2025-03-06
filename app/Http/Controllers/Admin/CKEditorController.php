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

        // Ambil ekstensi file
        $extension = $file->getClientOriginalExtension();

        // Buat nama file baru berdasarkan timestamp
        $filename = 'ckeditor_' . now()->format('YmdHis') . '.' . $extension;

        // Simpan file ke dalam storage/public/temp_ckeditor
        $file->storeAs('public/temp_ckeditor', $filename);

        // Generate URL agar bisa diakses dari public/storage/temp_ckeditor
        $url = asset('storage/temp_ckeditor/' . $filename);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $filename, // Nama file baru
            'url' => $url // CKEditor akan menggunakan URL ini
        ]);
    }
}
