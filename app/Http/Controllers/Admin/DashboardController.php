<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Product;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends AdminBaseController
{
    public function index()
    {
        $totalUsers = User::count();
        $totalTours = Product::count();
        $totalPosts = Post::count();
        $totalBookings = Booking::count();
        
        $revenueData = [];
        $labels = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = "Tháng " . $month->format('m/Y');
            
            $revenue = Booking::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price');
                
            $revenueData[] = (float) $revenue;
        }

        $thisMonthRevenue = $revenueData[5] ?? 0;
        
        $recentBookings = Booking::with(['user', 'product'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalTours', 'totalPosts', 'totalBookings',
            'labels', 'revenueData', 'thisMonthRevenue', 'recentBookings'
        ));
    }
}
