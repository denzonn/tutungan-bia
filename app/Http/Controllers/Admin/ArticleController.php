<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query();

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

        return view('pages.admin.article.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryArticle::all();
        
        return view('pages.admin.article.create', compact('categories'));
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
            $file_name = "article" . $random . "." . $extension;

            $data['image'] = $images->storeAs('article', $file_name, 'public');
        }

        Article::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'category_article_id' => $data['category_article_id'],
            'content' => $data['content'],
            'image' => $data['image'],
            'publish_date' => $data['publish_date'],
            'contributor_id' => auth()->user()->id,
            'editor_id' => auth()->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('artikel.index')->with('toast_success', 'Aktikel Berhasil Ditambahkan!');
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
        $data = Article::findOrFail($id);
        $categories = CategoryArticle::all();

        return view('pages.admin.article.edit', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($data['title']);

        $article = Article::findOrFail($id);

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            $extension = $images->getClientOriginalExtension();
            $random = \Str::random(10);
            $file_name = "artikel" . $random . "." . $extension;

            // Hapus gambar lama jika ada
            if ($article->image && Storage::exists('public/' . $article->image)) {
                Storage::delete('public/' . $article->image);
            }

            // Simpan gambar baru
            $data['image'] = $images->storeAs('artikel', $file_name, 'public');
        } else {
            $data['image'] = $article->image;
        }

        $article->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'category_article_id' => $data['category_article_id'],
            'content' => $data['content'],
            'image' => $data['image'],
            'publish_date' => $data['publish_date'],
            'status' => $data['status'] ?? 'draft',
            'editor_id' => auth()->user()->id,
        ]);

        return redirect()->route('artikel.index')->with('toast_success', 'Aktikel Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);

        if ($article->image && Storage::exists('public/' . $article->image)) {
            Storage::delete('public/' . $article->image);
        }

        $article->delete();

        return redirect()->route('artikel.index')->with('toast_success', 'Aktikel Berhasil Dihapus!');
    }
}
