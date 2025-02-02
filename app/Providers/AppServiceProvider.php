<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\VisitorCount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $today = Carbon::today();

            $totalVisits = VisitorCount::count();
            $todayVisits = VisitorCount::whereDate('visit_date', $today)->count();
            $weekVisits = VisitorCount::whereBetween('visit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $monthVisits = VisitorCount::whereBetween('visit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $yearVisits = VisitorCount::whereYear('visit_date', Carbon::now()->year)->count();

            $view->with(compact('totalVisits', 'todayVisits', 'weekVisits', 'monthVisits', 'yearVisits'));
        });
    }
}
