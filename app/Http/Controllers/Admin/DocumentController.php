<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dokument::query();

        // Fitur pencarian berdasarkan judul
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Pagination dengan 10 item per halaman
        $data = $query->paginate(10);

        return view('pages.admin.document.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('file')) {
            $images = $request->file('file');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "file" . $random . "." . $extension;

            $data['file'] = $images->storeAs('file', $file_name, 'public');
        }

        Dokument::create($data);

        return redirect()->route('dokumen.index')->with('toast_success', 'Dokumen berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Dokument::findOrFail($id);

        return view('pages.admin.document.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $item = Dokument::findOrFail($id);

        if ($request->hasFile('file')) {
            $images = $request->file('file');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "file" . $random . "." . $extension;

            // Hapus file lama jika ada
            if ($item->file && file_exists(storage_path('app/public/' . $item->file))) {
                Storage::delete('public/' . $item->file);
            }

            $data['file'] = $images->storeAs('file', $file_name, 'public');
        }

        $item->update($data);

        return redirect()->route('dokumen.index')->with('toast_success', 'Dokumen berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Dokument::findOrFail($id);

        // Hapus file jika ada
        if ($item->file && file_exists(storage_path('app/public/' . $item->file))) {
            Storage::delete('public/' . $item->file);
        }

        $item->delete();

        return redirect()->route('dokumen.index')->with('toast_success', 'Dokumen berhasil dihapus');
    }
}
