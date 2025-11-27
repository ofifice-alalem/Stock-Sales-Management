<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Store\StoreService;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function __construct(
        private readonly StoreService $storeService
    ) {}

    public function index(): View
    {
        $stores = $this->storeService->getStoresCards();
        return view('admin.stores.index', compact('stores'));
    }
}
