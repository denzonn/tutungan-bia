<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = News::query();

        // Cek role pengguna yang login
        $user = Auth::user();

        // Jika pengguna dengan role 'CONTRIBUTOR', filter berita berdasarkan contributor_id
        if ($user->hasRole('CONTRIBUTOR')) {
            $query->where('contributor_id', $user->id);
        }

        // Fitur pencarian berdasarkan judul
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Pagination dengan 10 item per halaman
        $data = $query->paginate(10);

        return view('pages.admin.news.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $images = $request->file('image');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "berita" . $random . "." . $extension;

            $data['image'] = $images->storeAs('berita', $file_name, 'public');
        }

        News::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'image' => $data['image'],
            'contributor_id' => auth()->user()->id,
            'editor_id' => auth()->user()->id,
        ]);

        return redirect()->route('berita.index')->with('toast_success', 'Berita Berhasil Ditambahkan!');
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
        $data = News::findOrFail($id);
        return view('pages.admin.news.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($data['title']);

        $news = News::findOrFail($id);

        // Proses upload gambar baru jika ada
        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $extension = $images->getClientOriginalExtension();
            $random = \Str::random(10);
            $file_name = "berita" . $random . "." . $extension;

            // Hapus gambar lama jika ada
            if ($news->image && Storage::exists('public/' . $news->image)) {
                Storage::delete('public/' . $news->image);
            }

            // Simpan gambar baru
            $data['image'] = $images->storeAs('berita', $file_name, 'public');
        } else {
            $data['image'] = $news->image;
        }

        // Update data berita
        $news->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'image' => $data['image'],
            'editor_id' => auth()->user()->id,
            'status' => $data['status'] ?? 'draft',
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('berita.index')->with('toast_success', 'Berita Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = News::findOrFail($id);

        if ($data->image && file_exists(storage_path('app/public/' . $data->image))) {
            Storage::delete('public/' . $data->image);
        }

        $data->delete();

        return redirect()->route('berita.index')->with('toast_success', 'Berita Berhasil Dihapuskan!');;
    }
}
