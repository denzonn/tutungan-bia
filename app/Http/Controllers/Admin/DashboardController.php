<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Dokument;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $articleCount = Article::count();
        $newsCount = News::count();
        $documentCount = Dokument::count();

        return view('pages.admin.dashboard', compact('userCount', 'articleCount', 'newsCount', 'documentCount'));
    }
}
