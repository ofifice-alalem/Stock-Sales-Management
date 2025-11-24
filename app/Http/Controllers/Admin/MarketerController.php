<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\Marketer\StockTransactionDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Marketer\MarketerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketerController extends Controller
{
    public function __construct(
        private readonly MarketerService $marketerService
    ) {}

    public function index(Request $request): View
    {
        $marketers = $this->marketerService->getMarketersWithStock($request->input('search'));
        return view('admin.marketers.index', compact('marketers'));
    }

    public function addStockForm(int $marketerId): View
    {
        $products = Product::all();
        return view('admin.marketers.add-stock', compact('marketerId', 'products'));
    }

    public function addStock(Request $request, int $marketerId): RedirectResponse
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $dto = new StockTransactionDTO(
            marketerId: $marketerId,
            items: $request->input('items')
        );

        $this->marketerService->addStock($dto);

        return redirect()->route('admin.marketers.index')
            ->with('success', 'تم إضافة البضاعة بنجاح');
    }

    public function returnStockForm(int $marketerId): View
    {
        $marketerStock = $this->marketerService->getMarketerStock($marketerId);
        return view('admin.marketers.return-stock', compact('marketerId', 'marketerStock'));
    }

    public function returnStock(Request $request, int $marketerId): RedirectResponse
    {
        $items = collect($request->input('items'))
            ->filter(fn($item) => isset($item['quantity']) && $item['quantity'] > 0)
            ->values()
            ->toArray();

        if (empty($items)) {
            return redirect()->back()->with('error', 'يجب إدخال كمية لمنتج واحد على الأقل');
        }

        $dto = new StockTransactionDTO(
            marketerId: $marketerId,
            items: $items
        );

        $this->marketerService->returnStock($dto);

        return redirect()->route('admin.marketers.index')
            ->with('success', 'تم ترجيع البضاعة بنجاح');
    }
}
