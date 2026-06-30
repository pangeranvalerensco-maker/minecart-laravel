<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $sellerId = auth()->id();

        // 1. Line Chart: Pendapatan Harian (30 hari terakhir)
        $dailyRevenue = OrderItem::whereHas('product', function($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->where('status', 'completed')
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DATE(updated_at) as date'), DB::raw('SUM(subtotal) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
            
        $chartDates = $dailyRevenue->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });
        $chartTotals = $dailyRevenue->pluck('total');

        // 2. Bar Chart: Top 5 Produk paling sering dibeli
        $topProducts = OrderItem::whereHas('product', function($q) use ($sellerId) {
                $q->where('user_id', $sellerId);
            })
            ->where('status', 'completed')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        $topProductNames = $topProducts->pluck('product_name');
        $topProductQuantities = $topProducts->pluck('total_sold');

        return view('seller.analytics', compact(
            'chartDates', 'chartTotals', 
            'topProductNames', 'topProductQuantities'
        ));
    }
}
