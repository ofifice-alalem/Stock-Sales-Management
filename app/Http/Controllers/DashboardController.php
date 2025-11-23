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
        $stats = [
            'products' => Product::count(),
            'invoices' => Invoice::count(),
            'stores' => Store::count(),
            'marketers' => User::whereHas('role', fn($q) => $q->where('name', 'marketer'))->count()
        ];

        return view('dashboard', compact('stats'));
    }
}