<?php

declare(strict_types=1);

namespace App\Http\Controllers\Marketer;

use App\DTOs\Invoice\CreateInvoiceDTO;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Repositories\Interfaces\MarketerRepositoryInterface;
use App\Services\Invoice\InvoiceService;
use App\Services\Invoice\InvoicePdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MarketerInvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
        private readonly MarketerRepositoryInterface $marketerRepository,
        private readonly InvoicePdfService $pdfService
    ) {}

    public function index(Request $request): View
    {
        $marketerId = (int)auth()->id();
        
        $invoices = $this->invoiceService->getAllInvoices(
            $request->input('invoice_number'),
            $marketerId,
            $request->input('store_id') ? (int)$request->input('store_id') : null
        );
        
        $stores = Store::all();
        
        return view('marketer.invoices.index', compact('invoices', 'stores'));
    }

    public function create(): View
    {
        $stores = Store::all();
        $products = $this->marketerRepository->getMarketerStockWithDetails((int)auth()->id());
        
        return view('marketer.invoices.create', compact('stores', 'products'));
    }

    public function show(int $id): View
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        
        if ($invoice->marketer_id !== auth()->id()) {
            abort(403);
        }
        
        return view('marketer.invoices.show', compact('invoice'));
    }

    public function edit(int $id): View
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        
        if ($invoice->marketer_id !== auth()->id()) {
            abort(403);
        }
        
        $stores = Store::all();
        $products = $this->marketerRepository->getMarketerStockWithDetails((int)auth()->id());
        
        return view('marketer.invoices.edit', compact('invoice', 'stores', 'products'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        $marketerId = (int)auth()->id();
        
        if ($invoice->marketer_id !== $marketerId) {
            abort(403);
        }
        
        $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number,' . $id,
            'store_id' => 'required|exists:stores,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);
        
        foreach ($invoice->items as $oldItem) {
            $this->marketerRepository->addStock(
                $marketerId,
                $oldItem->product_id,
                $oldItem->quantity
            );
        }

        $invoiceDTO = new CreateInvoiceDTO(
            invoiceNumber: $request->input('invoice_number'),
            marketerId: $marketerId,
            storeId: (int)$request->input('store_id'),
            totalAmount: null
        );

        $this->invoiceService->updateInvoiceWithItems($id, $invoiceDTO, $request->input('items'));
        
        foreach ($request->input('items') as $item) {
            $this->marketerRepository->removeStock(
                $marketerId,
                (int)$item['product_id'],
                (int)$item['quantity']
            );
        }

        return redirect()->route('marketer.invoices.index')
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function store(Request $request): RedirectResponse
    {
        $marketerId = (int)auth()->id();
        
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad((string)(\App\Models\Invoice::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT);

        $invoiceDTO = new CreateInvoiceDTO(
            invoiceNumber: $invoiceNumber,
            marketerId: $marketerId,
            storeId: (int)$request->input('store_id'),
            totalAmount: null
        );

        $this->invoiceService->createInvoiceWithItems($invoiceDTO, $request->input('items'));
        
        foreach ($request->input('items') as $item) {
            $this->marketerRepository->removeStock(
                $marketerId,
                (int)$item['product_id'],
                (int)$item['quantity']
            );
        }

        return redirect()->route('marketer.invoices.index')
            ->with('success', 'تم إضافة الفاتورة بنجاح');
    }

    public function destroy(int $invoiceId): RedirectResponse
    {
        $invoice = $this->invoiceService->getInvoiceById($invoiceId);
        $marketerId = (int)auth()->id();
        
        if ($invoice->marketer_id !== $marketerId) {
            abort(403);
        }
        
        foreach ($invoice->items as $item) {
            $this->marketerRepository->addStock(
                $marketerId,
                $item->product_id,
                $item->quantity
            );
        }
        
        $this->invoiceService->deleteInvoice($invoiceId);

        return redirect()->route('marketer.invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }

    public function downloadPdf(int $id): Response
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        
        if ($invoice->marketer_id !== auth()->id()) {
            abort(403);
        }
        
        return $this->pdfService->generatePdf($id);
    }
}
