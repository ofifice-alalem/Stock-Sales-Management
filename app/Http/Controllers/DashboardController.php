<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $roleName = $user->role->name;

        $stats = [
            'products' => Product::count(),
            'invoices' => Invoice::count(),
            'stores' => Store::count(),
            'marketers' => User::whereHas('role', fn($q) => $q->where('name', 'marketer'))->count()
        ];

        $recentActivities = [];
        $quickStats = [];

        if ($roleName === 'admin') {
            $recentActivities = \DB::table('activity_log')
                ->join('users', 'activity_log.user_id', '=', 'users.id')
                ->select('activity_log.*', 'users.name as user_name')
                ->orderBy('activity_log.created_at', 'desc')
                ->limit(5)
                ->get();

            $quickStats = [
                'total_stock_assignments' => \DB::table('stock_assignments')->count(),
                'pending_returns' => \DB::table('return_requests')->where('status', 'pending')->count(),
                'today_invoices' => Invoice::whereDate('created_at', today())->count(),
            ];
        } elseif ($roleName === 'storekeeper') {
            $recentActivities = \DB::table('stock_assignments')
                ->join('users', 'stock_assignments.marketer_id', '=', 'users.id')
                ->join('products', 'stock_assignments.product_id', '=', 'products.id')
                ->where('stock_assignments.approved_by', $user->id)
                ->select('stock_assignments.*', 'users.name as marketer_name', 'products.name as product_name')
                ->orderBy('stock_assignments.created_at', 'desc')
                ->limit(5)
                ->get();

            $quickStats = [
                'pending_returns' => \DB::table('return_requests')->where('status', 'pending')->count(),
                'approved_today' => \DB::table('stock_assignments')->where('approved_by', $user->id)->whereDate('created_at', today())->count(),
            ];
        } elseif ($roleName === 'marketer') {
            $recentActivities = Invoice::where('marketer_id', $user->id)
                ->with('store')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $myStock = \DB::table('marketer_stock')
                ->join('products', 'marketer_stock.product_id', '=', 'products.id')
                ->where('marketer_stock.marketer_id', $user->id)
                ->select('products.name', 'marketer_stock.quantity')
                ->get();

            $quickStats = [
                'my_invoices' => Invoice::where('marketer_id', $user->id)->count(),
                'today_invoices' => Invoice::where('marketer_id', $user->id)->whereDate('created_at', today())->count(),
                'my_stock_items' => $myStock->count(),
            ];
        }

        return view('dashboard', compact('stats', 'recentActivities', 'quickStats', 'roleName'));
    }
}