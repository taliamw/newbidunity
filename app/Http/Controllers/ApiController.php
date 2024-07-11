<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bid;
use App\Models\NewProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{

    public function getUsersAndAdminsCount()
    {
        $usersCount = User::where('role', 'user')->count();
        $adminsCount = User::where('role', 'admin')->count();

        return response()->json([
            'users' => $usersCount,
            'admins' => $adminsCount,
        ]);
    }

    public function bidsPerDay()
    {
        $bids = Bid::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                   ->groupBy('date')
                   ->get();

        $dates = $bids->pluck('date');
        $counts = $bids->pluck('count');

        return response()->json(['dates' => $dates, 'counts' => $counts]);
    }

    public function revenueOverTime()
    {
        $revenue = Bid::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
                      ->groupBy('date')
                      ->get();

        $dates = $revenue->pluck('date');
        $totals = $revenue->pluck('total');

        return response()->json(['dates' => $dates, 'totals' => $totals]);
    }

    public function topBiddingUsers()
    {
        $users = User::withCount('bids')
                     ->orderBy('bids_count', 'desc')
                     ->take(10)
                     ->get();

        $names = $users->pluck('name');
        $counts = $users->pluck('bids_count');

        return response()->json(['names' => $names, 'counts' => $counts]);
    }

    public function topBiddedProducts()
    {
        $products = NewProduct::withCount('bids')
                              ->orderBy('bids_count', 'desc')
                              ->take(10)
                              ->get();

        $names = $products->pluck('name');
        $counts = $products->pluck('bids_count');

        return response()->json(['names' => $names, 'counts' => $counts]);
    }
}
