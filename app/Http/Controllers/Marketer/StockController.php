<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(): View
    {
        $marketerId = auth()->id();
        
        $products = DB::table('marketer_stock')
            ->join('products', 'marketer_stock.product_id', '=', 'products.id')
            ->where('marketer_stock.marketer_id', $marketerId)
            ->select('products.id', 'products.name', 'marketer_stock.quantity', 'products.price')
            ->get();
        
        $totalValue = $products->sum(fn($product) => $product->quantity * $product->price);
        
        return view('marketer.stock.index', compact('products', 'totalValue'));
    }
}
