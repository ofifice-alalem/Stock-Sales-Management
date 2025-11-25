<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketer;

use App\Http\Controllers\Controller;
use App\Services\Marketer\MarketerEarningsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class MarketerEarningsController extends Controller
{
    public function __construct(
        private readonly MarketerEarningsService $earningsService
    ) {
    }

    public function index(Request $request): View
    {
        $marketerId = $request->user()->id;
        $earnings = $this->earningsService->getEarnings($marketerId);

        return view('marketer.earnings.index', [
            'items' => $earnings->items,
            'totalEarnings' => $earnings->totalEarnings
        ]);
    }
}
