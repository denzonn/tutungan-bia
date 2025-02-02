<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleVisitor;
use App\Models\CategoryArticle;
use App\Models\Dokument;
use App\Models\News;
use App\Models\NewsVisitors;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function getTrending()
    {
        return News::orderBy('click_count', 'desc') // Urutkan berdasarkan views
            ->where('status', 'published')
            ->take(1) // Ambil 1 artikel
            ->first(); // Ambil artikel pertama
    }

    public function getTopTrending($trendingId)
    {
        return News::orderBy('click_count', 'desc')
            ->where('id', '!=', $trendingId)
            ->where('status', 'published')
            ->take(3)
            ->get();
    }

    public function getTopTrendingNews()
    {
        return News::orderBy('click_count', 'desc')
            ->where('status', 'published')
            ->take(5)
            ->get();
    }

    public function getTopTrendingArticle()
    {
        return Article::orderBy('click_count', 'desc')
            ->where('status', 'published')
            ->take(5)
            ->get();
    }

    public function getTopTrendingArticles($trendingId)
    {
        return Article::orderBy('click_count', 'desc')
            ->where('id', '!=', $trendingId)
            ->where('status', 'published')
            ->take(5)
            ->get();
    }

    public function getNewArticle()
    {
        return Article::orderBy('created_at', 'desc')
            ->where('status', 'published')
            ->take(5)
            ->get();
    }

    public function getContributor()
    {
        return User::role('CONTRIBUTOR')
            ->withCount(['newsContributor', 'articleContributor'])
            ->orderByDesc('news_contributor_count')
            ->orderByDesc('article_contributor_count')
            ->take(4)
            ->get();
    }


    public function getLatestNews()
    {
        return News::orderBy('created_at', 'desc')
            ->where('status', 'published')
            ->take(5)
            ->get();
    }

    public function getWeeklyNews()
    {
        return News::where('created_at', '>=', Carbon::now()->subWeek()) // 1 minggu terakhir
            ->orderBy('click_count', 'desc') // Urutkan berdasarkan views
            ->where('status', 'published')
            ->take(5) // Ambil 5 artikel
            ->get(); // Ambil artikel
    }

    public function getContributorAll()
    {
        return User::role('CONTRIBUTOR')->get();
    }

    public function index()
    {
        $trending = $this->getTrending();
        $topTrending = [];
        $topTrendingArticle = [];

        if ($trending) {
            $topTrending = $this->getTopTrending($trending->id);
        }

        if ($topTrendingArticle) {
            $topTrendingArticle = $this->getTopTrendingArticle();
        }

        $newArticle = $this->getNewArticle();
        $contributor = $this->getContributor();
        $latestNews = $this->getLatestNews();
        $weeklyNews = $this->getWeeklyNews();
        $currentDate = Carbon::now()->translatedFormat('l, d F Y');

        return view('pages.home', compact('trending', 'topTrending', 'topTrendingArticle', 'newArticle', 'contributor', 'latestNews', 'weeklyNews', 'currentDate'));
    }

    public function profil()
    {
        $data = Profile::first();
        $contributor = $this->getContributorAll();

        return view('pages.profil', compact('data', 'contributor'));
    }

    public function berita(Request $request)
    {
        $topTrending = $this->getTopTrendingNews();
        $excludedIds = $topTrending->pluck('id')->toArray();

        // Ambil kata kunci pencarian
        $search = $request->query('search');

        // Jika ada kata kunci pencarian, filter data berdasarkan pencarian
        $dataQuery = News::whereNotIn('id', $excludedIds)
            ->where('status', 'published')
            ->latest();

        if ($search) {
            $dataQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        // Pagination data
        $data = $dataQuery->paginate(12);
        $currentDate = Carbon::now()->translatedFormat('l, d F Y');

        return view('pages.berita', compact('data', 'topTrending', 'currentDate'));
    }


    public function detailBerita(Request $request, $slug)
    {
        $data = News::where('slug', $slug)->with(['contributor', 'editor'])->firstOrFail();

        $ipAddress = $request->ip();
        $today = Carbon::today()->toDateString();

        $alreadyVisited = NewsVisitors::where('news_id', $data->id)
            ->where('ip_address', $ipAddress)
            ->whereDate('visit_date', $today)
            ->exists();

        if (!$alreadyVisited) {
            // Simpan data kunjungan baru
            NewsVisitors::create([
                'news_id' => $data->id,
                'ip_address' => $ipAddress,
                'visit_date' => $today,
            ]);

            // Tambahkan hitungan klik
            $data->increment('click_count');
        }
       
        // Ambil berita trending
        $topTrending = $this->getTopTrending($data->id);

        // Ambil berita "Baca Ini Juga" (random dari berita lainnya)
        $readAlso = News::where('id', '!=', $data->id) // Hindari berita yang sama
            ->where('status', 'published')
            ->inRandomOrder() // Ambil secara acak
            ->take(4) // Batasi jumlah berita
            ->get();

        return view('pages.detail-berita', compact('data', 'topTrending', 'readAlso'));
    }

    public function artikel(Request $request)
    {
        $categorySlug = $request->get('category'); // Ambil slug kategori dari request
        $search = $request->get('search'); // Ambil input pencarian
        $query = Article::where('status', 'published')->latest();

        // Filter berdasarkan kategori (slug)
        if ($categorySlug) {
            $category = CategoryArticle::where('slug', $categorySlug)->first();

            if ($category) {
                $query->where('category_article_id', $category->id);
            }
        }

        // Filter berdasarkan pencarian (title/content)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $article = $query->paginate(12);

        // Ambil daftar kategori untuk dropdown
        $categories = CategoryArticle::all();
        $currentDate = Carbon::now()->translatedFormat('l, d F Y');

        return view('pages.article', compact('article', 'categories', 'categorySlug', 'search', 'currentDate'));
    }

    public function detailArtikel(Request $request, $slug)
    {
        $data = Article::where('slug', $slug)->with(['articleContributor', 'articleEditor'])->firstOrFail();

        // Cek apakah user sudah mengunjungi artikel ini hari ini
        $ipAddress = $request->ip();
        $today = Carbon::today()->toDateString();

        $alreadyVisited = ArticleVisitor::where('articles_id', $data->id)
            ->where('ip_address', $ipAddress)
            ->whereDate('visit_date', $today)
            ->exists();

        if (!$alreadyVisited) {
            // Simpan data kunjungan baru
            ArticleVisitor::create([
                'articles_id' => $data->id,
                'ip_address' => $ipAddress,
                'visit_date' => $today,
            ]);

            // Tambahkan hitungan klik
            $data->increment('click_count');
        }

        // Ambil berita trending
        $topTrending = $this->getTopTrendingArticles($data->id);

        // Ambil berita "Baca Ini Juga"
        $readAlso = Article::where('id', '!=', $data->id)
            ->where('status', 'published')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pages.article-detail', compact('data', 'topTrending', 'readAlso'));
    }

    public function dokument(Request $request)
    {
        $query = Dokument::query();

        // Cek apakah ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $data = $query->paginate(20);
        $currentDate = Carbon::now()->translatedFormat('l, d F Y');

        return view('pages.document', compact('data', 'currentDate'));
    }
}
