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
        $data = $query->orderBy('updated_at', 'desc')->paginate(10);

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

        // Pindahkan gambar utama (thumbnail) ke folder berita
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = "berita_" . time() . "." . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('public/berita', $filename);
        }

        // Ambil semua gambar dalam konten berita
        preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $data['content'], $matches);
        $images = $matches[1];

        $newContent = $data['content'];
        $usedImages = [];

        foreach ($images as $image) {
            if (strpos($image, 'storage/temp_ckeditor/') !== false) {
                // Pindahkan gambar dari 'temp_ckeditor' ke 'berita'
                $filename = basename($image);
                $oldPath = 'public/temp_ckeditor/' . $filename;
                $newPath = 'public/ckeditor/' . $filename;

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                // Perbarui URL dalam konten CKEditor
                $newImageUrl = asset('storage/ckeditor/' . $filename);
                $newContent = str_replace($image, $newImageUrl, $newContent);
                $usedImages[] = $filename;
            }
        }

        // Simpan berita dengan konten yang telah diperbarui
        News::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $newContent,
            'image' => $data['image'],
            'publish_date' => $data['publish_date'],
            'contributor_id' => auth()->user()->id,
            'editor_id' => auth()->user()->id,
        ]);

        // Hapus gambar yang tidak digunakan dari 'temp_ckeditor'
        $allTempFiles = Storage::files('public/temp_ckeditor');
        foreach ($allTempFiles as $tempFile) {
            $filename = basename($tempFile);
            if (!in_array($filename, $usedImages)) {
                Storage::delete($tempFile);
            }
        }

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

        // Proses upload gambar utama jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = "berita_" . time() . "." . $image->getClientOriginalExtension();

            // Hapus gambar lama jika ada
            if ($news->image && Storage::exists($news->image)) {
                Storage::delete($news->image);
            }

            // Simpan gambar baru
            $data['image'] = $image->storeAs('public/berita', $filename);
        } else {
            $data['image'] = $news->image;
        }

        // Ambil semua gambar dalam konten berita
        preg_match_all('/<img.*?src=["\'](.*?)["\'].*?>/i', $data['content'], $matches);
        $images = $matches[1];

        $newContent = $data['content'];
        $usedImages = [];

        foreach ($images as $image) {
            if (strpos($image, 'storage/temp_ckeditor/') !== false) {
                // Pindahkan gambar dari 'temp_ckeditor' ke 'ckeditor'
                $filename = basename($image);
                $oldPath = 'public/temp_ckeditor/' . $filename;
                $newPath = 'public/ckeditor/' . $filename;

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                // Perbarui URL dalam konten CKEditor
                $newImageUrl = asset('storage/ckeditor/' . $filename);
                $newContent = str_replace($image, $newImageUrl, $newContent);
                $usedImages[] = $filename;
            }
        }

        // Update berita dengan konten yang diperbarui
        $news->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $newContent,
            'image' => $data['image'],
            'publish_date' => $data['publish_date'],
            'editor_id' => auth()->user()->id,
            'status' => $data['status'] ?? 'draft',
            'updated_at' => Carbon::now(),
        ]);

        // Hapus gambar yang tidak digunakan dari 'temp_ckeditor'
        $allTempFiles = Storage::files('public/temp_ckeditor');
        foreach ($allTempFiles as $tempFile) {
            $filename = basename($tempFile);
            if (!in_array($filename, $usedImages)) {
                Storage::delete($tempFile);
            }
        }

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
